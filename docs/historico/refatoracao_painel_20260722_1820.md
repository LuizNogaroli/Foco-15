# Refatoração UI/UX do Painel de Requerimentos

**Data:** 22/07/2026

## Resumo das Melhorias Realizadas
O painel de listagem de requerimentos (`index.blade.php` e `dashboard.css`) passou por uma profunda refatoração de UI/UX visando transformar a experiência de uma "página web comum" em uma "aplicação de tela cheia" (App-like), maximizando a área útil para exibição de dados e modernizando os elementos de interação.

1. **Layout 100vh & Sticky Header:** A página foi travada em 100% da altura da tela (`overflow: hidden` no `body`). A rolagem passou a ser exclusiva da tabela (`table-container` com `flex: 1` e `overflow: auto`), com o cabeçalho das colunas fixo no topo (`position: sticky`).
2. **Compactação (Edge-to-Edge):** Redução de paddings laterais (de 20px para 10px) e alturas de inputs (de 42px para 38px) para aproveitar cada pixel horizontal e vertical.
3. **Data Stacking & Reordenação:** A coluna "UF" foi movida para a primeira posição. A coluna exclusiva de "Data Req." foi eliminada e a data passou a ser exibida como uma segunda linha logo abaixo do "Nº Req.", economizando largura preciosa.
4. **Ícones Vetoriais e Efeitos:** Os emojis de texto foram substituídos por ícones SVG padronizados na cor azul escuro (`#1e3a5f`). Foi adicionado um efeito hover de escala (`transform: scale(1.2)`) para melhorar a resposta tátil (feedback visual).
5. **Correção de Bug Visual:** O bug do "fio flutuante" (borda inferior desenhada no meio da célula) foi resolvido removendo o `display: flex` da tag `<td>` e transferindo-o para uma `<div>` interna.
6. **Layout da Paginação:** O rodapé de paginação foi reorganizado colocando o contador ("Mostrando 1 a 10...") lado a lado com os botões, com um gap exato de 100px.

---

## Detalhes das Alterações Importantes (Regra de Rollback)

### 1. Layout Principal e Scroll (dashboard.css)
**Estado Anterior (Antes):**
O `body` e o `.main-container` tinham tamanhos naturais baseados no conteúdo.
```css
body { margin: 0; background-color: #f8fafc; }
.main-container { padding: 0 20px 40px 20px; }
.table-container { overflow-x: auto; overflow-y: hidden; }
```

**Estado Novo (Depois):**
Forçando o `flex-direction: column` para preencher 100vh.
```css
body { margin: 0; height: 100vh; display: flex; flex-direction: column; overflow: hidden; background-color: #f8fafc; }
.main-container { padding: 0 10px 10px 10px; flex: 1; display: flex; flex-direction: column; overflow: hidden; }
.table-container { overflow: auto; flex: 1; }
.data-table th { position: sticky; top: 0; z-index: 10; }
```

**Plano de Rollback / Desfazer:**
Para reverter ao padrão original rolável da página:
1. Remova `height: 100vh; display: flex; flex-direction: column; overflow: hidden;` de `body` e de `.main-container`.
2. Remova `overflow: auto; flex: 1;` de `.table-container` e devolva `overflow-x: auto; overflow-y: hidden;`.
3. Remova `position: sticky; top: 0; z-index: 10;` de `.data-table th`.

---

### 2. Coluna de Ações e Correção do Fio Flutuante (index.blade.php)
**Estado Anterior (Antes):**
A `<td>` usava flex diretamente, o que quebrava o `border-bottom` em alguns navegadores.
```html
<td class="table-actions" style="display: flex; justify-content: center; align-items: center; gap: 8px; height: 100%;">
    <button type="submit" class="btn-action">🔎</button>
    <a href="..." class="btn-action">👁</a>
</td>
```

**Estado Novo (Depois):**
A `<td>` voltou a ser normal, e os SVGs foram colocados numa `<div>` flex.
```html
<td class="table-actions" style="vertical-align: middle;">
    <div style="display: flex; justify-content: center; align-items: center; gap: 12px;">
        <button type="submit" class="btn-action">
            <img src="{{ asset('images/icon-edit.svg') }}" width="24" height="24" alt="Editar">
        </button>
        <a href="..." class="btn-action" style="border: none; outline: none; text-decoration: none;">
            <img src="{{ asset('images/icon-eye.svg') }}" width="24" height="24" alt="Visualizar">
        </a>
    </div>
</td>
```

**Plano de Rollback / Desfazer:**
1. Desfaça a `<div>` interna e coloque as propriedades `display: flex; gap: 8px;` de volta na `<td>`.
2. Substitua as tags `<img>` que buscam os arquivos SVG (`icon-edit.svg` e `icon-eye.svg`) pelos emojis antigos `🔎` e `👁`.

---

### 3. Empilhamento de Dados na Tabela (index.blade.php)
**Estado Anterior (Antes):**
Três colunas separadas para Nº Requerimento, Data e UF.
```html
<th style="width: 120px;">Nº Requerimento</th>
<th style="width: 100px;">Data Req.</th>
<th style="width: 50px;">UF</th>
<!-- ... -->
<td>{{ $proc->numero_requerimento }}</td>
<td>{{ $proc->created_at->format('d/m/Y') }}</td>
<td>{{ $proc->uf ?? '-' }}</td>
```

**Estado Novo (Depois):**
Duas colunas, com UF primeiro, e a Data empilhada abaixo do Requerimento.
```html
<th style="width: 50px;">UF</th>
<th style="width: 110px;">Nº Req. / Data</th>
<!-- ... -->
<td>{{ $proc->uf ?? '-' }}</td>
<td>
    <div style="font-weight: 600;">{{ $proc->numero_requerimento }}</div>
    <div style="font-size: 12.5px; color: #64748b; margin-top: 3px;">{{ $proc->created_at->format('d/m/Y') }}</div>
</td>
```

**Plano de Rollback / Desfazer:**
1. Volte a `<th>` de UF para a terceira posição e recrie a `<th>` separada de "Data Req.".
2. Na iteração do `@forelse`, separe novamente a `<div>` do `$proc->created_at` em sua própria `<td>` e posicione a `<td>` de `$proc->uf` após a data.
