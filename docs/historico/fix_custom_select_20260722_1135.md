# Correção: Validação de Custom Select em Elemento Nativo (`campo511`)

## 1. Contexto e Problema
O usuário relatou que ao preencher a "Aba 3", o formulário recusava a seleção do campo "Regime de destinação proposto" (`campo511`), exibindo a mensagem de erro da validação (`err511`), mesmo com uma opção (ex: "Cessão de Uso gratuita — Adm. Pública Federal") visivelmente selecionada na tela.

## 2. Diagnóstico
O sistema utiliza um script próprio (`custom-select.js`) para desenhar um combobox interativo com opções categorizadas (agrupadas). No entanto:
- O script criava visualmente as opções usando a constante JavaScript `CAMPO511_DATA`.
- Quando uma opção era clicada, o script tentava fazer `select.value = value` no `<select>` nativo escondido.
- O problema é que o `<select>` nativo ainda possuía opções velhas (hardcoded) em `aba3.blade.php`, que **não batiam** com os *values* contidos em `CAMPO511_DATA`.
- Como o browser recusa assinalar um valor para um `<select>` nativo que não possua aquele `<option>` correspondente, o valor permanecia vazio (`""`).
- Ao clicar em "Salvar e Enviar", a validação verificava o valor do `<select>` nativo e o encontrava vazio, disparando a mensagem de erro falsamente.

## 3. Solução Implementada
O arquivo `public/js/custom-select.js` foi alterado. Agora, na inicialização (`initCustomSelect`), antes de ocultar o `<select>` nativo e construir a interface customizada, o script esvazia o `<select>` e recria todos os `<option>` injetando rigorosamente os dados de `CAMPO511_DATA`.
Dessa forma, garantimos que a **fonte de verdade** do frontend esteja sincronizada com as opções aceitas pelo elemento HTML, permitindo o `select.value = value` funcionar e, consequentemente, a validação ser aprovada.
Além disso, adicionamos suporte à reidratação visual automática através do atributo `data-selected`.

## 4. Histórico de Alterações e Rollback

### Alteração 1: `public/js/custom-select.js`

**Estado Anterior (Antes):**
```javascript
    const select = document.getElementById(selectId);
    if (!select) return;

    select.style.display = 'none';

    const wrapper = document.createElement('div');
```

**Estado Novo (Depois):**
```javascript
    const select = document.getElementById(selectId);
    if (!select) return;

    // Sincroniza as opções do select nativo com a fonte de verdade (CAMPO511_DATA)
    select.innerHTML = '<option value="">Selecione...</option>';
    CAMPO511_DATA.forEach(group => {
        group.options.forEach(opt => {
            const option = document.createElement('option');
            option.value = opt.value;
            option.textContent = opt.label;
            select.appendChild(option);
        });
    });

    select.style.display = 'none';

    const wrapper = document.createElement('div');
```

**Plano de Rollback / Desfazer:**
1. Desfaça a modificação no `custom-select.js` removendo o laço de repetição `CAMPO511_DATA.forEach` que recria o `innerHTML` do select nativo.
2. (Opcional) Remova o bloco final de restauração de valor inicial (`data-selected`) do mesmo arquivo.
