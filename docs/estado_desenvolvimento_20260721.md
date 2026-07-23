# Relatório de Estado do Desenvolvimento - Foco 15 (21/07/2026)

## 1. Estado Atual do Desenvolvimento
O projeto encontra-se em fase intensiva de integração e estabilização do fluxo de requerimentos e formulários dinâmicos (Abas 1, 2 e 3). Nas sessões recentes, o foco central tem sido garantir a correta persistência de dados entre o frontend (Supabase e `localStorage`) e o backend (MySQL via Laravel), além de assegurar que a interface responda corretamente às permissões de perfis de usuário (`perfil_simulado`) e renderize os relatórios das etapas anteriores nas abas de aprovação.

## 2. Problemas Resolvidos Recentemente

### 2.1. Navegação, Salvamento e Fluxo de Status
*   **Problema:** A mudança manual de status do processo ("Indicação do Imóvel", "Diagnóstico Preliminar", "Análise de Viabilidade") gerava erros ao gravar na base, e o envio dos formulários das Abas 2 e 3 não atualizava automaticamente a etapa no banco de dados.
*   **Solução Implementada:** Normalização da formatação do código do processo (sempre usando o prefixo `AC`), padronização do salvamento do status na rota `ProcessoController@tramitar` (`$effectiveAba`), e criação da função auxiliar `syncProcessoStatusToSupabase()` para garantir a consistência dupla entre MySQL e Supabase.

### 2.2. Perfis de Usuário e Bloqueios Incorretos (Fieldsets)
*   **Problema:** Perfis administrativos ou simulados (`Administrador`, `Técnico - Destinação`) encontravam os inputs, checkboxes e acordeões de resumo das Abas 2 e 3 travados (`<fieldset disabled>`). 
*   **Solução Implementada:** Adicionadas validações rigorosas em `aba2.blade.php`, `aba3.blade.php` e `aba7.blade.php` considerando cookies de perfil (`request()->cookie('perfil_simulado')`) e permissões nativas. Elementos clicáveis, como os acordeões de resumo das abas anteriores, foram retirados de dentro das tags `<fieldset disabled>` para contornar bloqueios padrão dos navegadores (Chrome/Edge).

### 2.3. Resumo Visual (Relatórios Finais das Abas 1 e 2)
*   **Problema:** O layout dos formulários de revisão nas Abas seguintes aparecia quebrado ou vazio (Ex: "Nenhum relatório salvo").
*   **Solução Implementada:** 
    *   Correção do apontamento `CURRENT_PROCESS_ID` no `show.blade.php` (de ID numérico para o Número do Requerimento formatado).
    *   Duplicação e ajuste do carregamento das folhas de estilo `report.css`.
    *   Correção nas chamadas de propriedades em `foco-02-resumo.html` (substituição de `data[0].updated_at` null por `dateObj`).
    *   Adição de *fallback* para buscar resumos na `tabela_requerimentos` quando ausentes na `tabela_relatorios`.

### 2.4. Informações do Imóvel SPU (Abas 1 e 3)
*   **Problema A (Aba 1):** Ao inserir o RIP e salvar, se o usuário recarregasse a Aba 1, o RIP não reaparecia na interface.
    *   **Solução:** Inclusão do script de integração `db.js` no arquivo de layout mestre e integração com propriedades inline do Laravel (`@json($processo->foco->rips)`) permitindo o recarregamento instatâneo no frontend.
*   **Problema B (Aba 3):** O bloco de RIP exibia a mensagem de carregamento infinita *"Carregando informações dos imóveis..."*.
    *   **Solução:** Identificado que o script `fetch_spu.js` estava sendo carregado sem o `asset()` base e gerando erros 404, e que havia um **erro de sintaxe** crítico no final de `aba3.blade.php` (funções `toggleBloco` e `limparErro` duplicadas) que abortava completamente as threads JavaScript. Ao remover as duplicatas e corrigir as chamadas, a busca via API carregou com sucesso.

---

## 3. Problemas e Desafios Atuais

Embora os principais gargalos de interface e de roteamento da Aba 1, 2 e 3 tenham sido contornados, permanecemos monitorando:
1.  **Sincronia Distribuída (Supabase x MySQL):** A manutenção de duas fontes da verdade exige chamadas sequenciais precisas. Se uma aba for preenchida, mas a submissão falhar pela metade, pode ocorrer inconsistência entre o painel de status do Laravel e o estado JSON gravado no Supabase.
2.  **Validação de Negócio vs. Campos Ocultos:** Certificar-se de que os dados das abas mais complexas (como os inputs dinâmicos de caracterização que aparecem condicionalmente) chegam preenchidos corretamente no POST do backend e não são descartados como nulos por estarem em blocos ocultos na interface.
3.  **Transição de Etapas Futuras (Abas 4 em diante):** A estrutura que criamos para as Abas 1 a 3 precisará ser fielmente replicada ou reutilizada sem quebrar os dados de `formDataState`.

## 4. Possíveis Alternativas de Solução e Próximos Passos

Para elevar a resiliência da aplicação, recomendamos as seguintes alternativas/iniciativas para as próximas sessões:

