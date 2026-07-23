# Autosave AJAX — Sistema de Rascunhos

**Data:** 2026-07-19 00:50

## Estado Anterior (Antes)

### show.blade.php (sem autosave)
```html
<title>Sistema de Gestão SPU - FOCO</title>
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
```
```html
<!-- Sem variáveis ProcessoID/AbaAtual -->
<!-- Sem include de autosave.js -->
```

### routes/web.php (sem draft)
```php
Route::delete('/servidores/{user}', ...)->name('servidores.destroy');
// Sem rotas /draft/*
```

### ProcessoController@tramitar
```php
$processo->save();
// Sem limpeza de draft
// Redirecionar para o painel ou permanecer na aba
```

### Não existia
- `database/migrations/2026_07_19_003957_create_foco_drafts_table.php`
- `app/Models/FocoDraft.php`
- `app/Http/Controllers/DraftController.php`
- `public/js/autosave.js`
- Artisan command `drafts:clean`

## Estado Novo (Depois)

### Arquivos novos
- `database/migrations/2026_07_19_003957_create_foco_drafts_table.php`
- `app/Models/FocoDraft.php`
- `app/Http/Controllers/DraftController.php`
- `public/js/autosave.js`

### Arquivos modificados
- `resources/views/processos/show.blade.php` — meta CSRF, vars globais, include autosave.js
- `routes/web.php` — 4 rotas draft
- `app/Http/Controllers/ProcessoController.php` — limpeza de draft no tramitar
- `routes/console.php` — command `drafts:clean`

## Plano de Rollback / Desfazer

### 1. Reverter migration
```bash
php artisan migrate:rollback --path=database/migrations/2026_07_19_003957_create_foco_drafts_table.php
```

### 2. Remover arquivos novos
```bash
rm app/Models/FocoDraft.php
rm app/Http/Controllers/DraftController.php
rm public/js/autosave.js
```

### 3. Reverter show.blade.php
Remover:
- `<meta name="csrf-token" content="{{ csrf_token() }}">`
- `var ProcessoID = {{ $processo->id }};`
- `var AbaAtual = {{ $aba }};`
- `<script src="{{ asset('js/autosave.js') }}"></script>`

### 4. Reverter routes/web.php
Remover as 4 rotas draft.

### 5. Reverter ProcessoController@tramitar
Remover o bloco de limpeza de draft:
```php
\App\Models\FocoDraft::where('processo_id', $processo->id)
    ->where('user_id', auth()->id())
    ->delete();
```

### 6. Reverter routes/console.php
Remover o command `drafts:clean`.

### 7. Limpar cache
```bash
php artisan view:clear
php artisan cache:clear
```
