# Handoff e Estado Atual do Projeto Foco-15 (Laravel)
Data de atualização: 2026-07-21T22:00:00-03:00

## 1. Visão Geral
O Foco-15 encontra-se em um processo contínuo de migração/desacoplamento. Anteriormente, era um projeto monolítico em PHP legadíssimo/Python ou JavaScript isolados conversando com a API do Supabase (BaaS). Atualmente, o projeto é uma aplicação Laravel 11 robusta, que consome o Postgres diretamente via Eloquent, mas ainda mantém chamadas assíncronas via `fetch` em arquivos Javascript (.js) espalhados pelo `/public/js` para compatibilidade com rotinas legadas (como os webhooks/Cloud Functions do Supabase que assinam documentos ou salvam versões incrementais de formulários em JSON).

### 2. Estado do Desenvolvimento (O que funciona hoje)
* **Autenticação, Sessão e Cargos**: Laravel Spatie Permissions em pleno funcionamento (`Administrador`, `Direção`, `Chefia`, `Equipe Destinação`, `Equipe Caracterização`, etc.).
* **ProcessoController & Tela de Show**: O `ProcessoController` é o cérebro que exibe os processos. Ele resolve dinamicamente em que Aba o processo deve cair e quais botões habilitar, cruzando o `status_atual` com os Cargos do usuário.
* **Simulador de Perfis**: O super-admin pode simular estar "na pele" de outro servidor através de um selector que escreve um cookie desprotegido chamado `perfil_simulado`. O Laravel o consome livremente pois ele tem exceção no `EncryptCookies` middleware (configurado no `bootstrap/app.php`).
* **Aba 1 & Aba 2**: Foram integradas aos formulários Blade com Blade Components e `foco-01.js` e `foco-02-v2.js`. Salvamento híbrido funciona.
* **Aba 3**: Refatorada no formato Blade. Recentemente corrigimos formatações, divs espúrias (os RIPs agora são apresentados no diagnóstico) e ajustamos a trava de permissão `$canEditAba3`.
* **Fluxo de "Validação - Chefia"**: Consertamos o botão da lupa; agora quem clica num processo cujo status é "Validação - Chefia" (ou quem aprova a aba anterior enviando o processo para a chefia) é automaticamente direcionado à Aba 7 para assinatura e certificação da chefia (com `foco-07.js` encarregado das travas JS).

### 3. Problemas Recentes e Soluções (Últimas 24h)
* **Formatação Aba 3 vs Aba 2**: A visualização de dados vindos da Aba 2 (Diagnóstico preliminar e RIPs) na Aba 3 estavam sem identidade visual. Solucionamos usando os mesmos estilos `padding: 8px 12px; background:#f8fafc; border-left:3px solid #1e3a5f;` utilizados na Aba 2.
* **Envio Misto da Aba 3 (Aguardar Supabase)**: O botão "Salvar e Enviar" quebrava ao submeter POST e tentava renderizar Arrays com `htmlspecialchars()`. Resolvido interceptando o `submit` no front-end, realizando o fetch no Supabase de forma assíncrona, e só após a promise resolver, submetendo o request HTTP normal.
* **Campos da Aba 3 desabilitados para Equipe Destinação**: A `fieldset` do form desabilitava todos os campos mesmo para o perfil certo porque a lógica dependia de `$user->hasRole()` cruzado com retornos espúrios do cookie nulo. Trocamos para usar a variável `$perfil` do próprio Controlador e exigimos que `$processo->status_atual` seja explicitamente 'Análise de Viabilidade'.

### 4. Próximos Passos (Para a próxima Inteligência Artificial)
1. **Verificar Aba 7 (Validação - Chefia)**: Certificar-se que a aprovação ou devolução (fluxo de rollback de processo) na Aba 7 funciona e altera o status corretamente no backend Laravel.
2. **Revisar Salvamento e Cache de Rascunho (Autosave)**: Alguns arquivos de Javascript, como `formulario.js` e os scripts do componente Vue legados (se existirem), enviam payload para o Supabase a cada 5 segundos. Considere migrar essas rotas de salvamento assíncrono para controllers do Laravel usando `route('api.processos.autosave')` para remover totalmente o Supabase em médio prazo.
3. **Limpeza de Javascripts Soltos**: Há diversos scripts no `/public/js` (`foco-01.js`, `foco-02-v2.js`, `sync.js`, `formulario.js`). Recomenda-se centralizá-los ou reescrevê-los com Alpine.js caso o objetivo seja descontinuar código macarrônico Vanilla Javascript.

Consulte o arquivo `/docs/historico/correcoes_aba3_e_rotas_20260721_2200.md` para ver o rollback dos códigos que foram trocados por último.