*   **Alternativa A: Unificação do Submit (Single Source of Truth na Escrita)**
    *   *O que é:* Em vez de tentar sincronizar o Supabase via JavaScript primeiro e, depois, postar os dados via formulário HTML para o MySQL/Laravel, centralizar o envio.
    *   *Como:* Fazer com que o `ProcessoController@tramitar` do Laravel faça o *upsert* tanto no MySQL quanto via API Rest no Supabase (usando `Http::post`). Isso garante uma operação atômica e reduz a quantidade de JS responsável por gravar dados sensíveis.
*   **Alternativa B: Webhooks no Supabase (Background Sync)**
    *   *O que é:* O frontend interage exclusivamente com o Supabase. O banco Laravel se torna passivo.
    *   *Como:* Quando um registro sofre `UPDATE` ou `INSERT` na `tabela_requerimentos` no Supabase, um Webhook/Edge Function é engatilhado notificando o backend do Laravel para atualizar seu MySQL localmente de forma assíncrona.
*   **Alternativa C: Refatoração de Scripts Longos (Modularização)**
    *   *O que é:* Os arquivos `aba3.blade.php` e `foco-01.js` tornaram-se muito extensos, e o acoplamento de lógica de exibição com integrações de dados abre brechas para erros de sintaxe (como a duplicação do `toggleBloco`).
    *   *Como:* Separar toda a lógica de API (`fetch_spu`, persistência no Supabase) para dentro de módulos independentes (Webpack, Vite ou classes de JS isoladas), deixando os arquivos `.blade.php` puramente dedicados à árvore de tags (DOM) e recebendo estado (State) de forma mais declarativa.

---

## 5. Melhorias de Interface (Sessão 21/07/2026 — Tarde)

### 5.1. Remoção de Bordas Cinzas nas Abas 1, 2 e 3
*   **Problema:** Bordas cinzas (`1px solid #cbd5e1`, `1px solid #e2e8f0`) apareciam em accordions, fieldsets, checklist items e corpos de acordeões nas Abas 1, 2 e 3, criando visual poluído.
*   **Solução:** Padronizado o reset visual em todas as três abas seguindo o padrão da Aba 1:
    *   `aba1.blade.php`: `fieldset { border: none !important; }`, `.accordion-item { border: none !important; }`, `.accordion-body { border-top: none; }`
    *   `aba2.blade.php`: Adicionado `fieldset { border: none !important; }` no topo do `<style>`, `.accordion-item { border: none; }` (sem `!important` para preservar o border intencional do accordion de revisão), `.accordion-body { border-top: none; }`
    *   `aba3.blade.php`: `fieldset { border: none !important; }`, `.acordeao-wrapper { border: none; }`, `.acordeao-corpo { border-top: none; }`, `.decl-check-item { border: none; }`

### 5.2. Título do Requerimento na Aba 1
*   **Alteração:** O título da Aba 1 foi alterado de `Requerimento / Nº PR2026003` para `Requerimento / [Tipo de Requerimento]`.
*   **Word-wrap:** Adicionado `word-wrap: break-word; overflow-wrap: break-word;` na classe `.doc-numero` para que textos longos quebrem linha ao ultrapassar a largura do box.

### 5.3. Padronização do Campo "Tipo de Requerimento"
*   **Problema:** O campo `tipo_requerimento` na Aba 1 possuía overrides inline (`background: transparent; border: none; font-weight: 500; color: #1e293b;`) que o diferenciavam visualmente dos demais campos.
*   **Solução:** Removidos os overrides inline, permitindo herdar o estilo padrão do `.form-group.inline > input[readonly]`.

### 5.4. Toggle Padrão/Gerencial — Layout dos Filtros
*   **Alteração:** O seletor de view (Padrão/Gerencial) no painel de requerimentos recebeu `margin-left: 50px` para ficar alinhado próximo ao rótulo "Filtros". As badges de filtros ativos mantêm `margin-left: 50px`.

### 5.5. Botão de Histórico no Painel
*   **Remoção inicial:** O botão 📜 "Histórico de Movimentações" foi removido do `index.blade.php` a pedido do usuário.
*   **Reintrodução:** O botão foi trazido de volta como ícone 👁 (somente visualização), linkando à nova rota `processos.historico`.

### 5.6. Ícone ✗ para Sem Ação
*   **Funcionalidade:** Quando o status do processo não corresponde a nenhuma ação disponível para o perfil logado, exibe-se um `✗` cinza claro com tooltip "Nenhuma ação disponível" na coluna de ações do painel.

### 5.7. Página de Histórico de Movimentações (Nova Feature)
*   **Rota:** `GET /processos/{processo}/historico` (`processos.historico`)
*   **Controller:** `ProcessoController@historico` — carrega dados das abas 1, 2, 3, RIPs, cadastros mínimos e requerimento.
*   **View:** `resources/views/processos/historico.blade.php` — página read-only com:
    *   **Indicação do Imóvel (Aba 1):** iframe `foco-01-resumo.html`
    *   **Diagnóstico Preliminar (Aba 2):** iframe `foco-02-resumo.html`
    *   **Análise de Viabilidade (Aba 3):** observações salvas
    *   **RIPs / Cadastros Mínimos:** lista vinculada ao processo
    *   **Manifestações:** carimbo de chefia e acima (nome, data, decisão, observações) ou status pendente
*   **Acesso:** Todos os perfis podem visualizar. Botão "← Voltar ao Painel" retorna à página anterior.
*   **Acionamento:** Botão 👁 no painel de requerimentos, ao lado do botão de ação (🔎) ou do ✗.
