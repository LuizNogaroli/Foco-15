# KB: Controle de Acesso por Perfil + Fix Cookie Simulador + Paginação (2026-07-19 23:30)

**Data:** 2026-07-19
**Tags:** #controle-acesso #cookie #simulador-perfil #paginacao #meus-processos

---

## Problema 1: "Meus Processos" não filtrava por UF

### Antes
O filtro "Meus Processos" só verificava o status do perfil, sem restringir por UF. Todos os 60 processos apareciam independente da UF do servidor.

### Causa
`getStatusesDoPerfil()` retornava os statuses do perfil, mas não havia junção com `equipe_servidores` para filtrar por UF.

### Solução
Em `ProcessoController::index()`, adicionar filtro de UF baseado em `equipe_servidores`:
- **Usuário normal:** busca UFs do próprio usuário via `$user->equipes()->where('perfil', $perfil)`
- **Admin simulando:** busca UFs de TODOS os servidores com aquele perfil via `EquipeServidor::where('perfil', $perfil)`
- Se UFs inclui 'NAC' → não filtra por UF (acesso nacional)
- Se usuário não tem equipe → retorna vazio

### Arquivos alterados
- `app/Http/Controllers/ProcessoController.php` (bloco meus_processos no `index()`)
- `app/Models/EquipeServidor.php` (novo import no controller)

---

## Problema 2: Perfil conseguia abrir processos em status indevido

### Antes
Qualquer perfil podia clicar na lupa e ser redirecionado para a aba 1 (fallback padrão), sem verificação de permissão.

### Solução
Criar `perfilPodeOperar($status, $perfil)` — matriz idêntica ao `getAbaEStatus` mas retorna bool. Se retornar false, redireciona para o painel com `session('erro_acesso')`.

Em `index.blade.php`, modal `<div id="modalAcessoNegado">` que aparece quando `session('erro_acesso')` existe.

### Arquivos alterados
- `app/Http/Controllers/ProcessoController.php` — método `abrir()` + novo `perfilPodeOperar()`
- `resources/views/processos/index.blade.php` — modal de acesso negado

---

## Problema 3: Navegação de abas sem restrição

### Antes
Todas as 4 abas (1, 2, 3, 7) apareciam sempre no menu superior, mesmo para perfis que só operam na aba 7.

### Solução
Criar `getAbasDoPerfil($perfil)` que retorna array de abas acessíveis. Passar `$abasDoPerfil` para a view. Em `show.blade.php`, cada aba fica condicionada a `@if(in_array(N, $abasDoPerfil))`.

### Mapeamento
```
Equipe Destinação    → [1, 2, 3]
Equipe Caracterização → [1, 2]
Chefia/Coordenação/Superintendência/C.G./Coord-Geral/Direção/CDE → [7]
```

### Arquivos alterados
- `app/Http/Controllers/ProcessoController.php` — novo `getAbasDoPerfil()` + passa `$abasDoPerfil` na `show()`
- `resources/views/processos/show.blade.php` — `@if` em cada aba do menu

---

## Problema 4: Cookie `perfil_simulado` descriptografado pelo Laravel

### Antes
JavaScript setava `document.cookie = 'perfil_simulado=CARACTERIZACAO'` em texto plano. O middleware `EncryptCookies` do Laravel 11 tentava descriptografar o valor, resultando em lixo. `request()->cookie('perfil_simulado')` retornava null, fazendo `getPerfilAtual()` cair no role real do admin (`Direção`).

### Causa
Laravel 11 inclui `EncryptCookies` no grupo `web` por padrão. Cookies setados por JS não passam pela criptografia do Laravel, então a descriptografação falha silenciosamente.

### Solução
Em `bootstrap/app.php`:
```php
->withMiddleware(function (Middleware $middleware): void {
    $middleware->encryptCookies(except: [
        'perfil_simulado',
    ]);
})
```

### Arquivo alterado
- `bootstrap/app.php`

---

## Problema 5: Paginação com visual feio (SVGs gigantes)

### Antes
Laravel 11 usa view `tailwind.blade.php` por padrão, com classes Tailwind inline e SVGs de seta. Sem Tailwind no projeto, os SVGs e texto renderizavam sem estilo, ficando gigantes.

### Solução
1. View customizada em `resources/views/vendor/pagination/custom.blade.php` — sem SVGs, texto `‹ Anterior` / `Próximo ›`, números limpos
2. `Paginator::defaultView('vendor.pagination.custom')` em `AppServiceProvider::boot()`
3. CSS em `dashboard.css`: `.pagination`, `.page-item`, `.page-link` com variáveis de cor do projeto

### Arquivos criados/alterados
- `resources/views/vendor/pagination/custom.blade.php` (novo)
- `app/Providers/AppServiceProvider.php` — `Paginator::defaultView()`
- `public/css/dashboard.css` — estilos de paginação

---

## Rollback

1. **Meus Processos UF filter:** Remover bloco `// Filtrar por UF` do `index()` em ProcessoController
2. **perfilPodeOperar:** Remover chamada em `abrir()` + remover método; remover modal do index.blade.php
3. **getAbasDoPerfil:** Remover chamada em `show()` + remover variável `$abasDoPerfil`; remover `@if` das abas em show.blade.php
4. **Cookie fix:** Remover `encryptCookies(except: ['perfil_simulado'])` de bootstrap/app.php
5. **Paginação:** Remover `resources/views/vendor/pagination/custom.blade.php`; remover `Paginator::defaultView()` de AppServiceProvider; remover estilos `.pagination` do dashboard.css
