# Permissoes, Perfis e Controle de Acesso

Este documento registra as regras de acesso do sistema de Admissibilidade: quais perfis existem, quais abas podem acessar, quais status podem operar e como funciona o fluxo de aprovacao na Aba 7.

---

## 1. Perfis do Sistema

O sistema utiliza **Spatie Permission** com 9 roles definidas no `RoleSeeder` (`database/seeders/RoleSeeder.php:15-25`):

1. Equipe Destinacao
2. Equipe Caracterizacao
3. Chefia
4. Coordenacao
5. Superintendencia
6. Equipe C.G.
7. Coordenacao-Geral
8. Direcao
9. CDE

Cada usuario possui exatamente uma role. A role e resolvida pelo metodo `getPerfilAtual()` (`ProcessoController.php:600-629`). Usuarios com perfil `Direcao` podem simular qualquer outro perfil via cookie `perfil_simulado`.

---

## 2. Abas por Perfil

Definido em `getAbasDoPerfil()` (`ProcessoController.php:111-126`):

| Perfil               | Aba 1 | Aba 2 | Aba 3 | Aba 7 |
|----------------------|:-----:|:-----:|:-----:|:-----:|
| Equipe Destinacao    |   X   |   X   |   X   |   -   |
| Equipe Caracterizacao|   X   |   X   |   -   |   -   |
| Chefia               |   -   |   -   |   -   |   X   |
| Coordenacao          |   -   |   -   |   -   |   X   |
| Superintendencia     |   -   |   -   |   -   |   X   |
| Equipe C.G.          |   -   |   -   |   -   |   X   |
| Coordenacao-Geral    |   -   |   -   |   -   |   X   |
| Direcao              |   -   |   -   |   -   |   X   |
| CDE                  |   -   |   -   |   -   |   X   |

Abas 4, 5 e 6 ainda nao existem no sistema.

---

## 3. Status Operaveis por Perfil

Definido em `perfilPodeOperar()` (`ProcessoController.php:75-109`):

| Perfil               | Status que pode operar                                    |
|----------------------|-----------------------------------------------------------|
| Equipe Destinacao    | Aguardando Analise, Indicacao do Imovel, Diagnostico Preliminar, Analise de Viabilidade |
| Equipe Caracterizacao| Indicacao do Imovel, Diagnostico Preliminar               |
| Chefia               | Analise de Viabilidade, Validacao - Chefia                |
| Coordenacao          | Analise de Viabilidade, Validacao - Coordenacao           |
| Superintendencia     | Analise de Viabilidade, Deliberacao - Superintendencia    |
| Equipe C.G.          | Analise de Viabilidade, Validacao - Equipe C.G.           |
| Coordenacao-Geral    | Analise de Viabilidade, Validacao - Coordenacao-Geral     |
| Direcao              | Analise de Viabilidade, Validacao - Direcao               |
| CDE                  | Analise de Viabilidade, Deliberacao - CDE                 |

---

## 4. Transicao de Status (Qual Aba ao Abrir)

Definido em `getAbaEStatus()` (`ProcessoController.php:21-73`):

| Perfil               | Status atual             | Aba aberta | Proximo status             |
|----------------------|--------------------------|:----------:|----------------------------|
| Equipe Destinacao    | Aguardando Analise       |     1      | Indicacao do Imovel        |
| Equipe Destinacao    | Indicacao do Imovel      |     2      | Diagnostico Preliminar     |
| Equipe Destinacao    | Diagnostico Preliminar   |     3      | Analise de Viabilidade     |
| Chefia               | Validacao - Chefia       |     7      | (tramita)                  |
| Coordenacao          | Validacao - Coordenacao  |     7      | (tramita)                  |
| Superintendencia     | Deliberacao - Superintendencia |  7      | (tramita)                  |
| Equipe C.G.          | Validacao - Equipe C.G.  |     7      | (tramita)                  |
| Coordenacao-Geral    | Validacao - Coordenacao-Geral |  7      | (tramita)                  |
| Direcao              | Validacao - Direcao      |     7      | (tramita)                  |
| CDE                  | Deliberacao - CDE        |     7      | (tramita)                  |

---

## 5. Fluxo de Aprovacao na Aba 7 (Cadeia de Assinatura)

Definido em `tramitar()` (`ProcessoController.php:489-551`):

| Quem assina           | Se APROVA -> Status                    | Se DEVOLVE -> Status                  |
|-----------------------|----------------------------------------|---------------------------------------|
| Chefia                | Validacao - Coordenacao                | Analise de Viabilidade                |
| Coordenacao           | Deliberacao - Superintendencia         | Analise de Viabilidade                |
| Superintendencia      | Validacao - Equipe C.G.                | Analise de Viabilidade                |
| Equipe C.G.           | Validacao - Coordenacao-Geral          | *(nao pode devolver)*                 |
| Coordenacao-Geral     | Validacao - Direcao                    | Deliberacao - Superintendencia        |
| Direcao               | Deliberacao - CDE                      | Validacao - Coordenacao-Geral         |
| CDE                   | Concluido / Deliberacao Superintendencia *(depende de competencia_cde)* | *(nao devolve)* |

### Regras especiais do fluxo:
- **Equipe C.G.** e a unica equipe que **nao pode devolver** (apenas aprova).
- **CDE** tambem nao possui botao de devolucao.
- A secao editavel na Aba 7 e determinada pelo `status_atual` do processo (so uma secao fica ativa por vez).

---

## 6. Controle de Acesso por Rota

Definido no metodo `abrir()` (`ProcessoController.php:212-235`):

- Antes de abrir um processo, o controller verifica se o perfil do usuario e compativel com o `status_atual` do processo atraves de `perfilPodeOperar()`.
- Se o perfil nao tiver permissao para operar naquele status, o acesso e negado.
- **Nao existem middleware de roles** nas rotas — toda verificacao e feita imperativamente no controller.

---

## 7. Features Administrativas

- **Simulacao de Perfil**: Apenas usuarios com perfil `Direcao` podem acessar o seletor de perfil no index (`resources/views/processos/index.blade.php:75-91`), permitindo operar como qualquer outro perfil.

---

## 8. Arquivos de Referencia

| Arquivo | Responsabilidade |
|---------|-----------------|
| `database/seeders/RoleSeeder.php` | Definicao das 9 roles |
| `database/seeders/UserSeeder.php` | Atribuicao de role aos usuarios de teste |
| `app/Models/User.php` | Trait `HasRoles` do Spatie |
| `app/Http/Controllers/ProcessoController.php` | Logica de permissao, transicao e tramitacao |
| `resources/views/processos/show.blade.php` | Renderizacao condicional das abas |
| `resources/views/processos/abas/aba7.blade.php` | Controle interno de secoes por perfil |
| `resources/views/processos/index.blade.php` | Simulacao de perfil (Direcao) |
