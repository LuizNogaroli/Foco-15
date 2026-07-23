---
nome: Correção do Fluxo de Salvamento e Renderização de RIPs
data: 2026-07-21
autor: Antigravity
tags: [blade, javascript, aba1, aba2, supabase, mysql, form-submit, js-load-order]
---

# Fluxo de Salvamento e Renderização de RIPs (Abas 1 e 2)

## 📌 O Problema Relatado
O usuário relatou que ao inserir um Imóvel (RIP) no acordeon da Aba 1b, a inserção visual ocorria normalmente, porém, ao avançar para a **Aba 2**, o acordeon equivalente (1b) não exibia o RIP inserido. 

Após migrar a Aba 2 de Iframes para Blade nativo, os dados ainda não carregavam e todos os campos apareciam preenchidos com travessões (`-`).

## 🔍 Diagnóstico e Causas Raiz

### 1. Perda dos dados no POST (Aba 1)
No código antigo, a função `executarSalvamento()` no `foco-01.js` interceptava o botão de salvar, gravava os dados no Supabase e só depois avançava. Com a adoção do Laravel, o botão "Salvar e Enviar" (sem ID) acionava um `form.submit()` nativo via método `POST` para `ProcessoController::tramitar`. 

Como o javascript apenas inseria elementos visuais (`div`) para os RIPs, o `$_POST` não continha o array de `rips`, fazendo com que o Laravel excluísse do MySQL os RIPs que porventura estivessem atrelados àquele foco (ou simplesmente não criasse nenhum), e o JS antigo não salvava no Supabase pois o navegador mudava de página antes.

### 2. Ordem de Carregamento Assíncrono (Aba 2)
Após a inclusão dos dados no banco, a Aba 2 precisava ler o RIP e buscar os dados detalhados via API na tabela `tabela_spu` (Supabase). No entanto, o trecho Blade injetava um `(async function() {...})()` auto-executável (`IIFE`) que invocava `window.fetchSPU`. Como o arquivo `fetch_spu.js` estava importado no rodapé da página (após a Aba 2), a função ainda era `undefined` no momento da execução. O erro silencioso retornava um objeto vazio e a interface preenchia a view com `-`.

### 3. Payload do Supabase Stringificado (Aba 2)
Em algumas instâncias, a coluna `dados_json` do Supabase retornava uma string JSON pura, o que fazia as chamadas como `dadosSPU.conceituacao` falharem por tentar acessar propriedades de uma string, em vez de um objeto.

## ✅ Solução Implementada

### A. Injeção de Hidden Inputs (Aba 1)
No arquivo `public/js/foco-01.js`, modificamos as funções `adicionarRipNaLista(rip)` e `adicionarCadastroNaLista(dados)` para injetar dinamicamente campos ocultos no formulário HTML:
```html
<input type="hidden" name="rips[]" value="numero_rip">
<input type="hidden" name="cadastros_minimos[]" value="{'cep':'...'}">
```
Isso garante que ao submeter o `form`, o `ProcessoController` capture corretamente os arrays `$request->rips` e armazene nativamente no MySQL (tabela `FocoRip`).

### B. Sicronização do DOM (Aba 2)
Envolvemos os scripts inline do arquivo `aba2.blade.php` com o evento `DOMContentLoaded`:
```javascript
document.addEventListener('DOMContentLoaded', async function() {
    // Agora o window.fetchSPU existe com certeza
    let d = await window.fetchSPU(rip);
    // ...
});
```
Isso garante que o script só execute após todos os arquivos `.js` do rodapé serem carregados e parseados.

### C. Parse Seguro de JSON
No arquivo `public/js/fetch_spu.js`, adicionamos uma camada de segurança que converte a string `dados_json` em objeto antes de retornar:
```javascript
let dJson = row.dados_json;
if (typeof dJson === 'string') {
    try { dJson = JSON.parse(dJson); } catch (e) {}
}
return dJson || row || {};
```

## 📝 Conclusão
Com essas alterações, a Aba 1 agora se comunica de forma transparente com o Laravel (salvando de forma estruturada no MySQL) e a Aba 2 renderiza dados robustos originados de relacionamentos reais, buscando de forma assíncrona os dados estáticos do imóvel no SPU.

As mensagens de erro referentes ao `Supabase SDK` no console são apenas ruídos herdados da migração (já que o Laravel não utiliza o SDK client-side) e não afetam o uso de requisições Fetch convencionais.
