# Problema de Renderização de Resumos em Iframes vs Banco de Dados Híbrido

**Data:** 21 de Julho de 2026
**Contexto:** Renderização dos dados de resumo da "Aba 1a (Dados do Requerimento)" e "Aba 1b (Indicação do Imóvel)" dentro de acordeons nas abas subsequentes (Aba 2, Aba 3, Histórico) do sistema Foco-15.

## O Problema

Inicialmente, os resumos da Aba 1 (tanto os dados do requerente quanto a lista de RIPs/Imóveis) foram implementados utilizando **iframes** (`foco-01a-resumo.html` e `foco-01b-resumo.html`). A arquitetura desses arquivos HTML estáticos consistia em buscar os dados diretamente da API REST do **Supabase** via JavaScript de forma assíncrona.

Isso gerou dois problemas graves que impediam o carregamento dos dados (exibindo apenas traços `-`):

1. **Dependência Exclusiva do Supabase (A Causa Raiz Principal):**
   Muitos processos no sistema (especialmente os recém-criados ou importados de integrações locais) possuem seus dados armazenados **exclusivamente no banco MySQL** (`tabela_requerimentos` modelo `Requerimento` local). Como os iframes faziam consultas unicamente para o Supabase (`tabela_relatorios` e `tabela_requerimentos` na nuvem), processos como `PB2026004` retornavam vazio (0 registros), falhando silenciosamente na tela, mesmo com os dados existindo no banco local do Laravel.

2. **Condição de Corrida (Race Condition) no ID do Processo:**
   Os scripts dos iframes dependiam de `localStorage.getItem('CURRENT_PROCESS_ID')` para saber qual processo buscar. Ocasionalmente, o iframe carregava mais rápido que o tempo necessário para o script da página pai atualizar o `localStorage` com o ID do novo processo recém-aberto, fazendo com que o iframe buscasse IDs errados ou em branco.

## A Solução

Para sanar o problema de forma definitiva e suportar processos que só existem no banco legado/MySQL, a arquitetura de **iframes foi abandonada para os resumos internos**.

### Passos da Implementação:

1. **Repasse de Variáveis do Controller:**
   No `ProcessoController@show`, a variável `$requerimento` (instância de `App\Models\Requerimento` obtida do MySQL) já era carregada. Foi necessário alterar o arquivo `resources/views/processos/show.blade.php` para repassar explicitamente essa variável para os `@include` das Abas 2, 3, etc.
   ```php
   @include('processos.abas.aba2', ['processo' => $processo, 'dados' => $dados, 'requerimento' => $requerimento ?? null])
   ```

2. **Substituição dos Iframes por Blade HTML (Aba 1a):**
   Os iframes dentro dos acordeons na `aba2.blade.php` (e similares) foram substituídos por código Blade direto, que acessa as propriedades de `$requerimento` e `$processo`.
   ```blade
   <div class="accordion-body">
       @php $req = $requerimento ?? null; @endphp
       {{ $req?->nome_requerente ?? '-' }}
       {{ $req?->cpf_cnpj_requerente ?? '-' }}
   </div>
   ```

3. **Fallback Híbrido para Listagem de Imóveis (Aba 1b):**
   Para a listagem de RIPs e Cadastros Mínimos (Aba 1b), a view agora tenta primeiro ler do MySQL através das relações Eloquent (`$processo->foco->rips`).
   Se a relação estiver vazia (caso de dados salvos na arquitetura nova mas ainda não sincronizados para o MySQL), o Blade injeta um script JavaScript de fallback que consulta a `tabela_indicacao` no Supabase, garantindo que os dados apareçam independente de onde estejam salvos.

## Lição Aprendida / Arquitetura Recomendada
- Em um ambiente híbrido (MySQL + Supabase/NoSQL), não dependa de arquivos HTML/JS puros rodando em iframe para dados críticos do processo a menos que a sincronização entre os bancos seja atômica e garantida.
- Renderizar resumos diretamente pelo backend (Blade) utilizando os models do Laravel previne problemas de dessincronização de dados e anula completamente race conditions de Frontend (localStorage).
- Para componentes dinâmicos (como fetch da API do SPU), injete o script diretamente na view Blade associada ao ID específico do componente renderizado.
