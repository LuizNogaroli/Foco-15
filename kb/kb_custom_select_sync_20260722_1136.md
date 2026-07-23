# Validação de Custom Selects Híbridos no Laravel

## O Paradoxo da UI Customizada vs Elemento Nativo
Ao construir *Custom Selects* via JavaScript para substituir esteticamente `<select>` nativos, é comum o seguinte comportamento:
1. Uma estrutura DIV com listas `ul/li` é desenhada e injetada com os dados de uma constante JS.
2. Quando o usuário clica na `li`, o JS tenta refletir o valor atualizando o input `select.value = "AlgumaCoisa"`.
3. A aplicação Laravel (em seu JS de validação de formulário) faz o submit avaliando o input `<select>` nativo.

## O Risco Oculto
Se a sua constante JS injetar opções na UI que não estejam previamente declaradas em tags `<option>` no HTML nativo (ex: no Blade gerado), o browser **rejeitará** a atribuição `select.value = "NovaOpcao"`. Ele silenciosamente deixará o input vazio (ou no seu `selectedIndex` primário), e a validação do formulário apontará "Campo Obrigatório Não Preenchido", gerando extrema confusão no usuário.

## Boa Prática
Ao inicializar scripts de Custom Selects que utilizem estruturas de dados do próprio JavaScript como fonte de opções, **sempre force a limpeza e injeção (sincronismo) dessas opções também dentro da tag nativa `<select>`** antes de montar a UI gráfica.
```javascript
// Exemplo:
select.innerHTML = '<option value="">Selecione...</option>';
OPCOES_JS.forEach(opt => {
   const option = document.createElement('option');
   option.value = opt.value;
   option.textContent = opt.label;
   select.appendChild(option);
});
// Em seguida pode ocultar o select nativo e montar sua div!
```
Isso garante a confiabilidade do `value` atribuído via programação.
