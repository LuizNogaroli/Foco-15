# Manipulação de Inputs de Array (name="[]") no Autosave via Javascript

## Contexto
Durante a implementação de formulários complexos no Laravel, é comum utilizar notação de colchetes no atributo `name` (ex: `<input name="rips[]">`) para enviar uma lista de valores ao back-end em uma única requisição. O Laravel traduz isso perfeitamente para um Array Associativo no Request.

## Problema e Armadilha
Quando desenvolvemos um script de *Autosave* em Javascript puro que serializa os dados do formulário iterando sobre os elementos (`form.querySelectorAll('input')`), se utilizarmos simplesmente `data[el.name] = el.value`, o Javascript não entende nativamente que `rips[]` é um array.
Como resultado:
- O primeiro input insere: `data["rips[]"] = "Valor 1"`
- O segundo input sobrescreve: `data["rips[]"] = "Valor 2"`
Ao final, o array é perdido e apenas o último elemento sobrevive na persistência do rascunho temporário como uma *string*.

## Solução e Padronização
Sempre que serializar formulários para JSON de forma customizada, identifique as nomenclaturas de array e faça o *parse* adequado:
1. Verifique se o nome termina com `[]` (`name.endsWith('[]')`).
2. Se sim, fatie a string (`name.slice(0, -2)`) para extrair o nome limpo (ex: `"rips"`).
3. Inicialize a propriedade no objeto como Array caso ainda não exista (`if (!data[cleanName]) data[cleanName] = []`).
4. Adicione o valor via `.push()` (`data[cleanName].push(el.value)`).

Isso garante que estruturas como `rips` e `cadastros_minimos` fluam bidirecionalmente entre o back-end (que espera Array nativo) e o Front-end sem perda de dados na etapa de salvamento temporário (autosave).
