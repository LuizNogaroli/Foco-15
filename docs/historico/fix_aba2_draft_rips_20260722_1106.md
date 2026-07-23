# Correção: Carregamento de RIPs da Aba 1 para Aba 2 (Autosave) e Correção JSON no Tramitar

## 1. Problema Encontrado
1. O usuário selecionava um RIP na Aba 1 e, confiando no autosave (que salva os dados em `FocoDraft`), navegava para a Aba 2 sem clicar no botão "Salvar e Enviar". A Aba 2 só lia dados da tabela principal (`foco_rips`) e o JS tentava ler do Supabase (`tabela_indicacao`), ignorando o rascunho do Laravel.
2. Além disso, se o usuário enviasse o formulário contendo `cadastros_minimos`, o array de strings JSON enviado causava um erro fatal no PHP (tentativa de acessar offset de string como array).

## 2. Solução Implementada
- **`app/Http/Controllers/ProcessoController.php`**: Inserida validação `is_string($cad)` no loop do `cadastros_minimos` para garantir o decode do JSON antes de acessá-lo como array.
- **`resources/views/processos/abas/aba2.blade.php`**: Adicionada lógica no bloco `@php` inicial para verificar o rascunho da Aba 1 (`FocoDraft`) caso `$focoRips` e `$focoCadastros` estivessem vazios na tabela principal.

---

## 3. Histórico de Alterações e Rollback

### Alteração 1: `app/Http/Controllers/ProcessoController.php`

**Estado Anterior (Antes):**
```php
                if (isset($validatedData['cadastros_minimos'])) {
                    $foco->cadastrosMinimos()->delete();
                    $cadastros = is_array($validatedData['cadastros_minimos'])
                        ? $validatedData['cadastros_minimos']
                        : json_decode($validatedData['cadastros_minimos'], true) ?? [];
                    foreach ($cadastros as $cad) {
                        $foco->cadastrosMinimos()->create([
                            'cep' => $cad['cep'] ?? null,
                            'logradouro' => $cad['logradouro'] ?? null,
                            'numero' => $cad['numero'] ?? null,
                            'complemento' => $cad['complemento'] ?? null,
                            'municipio' => $cad['municipio'] ?? null,
                            'uf' => $cad['uf'] ?? null,
                            'area' => $cad['area'] ?? null,
                            'observacoes' => $cad['observacoes'] ?? null,
                        ]);
                    }
                }
```

**Estado Novo (Depois):**
```php
                if (isset($validatedData['cadastros_minimos'])) {
                    $foco->cadastrosMinimos()->delete();
                    $cadastros = is_array($validatedData['cadastros_minimos'])
                        ? $validatedData['cadastros_minimos']
                        : json_decode($validatedData['cadastros_minimos'], true) ?? [];
                    foreach ($cadastros as $cad) {
                        if (is_string($cad)) {
                            $cad = json_decode($cad, true) ?? [];
                        }
                        if (!empty($cad)) {
                            $foco->cadastrosMinimos()->create([
                                'cep' => $cad['cep'] ?? null,
                                'logradouro' => $cad['logradouro'] ?? null,
                                'numero' => $cad['numero'] ?? null,
                                'complemento' => $cad['complemento'] ?? null,
                                'municipio' => $cad['municipio'] ?? null,
                                'uf' => $cad['uf'] ?? null,
                                'area' => $cad['area'] ?? null,
                                'observacoes' => $cad['observacoes'] ?? null,
                            ]);
                        }
                    }
                }
```

**Plano de Rollback / Desfazer:**
1. Abra o arquivo `app/Http/Controllers/ProcessoController.php` e localize o método `tramitar` (por volta da linha 378).
2. Substitua o bloco que faz `if (is_string($cad))` pelo código do "Estado Anterior" acima.


### Alteração 2: `resources/views/processos/abas/aba2.blade.php`

**Estado Anterior (Antes):**
```php
          @php
            $focoRips = $processo->foco?->rips ?? collect();
            $focoCadastros = $processo->foco?->cadastrosMinimos ?? collect();
          @endphp
```

**Estado Novo (Depois):**
```php
          @php
            $focoRips = $processo->foco?->rips ?? collect();
            $focoCadastros = $processo->foco?->cadastrosMinimos ?? collect();

            if ($focoRips->isEmpty()) {
                $draftAba1 = \App\Models\FocoDraft::where('processo_id', $processo->id)
                    ->where('user_id', auth()->id())
                    ->where('aba', '1')
                    ->first();
                
                if ($draftAba1 && !empty($draftAba1->data['rips'])) {
                    $focoRips = collect($draftAba1->data['rips'])->filter()->map(function($rip) {
                        return (object) ['numero_rip' => $rip];
                    });
                }
            }

            if ($focoCadastros->isEmpty()) {
                $draftAba1 = $draftAba1 ?? \App\Models\FocoDraft::where('processo_id', $processo->id)
                    ->where('user_id', auth()->id())
                    ->where('aba', '1')
                    ->first();
                    
                if ($draftAba1 && !empty($draftAba1->data['cadastros_minimos'])) {
                    $cads = is_array($draftAba1->data['cadastros_minimos']) 
                        ? $draftAba1->data['cadastros_minimos'] 
                        : json_decode($draftAba1->data['cadastros_minimos'], true) ?? [];
                        
                    $focoCadastros = collect($cads)->map(function($cad) {
                        if (is_string($cad)) $cad = json_decode($cad, true) ?? [];
                        return (object) $cad;
                    });
                }
            }
          @endphp
```

**Plano de Rollback / Desfazer:**
1. Abra o arquivo `resources/views/processos/abas/aba2.blade.php`.
2. Localize a div `<div class="accordion-body"...` dentro do `acc_aba1b` (por volta da linha 119).
3. Substitua todo o bloco `@php ... @endphp` pelo código do "Estado Anterior" acima.
