# Relatório de Migração Arquitetural: Protótipo HTML para Laravel (Foco-15)

## 1. Visão Geral da Transformação
O projeto foi migrado de um protótipo estático (HTML/JS + LocalStorage) para uma aplicação full-stack robusta utilizando **PHP 8.4** e **Laravel 11**. A transição focou em manter a fidelidade visual do layout e a interatividade dos scripts originais, substituindo a persistência simulada no front-end por um banco de dados relacional real (SQLite) e uma arquitetura MVC.

## 2. Arquitetura de Banco de Dados (Database Schema)
O banco de dados adotado foi o **SQLite**, focado em simplicidade para esta fase. Foram criadas as seguintes entidades principais:

### 2.1. `processos`
Tabela central que gerencia o fluxo de trabalho principal.
- **Campos Chave**: `id`, `numero_requerimento` (único, ex: PR2026001), `tipo_requerimento`, `uf`, `status_atual`, `tramitacao`.
- **Propósito**: Controlar o cabeçalho e o estado atual do requerimento no pipeline.

### 2.2. `tramites` (Versionamento e Histórico)
Tabela projetada para salvar o histórico e os "rascunhos" (drafts) do processo de forma imutável.
- **Campos Chave**: `id`, `processo_id` (Foreign Key), `etapa`, `acao`, `usuario_id`, `justificativa`, `dados_snapshot` (JSON).
- **Propósito**: Em vez de atualizar diretamente colunas de formulário na tabela `processos`, o sistema adota um padrão de Event Sourcing simplificado. Cada vez que o usuário "Salva" ou "Tramita", um novo `tramite` é gerado contendo um JSON (`dados_snapshot`) com o estado exato de todos os inputs do formulário. A visualização atual do formulário sempre carrega o `$dados_snapshot` do trámite mais recente.

### 2.3. `requerimentos` (Simulação do Portal SPU)
Tabela isolada que simula uma base de dados externa (Portal de Serviços).
- **Campos Chave**: `numero_requerimento` (Primary Key, ex: PR2026001), `cpf_cnpj_requerente`, `nome_requerente`, `documentos_anexados` (JSON com links simulados de PDFs), etc.
- **Propósito**: Prover dados fixos/read-only para a **Aba 1**, alimentando dinamicamente os formulários sem misturar dados do cidadão com os dados de tramitação interna.
- **Comportamento UI**: Todos os campos provenientes desta tabela foram configurados como `readonly` no HTML (Aba 1) e suas amarras `required` foram removidas para não bloquearem o formulário de tramitação gerencial.

### 2.4. ACL (Access Control List)
- Implementado via **Spatie Laravel-Permission**.
- **Tabelas**: `users`, `roles`, `permissions`, `model_has_roles`.
- **Roles Criadas**: `Admin` e `Equipe Destinação`.
- **Propósito**: Preparar o terreno para lógicas de autorização na interface (ex: desabilitar formulários caso o usuário não pertença à *Equipe Destinação*).

## 3. Arquitetura de Interface e Rotas (Views & Controllers)

### 3.1. Roteamento e Controllers
- A rota `/processos/{id}` aponta para `ProcessoController@show`.
- O controlador captura o parâmetro de query `?aba=N` para gerenciar a navegação sem recarregar layouts inteiros, atuando como um *Dispatcher*.
- A rota de submissão `POST /processos/{id}/tramitar` aponta para `ProcessoController@tramitar`, que capta o `$_POST`, faz um `array_merge` com o JSON do trámite anterior (para não perder campos de abas inativas) e salva o novo trámite no banco.

### 3.2. Estrutura Blade (Views)
- **`show.blade.php`**: É o layout mestre da tela do processo. Contém o cabeçalho (menu superior de botões circulares) e o contêiner dinâmico (`main-content`).
- **`abas/aba1.blade.php`, `aba2.blade.php`, etc**: São parciais injetados no layout principal através de lógicas `@if($aba == 1) @include(...)`. 
- **Data Binding**: Os inputs da interface possuem marcações Blade. Na Aba 1, os dados base vêm diretamente da tabela `requerimentos` e não do JSON de `tramites`. 
- **Escape de Variáveis**: O Laravel Blade não tolera barras invertidas escapadas (`\'`) dentro das expressões `{{ }}`. Sempre utilize aspas simples puras (`''`) ao fazer coalescência nula no Blade.

## 4. Integração do Legado (JavaScript e CSS)
- **CSS**: Todos os estilos (`index.css`, `dashboard.css`, `styles-forms.css`) foram centralizados na pasta `public/css`.
- **JavaScript**: Scripts como `foco-01.js`, `hints.js` e `custom-select.js` continuam existindo em `public/js` e são importados nas views. 
- **Refatoração JS**: Foi necessário resolver conflitos de eventos. Por exemplo, o script `foco-01.js` já possuía `EventListeners` que escutavam botões como o "Adicionar Imóvel/Área". A tentativa de adicionar `onclick` diretamente no HTML gerava um toggle duplo (abria e fechava no mesmo milissegundo). A recomendação para a próxima IA é **sempre verificar se os arquivos legados já gerenciam o DOM daquele componente** antes de injetar eventos inline.

## 5. Pendências e Próximos Passos
Para a próxima inteligência artificial que for continuar este projeto, os seguintes pontos precisam de atenção:
1. **Migração das Demais Abas**: A estrutura modular (`ProcessoController` e `show.blade.php`) já está pronta para receber a injeção do HTML das abas 2, 3 e 7.
2. **Desacoplamento do LocalStorage**: Existem scripts legados (como `sync.js` e `db.js`) no repositório antigo que salvavam rascunhos no cache do navegador. No Laravel, a função de salvar rascunhos deve ser inteiramente mapeada para a criação de um novo registro na tabela `tramites`, abandonando o LocalStorage.
3. **Roles e Autorização (Fieldsets)**: A proteção condicional dos campos usando `<fieldset disabled>` foi momentaneamente desativada na Aba 1 para facilitar os testes, mas a estrutura do Blade `@if(!auth()->user()->hasRole('Equipe Destinação'))` deve ser lapidada e reimplantada.
