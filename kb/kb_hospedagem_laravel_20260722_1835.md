# Base de Conhecimento: Hospedagem e Deploy de Projetos Laravel

**Data:** 22/07/2026
**Tópico:** Transição de Serverless (Vercel) para ambientes Stateful (Laravel)

Este documento registra as opções arquiteturais recomendadas para publicação (deploy) de sistemas em PHP/Laravel, substituindo o ecossistema estático/serverless da Vercel por plataformas compatíveis com aplicações que mantêm estado (sessões, jobs e armazenamento local).

---

## O Problema com a Vercel para Laravel
A Vercel é voltada para aplicações *Serverless* (sem servidor dedicado) e *Frontend* (React, Next.js). Embora existam adaptações para rodar PHP nela, o Laravel é um sistema **Stateful (com estado)** e Monolítico. Ele precisa escrever sessões em disco, salvar logs, fazer upload de arquivos e rodar processos contínuos em segundo plano. Ambientes serverless "congelam" ou "destroem" o ambiente após a requisição, o que quebra essas funcionalidades nativas do framework.

---

## Alternativas de Deploy (O "Combo" GitHub -> Auto Deploy)

Para replicar a experiência mágica de *"Fazer um Push na branch main do GitHub e o sistema atualizar sozinho"*, existem três caminhos principais consolidados na indústria para Laravel:

### 1. Railway (O mais próximo da Vercel para Back-end)
*   **Perfil:** Excelente para provas de conceito (POCs), validações com clientes, staging ou projetos de pequeno/médio porte.
*   **Vantagens:** Integração nativa com GitHub. Detecta o `composer.json` e configura PHP e Nginx automaticamente. Permite acoplar um banco de dados Postgres ou MySQL com um clique na mesma interface.
*   **Fluxo:** Push no Github -> Railway faz o build (composer install, npm run build) -> Substitui os containers sem downtime.

### 2. Render
*   **Perfil:** Concorrente direto do Railway, com foco forte em PaaS (Platform as a Service) flexível.
*   **Vantagens:** Suporte nativo para workers (serviços em segundo plano, ótimos para o sistema de Filas do Laravel) e Cronjobs (Tarefas agendadas).
*   **Fluxo:** Push no Github -> Executa o script de build customizado -> Coloca no ar.

### 3. Laravel Forge + VPS (DigitalOcean / AWS)
*   **Perfil:** O "Padrão Ouro" da indústria. Recomendado para produção real e escala empresarial.
*   **Vantagens:** Controle total sobre os recursos. Muito mais barato em larga escala. O Forge é uma ferramenta oficial do ecossistema Laravel que provisiona um servidor Linux "limpo" instalando e otimizando toda a stack necessária (Nginx, PHP, Redis, Banco de Dados).
*   **Fluxo:** Você contrata um servidor VPS de 6 dólares (ex: DigitalOcean). O Forge se conecta a ele e ao GitHub. No push, o Forge entra no servidor via SSH, atualiza os arquivos e reinicia graciosamente os serviços.

---

## Abordagem de Banco de Dados na Transição
Se o projeto já utilizava **Supabase** no desenvolvimento ou nas versões Serverless, a arquitetura de banco não precisa mudar. Como o Supabase é um PostgreSQL gerenciado, basta conectar a nova hospedagem (Railway, Forge, etc.) ao banco via URL de conexão inserida nas variáveis de ambiente (`.env`). Não há acoplamento rígido entre o local de hospedagem do Laravel e onde os dados estão residindo.
