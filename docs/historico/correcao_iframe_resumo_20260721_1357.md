# Log de Alteração: Correção do carregamento do Resumo da Aba 1 (Indicação do Imóvel)

## Arquivos Modificados
- `resources/views/processos/abas/aba2.blade.php`
- `resources/views/processos/abas/aba3.blade.php`
- Novos arquivos adicionados na pasta `public/`: `foco-01-resumo.html`, `foco-02-resumo.html`, etc.

## Motivo da Alteração
Na aba 2, o iframe responsável por exibir o conteúdo em "Indicação do Imóvel" não estava carregando nada porque estava com o link apontando para um caminho relativo (`src="./foco-01-resumo.html"`). Como o projeto agora usa o Laravel e rotas dinâmicas, o navegador tentava carregar a página na rota local de processos (gerando um erro 404).

## 1. Estado Anterior (Antes)
No arquivo blade:
```html
<iframe src="./foco-01-resumo.html" title="Aba 1 (Indicação do Imóvel)" ...></iframe>
```
Os arquivos HTML de resumo constavam apenas em `prototipo_html/`.

## 2. Estado Novo (Depois)
Foram copiados os arquivos HTML com a terminação `-resumo.html` da pasta `prototipo_html/` para a pasta `public/` do Laravel.
No arquivo blade, atualizei a tag com a diretiva `asset()`:
```html
<iframe src="{{ asset('foco-01-resumo.html') }}" title="Aba 1 (Indicação do Imóvel)" ...></iframe>
```
Este mesmo ajuste foi espelhado na `aba3.blade.php` para os resumos da aba 1 e aba 2.

## 3. Plano de Rollback / Desfazer
Para desfazer:
1. Apague os arquivos `*-resumo.html` inseridos recentemente no diretório `public/`.
2. Em `aba2.blade.php` e `aba3.blade.php`, volte as referências de `<iframe src="{{ asset('foco-XX-resumo.html') }}">` para `<iframe src="./foco-XX-resumo.html">`.
