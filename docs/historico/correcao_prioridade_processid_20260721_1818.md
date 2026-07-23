# Correção de Precedência de Identificação do Processo (CURRENT_PROCESS_ID)

Este log detalha a alteração de precedência no resgate da variável `processId` dentro das páginas de resumo da Aba 1 (1a e 1b) para sanar o carregamento de dados em branco devido a race conditions ou dados residuais em cache de localStorage.

---

## O Problema
Ao carregar a Aba 2, os dados de Requerimento e Indicação de Imóvel renderizavam vazios (dashes), mesmo com dados válidos persistidos no Supabase para o processo corrente.
* **Causa:** O script buscava primeiramente a variável no `localStorage.getItem('CURRENT_PROCESS_ID')`. Caso o usuário estivesse alternando rapidamente entre processos ou se o iframe terminasse de carregar antes que o script do parent atualizasse o `localStorage`, a chave retornava o ID do processo antigo ou nulo/vazio. Isso causava requisições a URLs com IDs incorretos ou em branco no Supabase.

---

## Solução Aplicada
Invertemos a prioridade de resolução do ID do processo em `public/foco-01a-resumo.html` e `public/foco-01b-resumo.html`. Agora o script prioriza a variável declarada em tempo de execução no `window.parent` (que é definida de forma síncrona no cabeçalho do Blade pelo Laravel), e usa o `localStorage` apenas como último recurso de fallback.
```javascript
const processId = window.parent?.CURRENT_PROCESS_ID || window.parent?.parent?.CURRENT_PROCESS_ID || localStorage.getItem('CURRENT_PROCESS_ID');
```

---

## Plano de Rollback / Desfazer

### Reversão
1. Restaurar `public/foco-01a-resumo.html` e `public/foco-01b-resumo.html` para a versão anterior à inversão de precedência.
