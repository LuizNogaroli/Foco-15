# KB: Autosave via AJAX — Sistema de Rascunhos Foco

**Data:** 2026-07-19 00:50

## Contexto

O projeto Foco-15 não tinha mecanismo de preservação parcial de dados. Se o usuário preenchesse uma aba e fechasse sem "Salvar e Enviar", tudo se perdia. A pendência original era "salvar rascunho" como botão manual, mas a decisão foi implementar autosave automático via AJAX (padrão de mercado).

## Solução Implementada

### Arquitetura
- **Backend:** Tabela `foco_drafts` + `DraftController` (save/load/clear)
- **Frontend:** `public/js/autosave.js` — detecta mudanças, debounça 2s, POST AJAX
- **Limpeza:** Artisan command `drafts:clean` (remove registros >7 dias)

### Fluxo
1. Usuário edita qualquer campo nas abas 1, 2 ou 3
2. Após 2s de inatividade, JS serializa o form e faz POST para `/draft/save`
3. Backend salva via `updateOrCreate` (chave composta: processo_id + user_id + aba)
4. Ao reabrir a aba, JS busca draft via GET `/draft/load` e preenche automaticamente
5. Ao submeter "Salvar e Enviar" (tramitar), draft é deletado no backend

### Tabela foco_drafts
- `processo_id` (FK)
- `user_id` (FK)  
- `aba` (string: '1', '2', '3')
- `data` (JSON — todos os campos do form)
- Unique constraint: processo_id + user_id + aba

### JS autosave.js
- Incluído em `show.blade.php` (exceto aba 7)
- Variáveis globais: `ProcessoID` e `AbaAtual` (definidas no Blade)
- Detecta `input` e `change` em todos os campos do form ativo
- Serializa: radios (valor único), checkboxes (array), text/select/textarea
- Ignora campos `_token` e `next_aba`
- Mostra feedback visual (toast no canto inferior direito)
- Restaura dados e dispara eventos `change`/`input` pra ativar lógica JS condicional

### DraftController
- `POST /draft/save` — salva/atualiza rascunho
- `GET /draft/load?processo_id=X&aba=Y` — retorna dados do rascunho
- `POST /draft/clear` — remove rascunho (chamado no tramitar)
- `POST /draft/clean-old` — remove rascunhos >7 dias

### Limpeza
- Command: `php artisan drafts:clean`
- Pode ser agendado via cron/scheduler

## Decisões Técnicas
- **2s de debounce** (não imediato) pra não sobrecarregar o servidor com cada tecla
- **Chave composta processo+user+aba** — cada usuário tem seu próprio rascunho por processo/aba
- **Não autosave na aba 7** — é só visualização/assinatura, não tem dados editáveis
- **Draft deletado no submit** — não precisa de limpeza imediata, o `clean` cuida dos antigos
- **localStorage não usado** — optamos por backend only (fonte de verdade no servidor)

## Resultado
- Tabela `foco_drafts` criada
- 4 rotas AJAX registradas
- JS autosavefuncionando em abas 1, 2, 3
- Toast visual de feedback
- Command de limpeza disponível
