# Alteração: Desligamento do Autosave Automático e Inclusão de Botão de Salvar Rascunho

## 1. Contexto e Motivação
A pedido do cliente (decisão soberana), o sistema de salvamento automático que funcionava a cada 2 segundos (Autosave) em plano de fundo foi desligado. Em seu lugar, foi implementado um botão manual "Salvar Rascunho" adjacente ao botão de "Salvar e Enviar" nas principais abas (1, 2 e 3). A intenção é dar mais controle ao usuário sobre quando o estado temporário do formulário é enviado ao servidor, evitando requisições indesejadas e possíveis conflitos de navegação relatados.

## 2. Solução Implementada
- Modificou-se o `autosave.js` para NÃO acionar `bindFormEvents()` (que atrelava os eventos de digitação `input`/`change` à função de contagem de tempo).
- O timer condicionado pelo `hasChanges` foi removido de `saveDraft()`. 
- A função de salvamento foi exportada globalmente (`window._saveDraft`).
- Foram introduzidos os botões HTML nas abas correspondentes invocando a função via clique. O componente de alerta ("Salvando rascunho...") nativo do `autosave.js` foi mantido para fornecer feedback imediato.

---

## 3. Histórico de Alterações e Rollback

### Alteração 1: `public/js/autosave.js`

**Estado Anterior (Antes):**
```javascript
        if (!CSRF_TOKEN) {
            console.warn('[autosave] Token CSRF não encontrado. Autosave desativado.');
            return;
        }

        bindFormEvents();
        loadDraft();
    }

    function bindFormEvents() {
        const forms = document.querySelectorAll('form[id^="form0"]');
        forms.forEach(function (form) {
            form.querySelectorAll('input, select, textarea').forEach(function (el) {
                el.addEventListener('input', onFieldChange);
                el.addEventListener('change', onFieldChange);
            });
        });
    }

    function onFieldChange() {
        hasChanges = true;
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(saveDraft, 2000);
    }
```

**Estado Novo (Depois):**
```javascript
        if (!CSRF_TOKEN) {
            console.warn('[autosave] Token CSRF não encontrado. Salvamento de rascunho desativado.');
            return;
        }

        loadDraft();
    }

    function onFieldChange() {
        hasChanges = true;
    }
```

**Plano de Rollback / Desfazer:**
1. Desfaça a modificação no `autosave.js` retornando a chamada `bindFormEvents()` dentro do `init()`.
2. Restaure a lógica de debounce no método `onFieldChange`.
3. Nas views (`aba1.blade.php`, `aba2.blade.php`, `aba3.blade.php`), apague a linha contendo o botão `<button type="button" ... onclick="window._saveDraft()">` adjacente ao de submissão.
