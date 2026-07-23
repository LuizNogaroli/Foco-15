# Plano de Migração para PHP Laravel + PostgreSQL (Foco-15)

Este documento descreve o plano técnico detalhado para a refatoração do protótipo atual (HTML/JS) para uma arquitetura robusta baseada em Laravel. Este plano foi desenhado para garantir uma transição suave, começando pela dor principal atual: Gestão de Equipes e Perfis de Acesso (RBAC).

## 1. Fundação do Projeto (Configuração Inicial)
Nesta fase, prepararemos o terreno no novo diretório `Foco-15`.

**Arquivos Core do Laravel:**
- Inicializar um novo projeto Laravel padrão dentro da pasta `Foco-15`.
- Configurar o arquivo `.env` para se conectar diretamente ao banco PostgreSQL do Supabase.

**Camada de Autenticação:**
- Instalar o Laravel Breeze (para scaffolding rápido de login, senha e sessão).
- Instalar o `spatie/laravel-permission` para criar a infraestrutura de Papéis (Roles) e Permissões.

## 2. O Novo Módulo de Configurações (Admin Panel)
Focaremos primeiro no problema levantado na sessão anterior: a mecânica de montar equipes.

**Migrations e Models:**
- Ajustar a migration de `users` para incluir o campo `uf` (Unidade da Federação).
- Criar os Seeders para popular o banco com os papéis oficiais ("Equipe SPU/UF", "Chefia SPU/UF", "Coordenação SPU/UF", "Superintendência").

**ConfiguracoesController.php:**
- Lógica no backend para listar usuários do banco.
- Funções para atribuir papéis (Roles) aos usuários, substituindo a gravação em bloco único (JSON) por relações reais no banco.

**Views (Blade):**
- Migrar o HTML puro do `configuracoes.html` atual para o sistema de templates do Laravel (`configuracoes.blade.php`).
- Integrar com o CSS já existente (`configuracoes.css`) para manter a exata mesma identidade visual.
- Substituir o JavaScript complexo de chamadas de API por envios de formulários nativos do Laravel (muito mais seguros).

## 3. Transição do Painel Gerencial (Dashboard)
Após a equipe estar configurada, migraremos a tela principal.

**DashboardController.php e dashboard.blade.php:**
- Fazer a tela principal ler as informações do banco de dados relacional.
- Exibir a tabela de requerimentos (mantendo o layout atual `dashboard.css`), mas com os dados sendo pré-processados pelo servidor Laravel.

---
*Gerado em 18/07/2026 para acompanhar a cópia para Foco-15.*
