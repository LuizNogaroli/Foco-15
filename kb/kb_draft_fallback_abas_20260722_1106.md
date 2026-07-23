# Fluxo de Autosave e Acesso entre Abas (Draft x Principal)

## Contexto
O sistema Foco-15 possui um fluxo de "Autosave" (`autosave.js`) que capta o estado atual dos formulários das abas a cada 2 segundos após a última alteração e persiste em uma tabela de rascunhos temporária (`FocoDraft`).

## Problema
Quando o usuário preenche a Aba 1 e não clica explicitamente em "Salvar e Enviar", os dados vão apenas para o rascunho (`FocoDraft`).
No entanto, quando o usuário clicava para navegar para a Aba 2, o back-end da Aba 2 esperava que os dados já estivessem na base de dados principal, validada (`foco_rips` e `foco_cadastros_minimos`).
Isso resultava nos containers de "RIP(s) ou Cadastro Mínimo" aparecendo vazios na Aba 2, embora o usuário confiasse que o autosave havia funcionado, gerando atrito e confusão.

## Solução
A lógica back-end da Aba 2 (`aba2.blade.php`) foi atualizada para implementar um comportamento de *fallback visual*:
1. Ele inicialmente busca os dados da estrutura de persistência principal (`$processo->foco->rips`).
2. Se a estrutura principal estiver vazia (sinal de que o formulário nunca sofreu submit final), o back-end efetua uma busca ativa (query) pelo último Draft da Aba 1 (via `FocoDraft`).
3. Ao localizar o Draft, ele converte a estrutura JSON (ex: `['123', '456']`) temporariamente em objetos compatíveis com a tabela principal (`(object) ['numero_rip' => '123']`).
4. Dessa forma, a Aba 2 renderiza os blocos independentemente do dado estar validado ou apenas em rascunho, provendo fluidez à navegação baseada em *autosave*.

## Dica Técnica: Arrays de JSON
Quando recebemos arrays de JSON (ex: submissão de `cadastros_minimos[]` gerados dinamicamente com `JSON.stringify`), o PHP recebe um array nativo (`is_array() == true`), mas com valores contendo strings JSON.
Se tentarmos iterar sobre esse array e aplicar `$cad['chave']`, o PHP interpretará o `['chave']` como offset de string e lançará `Fatal Error: Cannot access offset of type string on string`.
Sempre garanta o `json_decode($cad, true)` para transformar o JSON em array associativo antes do parse durante os processos de validação de request.
