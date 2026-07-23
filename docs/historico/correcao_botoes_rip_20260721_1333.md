# Log de Alteração: Correção da exibição dos botões após inserir RIP

## Arquivos Modificados
- `public/js/foco-01.js`
- `prototipo_html/foco-01.js`

## Motivo da Alteração
Na aba 1, depois que o usuário inseria o primeiro RIP/Área, o botão de "Inserir RIP existente" continuava aparecendo, junto com o botão "+ Adicionar Imóvel/Área". O comportamento desejado era esconder os botões de inserção de RIP ou Cadastro Mínimo junto com o dropdown, exibindo somente o botão "+ Adicionar Imóvel/Área".

## 1. Estado Anterior (Antes)
```javascript
    function atualizarLayoutConceituacao() {
        if (!selectConceituacao) return;
        const val = selectConceituacao.value;
        const exigeRip = ["Terreno/acrescido de marinha", "Terreno/acrescido marginal", "Nacional interior"];
        const exigeCadastro = ["Espelho d'água", "Cavidades naturais subterrâneas", "Manguezal", "Praias"];

        const blocoInfo = document.getElementById('bloco-info-exige-rip');
        const blocoCadastro = document.getElementById('bloco-info-exige-cadastro-minimo');

        let selecionado = "";
        if (val && exigeRip.includes(val)) {
            selecionado = "Sim";
            if (blocoInfo) blocoInfo.style.display = "block";
            if (blocoCadastro) blocoCadastro.style.display = "none";
        } else if (val && exigeCadastro.includes(val)) {
            selecionado = "Não";
            if (blocoInfo) blocoInfo.style.display = "none";
            if (blocoCadastro) blocoCadastro.style.display = "block";
        } else {
            if (blocoInfo) blocoInfo.style.display = "none";
            if (blocoCadastro) blocoCadastro.style.display = "none";
        }

        // ...
```

## 2. Estado Novo (Depois)
```javascript
    function atualizarLayoutConceituacao() {
        if (!selectConceituacao) return;
        const val = selectConceituacao.value;
        const exigeRip = ["Terreno/acrescido de marinha", "Terreno/acrescido marginal", "Nacional interior"];
        const exigeCadastro = ["Espelho d'água", "Cavidades naturais subterrâneas", "Manguezal", "Praias"];

        const blocoInfo = document.getElementById('bloco-info-exige-rip');
        const blocoCadastro = document.getElementById('bloco-info-exige-cadastro-minimo');
        const containerDropdown = document.getElementById('container_conceituacao_dropdown');
        const isDropdownVisible = containerDropdown && containerDropdown.style.display !== 'none';

        let selecionado = "";
        if (val && exigeRip.includes(val)) {
            selecionado = "Sim";
            if (blocoInfo) blocoInfo.style.display = isDropdownVisible ? "block" : "none";
            if (blocoCadastro) blocoCadastro.style.display = "none";
        } else if (val && exigeCadastro.includes(val)) {
            selecionado = "Não";
            if (blocoInfo) blocoInfo.style.display = "none";
            if (blocoCadastro) blocoCadastro.style.display = isDropdownVisible ? "block" : "none";
        } else {
            if (blocoInfo) blocoInfo.style.display = "none";
            if (blocoCadastro) blocoCadastro.style.display = "none";
        }

        // ...
```

## 3. Plano de Rollback / Desfazer
Para desfazer a modificação e voltar ao comportamento anterior (onde os botões de Inserir RIP/Cadastro Mínimo não são escondidos junto com o dropdown), siga os passos abaixo:

1. Abra os arquivos `public/js/foco-01.js` e `prototipo_html/foco-01.js`.
2. Busque pela função `function atualizarLayoutConceituacao()`.
3. Remova as seguintes linhas de código recém inseridas (perto da linha 230):
```javascript
        const containerDropdown = document.getElementById('container_conceituacao_dropdown');
        const isDropdownVisible = containerDropdown && containerDropdown.style.display !== 'none';
```
4. Substitua os trechos:
```javascript
            if (blocoInfo) blocoInfo.style.display = isDropdownVisible ? "block" : "none";
```
e
```javascript
            if (blocoCadastro) blocoCadastro.style.display = isDropdownVisible ? "block" : "none";
```
De volta para:
```javascript
            if (blocoInfo) blocoInfo.style.display = "block";
```
e
```javascript
            if (blocoCadastro) blocoCadastro.style.display = "block";
```
5. Salve os arquivos e faça a limpeza de cache do navegador (Ctrl+F5) caso necessário.
