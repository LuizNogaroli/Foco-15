# CRUD Servidores + Importação CSV/XLSX + Seeders em Massa

**Data:** 2026-07-18 23:55

## Estado Anterior (Antes)

### Migration users (não existia)
```php
// Não havia colunas cargo/telefone na tabela users
Schema::table('users', function (Blueprint $table) {
    $table->string('cpf')->nullable()->after('email');
    // Próxima coluna era 'email_verified_at'
});
```

### User model fillable
```php
#[Fillable(['name', 'email', 'cpf', 'password', 'uf'])]
```

### EquipeController (não tinha importação)
```php
class EquipeController extends Controller
{
    public function index(Request $request) { ... }
    public function store(Request $request) { ... }
    public function destroy(EquipeServidor $equipeServidor) { ... }
    // Sem método importar()
}
```

### DatabaseSeeder
```php
public function run(): void
{
    DB::table('requerimentos')->truncate();
    DB::table('processos')->truncate();
    $this->call([
        RoleSeeder::class,
        UserSeeder::class,
        ProcessoSeeder::class,
    ]);
}
```

### RoleSeeder
```php
public function run(): void
{
    \Spatie\Permission\Models\Role::create(['name' => 'Equipe Destinação']);
    // ... creates ... (falhava se roles já existiam)
}
```

### routes/web.php (equipe)
```php
Route::get('/equipe', ...)->name('equipe.index');
Route::post('/equipe', ...)->name('equipe.store');
Route::delete('/equipe/{equipeServidor}', ...)->name('equipe.destroy');
// Sem rotas /servidores e /equipe/importar
```

## Estado Novo (Depois)

### Migration users (nova)
```php
Schema::table('users', function (Blueprint $table) {
    $table->string('cargo')->nullable()->after('cpf');
    $table->string('telefone')->nullable()->after('cargo');
});
```

### User model fillable (atualizado)
```php
#[Fillable(['name', 'email', 'cpf', 'cargo', 'telefone', 'password', 'uf'])]
```

### Arquivos novos criados
- `app/Imports/ServidoresImport.php`
- `app/Http/Controllers/ServidorController.php`
- `resources/views/servidores/index.blade.php`
- `resources/views/servidores/edit.blade.php`
- `database/seeders/ServidorSeeder.php`
- `database/seeders/EquipeServidorSeeder.php`

### Arquivos modificados
- `app/Http/Controllers/EquipeController.php` — método `importar()` adicionado
- `app/Imports/ServidoresImport.php` — classe de importação
- `database/seeders/DatabaseSeeder.php` — truncate users/equipe_servidores + novos seeders
- `database/seeders/RoleSeeder.php` — `create()` → `firstOrCreate()`
- `database/seeders/UserSeeder.php` — cargo + telefone + hash pré-computado
- `resources/views/equipe/index.blade.php` — modal importar + link servidores
- `resources/views/processos/index.blade.php` — botões equipe/servidores na navbar
- `routes/web.php` — rotas servidores CRUD + importar
- `composer.json/lock` — maatwebsite/excel + dependências

## Plano de Rollback / Desfazer

### 1. Reverter migration cargo/telefone
```bash
php artisan migrate:rollback --path=database/migrations/2026_07_18_233438_add_cargo_telefone_to_users_table.php
```

### 2. Remover arquivos novos
```bash
rm app/Imports/ServidoresImport.php
rm app/Http/Controllers/ServidorController.php
rm resources/views/servidores/index.blade.php
rm resources/views/servidores/edit.blade.php
rm database/seeders/ServidorSeeder.php
rm database/seeders/EquipeServidorSeeder.php
```

### 3. Reverter User model fillable
```php
// De:
#[Fillable(['name', 'email', 'cpf', 'cargo', 'telefone', 'password', 'uf'])]
// Para:
#[Fillable(['name', 'email', 'cpf', 'password', 'uf'])]
```

### 4. Reverter EquipeController
Remover o método `importar()` e os imports de `ServidoresImport` e `Excel`.

### 5. Reverter routes/web.php
Remover as rotas:
```php
Route::post('/equipe/importar', ...);
Route::get('/servidores', ...);
Route::post('/servidores', ...);
Route::get('/servidores/{user}', ...);
Route::put('/servidores/{user}', ...);
Route::delete('/servidores/{user}', ...);
```

### 6. Reverter DatabaseSeeder
Remover truncation de `users` e `equipe_servidores`, e remover `ServidorSeeder` e `EquipeServidorSeeder` do `$this->call()`.

### 7. Reverter RoleSeeder
Voltar de `firstOrCreate()` para `create()`.

### 8. Reverter views
Restaurar `equipe/index.blade.php` e `processos/index.blade.php` para versões anteriores (sem botões de importar/servidores).

### 9. Desinstalar lib (opcional)
```bash
composer remove maatwebsite/excel
```

### 10. Re-seed database
```bash
php artisan db:seed
```
