# Correção: Habilitação de Campos na Aba 3 (Controle de Perfil e Acesso)

## 1. Problema Encontrado
O usuário relatou que os campos da Aba 3 não estavam habilitados para preenchimento, mesmo estando logado com o perfil correto ("Equipe Destinação" ou Simulando "Todos").
A investigação apontou dois problemas na lógica do Controller que quebravam a verificação `$canEditAba3` na `aba3.blade.php`:
1. A variável `$perfil` nunca era repassada para a view `processos.show`, o que fazia com que a checagem `isset($perfil)` falhasse silenciosamente.
2. O método `getPerfilAtual()` continha um erro lógico: se o usuário admin (Direção) estivesse simulando o perfil "ALL" (Todos) ou não tivesse simulação, a função caía no loop de papéis (`roles`) padrão do Spatie e acabava retornando "Direção" em vez de "ALL". Como a Aba 3 exige especificamente "ALL" ou "Equipe Destinação", o acesso era barrado.

## 2. Solução Implementada
- Adicionamos a variável `$perfil` na função `compact()` do retorno da view em `ProcessoController@show`.
- Corrigimos `getPerfilAtual()` para retornar explícita e diretamente `'ALL'` caso o perfil simulado seja `'ALL'` ou o usuário seja `Administrador`/`Direção` sem simulação ativa.

---

## 3. Histórico de Alterações e Rollback

### Alteração 1: `app/Http/Controllers/ProcessoController.php` (Passando a variável)

**Estado Anterior (Antes):**
```php
        $perfil = $this->getPerfilAtual();
        $abasDoPerfil = $this->getAbasDoPerfil($perfil);

        return view('processos.show', compact('processo', 'aba', 'dados', 'requerimento', 'abasPreenchidas', 'abasDoPerfil'));
```

**Estado Novo (Depois):**
```php
        $perfil = $this->getPerfilAtual();
        $abasDoPerfil = $this->getAbasDoPerfil($perfil);

        return view('processos.show', compact('processo', 'aba', 'dados', 'requerimento', 'abasPreenchidas', 'abasDoPerfil', 'perfil'));
```

**Plano de Rollback / Desfazer:**
1. Abra `app/Http/Controllers/ProcessoController.php`, método `show` (aprox. linha 301).
2. Remova `'perfil'` da função `compact(...)`.

### Alteração 2: `app/Http/Controllers/ProcessoController.php` (Método getPerfilAtual)

**Estado Anterior (Antes):**
```php
        // Só permite simulação de perfil para admin (Direção)
        if ($user->hasRole('Direção')) {
            $simulado = request()->cookie('perfil_simulado');
            if ($simulado && $simulado !== 'ALL') {
                $map = [
                    'DESTINACAO'       => 'Equipe Destinação',
                    'CARACTERIZACAO'   => 'Equipe Caracterização',
                    'CHEFIA'           => 'Chefia',
                    'COORDENACAO'      => 'Coordenação',
                    'SUPERINTENDENCIA' => 'Superintendência',
                    'EQUIPE_CG'        => 'Equipe C.G.',
                    'COORDENACAO_GERAL'=> 'Coordenação-Geral',
                    'DIRETORIA'        => 'Direção',
                    'CDE'              => 'CDE',
                ];
                return $map[$simulado] ?? $simulado;
            }
        }
```

**Estado Novo (Depois):**
```php
        // Só permite simulação de perfil para admin (Direção)
        if ($user->hasRole('Direção') || $user->hasRole('Administrador')) {
            $simulado = request()->cookie('perfil_simulado');
            if ($simulado === 'ALL') {
                return 'ALL';
            }
            if ($simulado) {
                $map = [
                    'DESTINACAO'       => 'Equipe Destinação',
                    'CARACTERIZACAO'   => 'Equipe Caracterização',
                    'CHEFIA'           => 'Chefia',
                    'COORDENACAO'      => 'Coordenação',
                    'SUPERINTENDENCIA' => 'Superintendência',
                    'EQUIPE_CG'        => 'Equipe C.G.',
                    'COORDENACAO_GERAL'=> 'Coordenação-Geral',
                    'DIRETORIA'        => 'Direção',
                    'CDE'              => 'CDE',
                ];
                return $map[$simulado] ?? $simulado;
            }
            return 'ALL'; // Padrão sem simulação para Administrador
        }
```

**Plano de Rollback / Desfazer:**
1. Abra `app/Http/Controllers/ProcessoController.php`, método `getPerfilAtual` (aprox. linha 617).
2. Restaure o bloco if verificando apenas `if ($user->hasRole('Direção'))` e `if ($simulado && $simulado !== 'ALL')` do Estado Anterior.
