# Lista de Pendências e Próximos Módulos (Todo-List)

**Data de Atualização:** 22/07/2026

Este documento serve como roteiro norteador para as próximas fases de desenvolvimento do sistema SPUnet. As interfaces de visualização, formulários e integração com o banco de dados base (Aba 1, 2, 3 e Painel) estão estabilizados. O foco agora se volta para a governança interna e roteamento gerencial do sistema.

---

## ⏳ Módulos e Subsistemas a Implantar / Aprimorar

### 1. Subsistema de Atribuição de Atividades
*   **Objetivo:** Permitir que coordenadores ou chefias distribuam requerimentos específicos (ou blocos de processos) para analistas/técnicos da sua equipe.
*   **Requisitos:**
    *   Painel de delegação de tarefas (quem faz o quê).
    *   Fila de trabalho individual ("Meus Processos" baseados na atribuição e não apenas na autoria).
    *   Métricas de prazo e controle de devoluções (handoff entre setores).

### 2. Montagem de Equipes
*   **Objetivo:** Agrupar usuários em células operacionais lógicas (ex: Equipe de Caracterização, Equipe de Destinação, Coordenação-Geral, Chefias).
*   **Requisitos:**
    *   Painel CRUD (Criar, Ler, Atualizar, Deletar) de grupos/departamentos.
    *   Associação de N:N entre servidores (usuários) e as equipes.
    *   Restrição de visualização de painel com base na equipe (o técnico só vê os processos tramitados para o balcão da equipe dele).

### 3. Configuração Geral do Sistema
*   **Objetivo:** Tela administrativa de alto nível para gerir parâmetros globais que ditam o comportamento do software sem precisar alterar o código-fonte.
*   **Requisitos:**
    *   Tabela de configurações (`settings` ou `opcoes_sistema`) com chave-valor.
    *   Interface para habilitar/desabilitar manutenções, ajustar prazos de SLA padrão (ex: "tempo limite na etapa 3 é de 10 dias").
    *   Personalização de templates de texto (respostas padrão de manifestação ou mensagens de sistema).

### 4. Painel de Informações Estratégicas (Dashboard BI)
*   **Objetivo:** Visão analítica de altíssimo nível (CDE / Direção) do gargalo operacional e vazão de processos no país.
*   **Requisitos:**
    *   Gráficos ou totalizadores de "Processos por Status" (Quantos na fila de indicação, quantos aguardando viabilidade).
    *   Agrupamento geográfico (Processos por UF/Município).
    *   Métricas de produtividade e tempo médio de resolução (TMA).
    *   Layout focado em "apenas leitura" para tomadores de decisão (visão helicóptero).
