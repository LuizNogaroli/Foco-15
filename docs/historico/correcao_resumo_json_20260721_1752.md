# Correção de Erro de Carregamento nos Resumos (Aba 1a e 1b)

Este documento registra a correção aplicada para sanar o erro de carregamento nos novos iframes de resumo da Aba 1 (1a e 1b), onde os dados de fallback da tabela_requerimentos não eram exibidos pela falta de parsing do JSON.

---

## O Problema
Ao carregar a Aba 2, o acordeon da Aba 1a (Dados do Requerimento) exibia apenas traços (`-`) e não populava as informações do processo. O mesmo ocorria para a Aba 1b.
- **Causa:** O campo `dados_json` da `tabela_requerimentos` (usado como fallback quando `tabela_relatorios` não tem registro) retorna do Supabase como uma String JSON. A lógica antiga em `foco-01-resumo.html` realizava o `JSON.parse` condicional, mas os novos arquivos `foco-01a-resumo.html` e `foco-01b-resumo.html` apenas atribuíam o valor diretamente sem parsing: `const dj = reqList[0].dados_json || {};`. Isso impedia o acesso aos atributos internos (ex: `dj.interessado`).

---

## Solução Aplicada
Adicionado o parse condicional em ambos os arquivos HTML de resumo (`public/foco-01a-resumo.html` e `public/foco-01b-resumo.html`):
```javascript
const dj = typeof reqList[0].dados_json === 'string' ? JSON.parse(reqList[0].dados_json) : reqList[0].dados_json;
```

---

## Plano de Rollback / Desfazer

### Estado Anterior (Antes)
```javascript
const dj = reqList[0].dados_json || {};
```

### Estado Novo (Depois)
```javascript
const dj = typeof reqList[0].dados_json === 'string' ? JSON.parse(reqList[0].dados_json) : reqList[0].dados_json;
```

### Reversão
1. Abrir `public/foco-01a-resumo.html` e `public/foco-01b-resumo.html`.
2. Substituir a linha do `const dj` pelo estado anterior.
