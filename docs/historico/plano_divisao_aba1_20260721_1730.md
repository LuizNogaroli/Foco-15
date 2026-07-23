# Plano de Implementação - Divisão da Aba 1 (1a - Requerimento e 1b - Indicação do Imóvel)

Este plano descreve as mudanças necessárias para separar logicamente e visualmente a Aba 1 do processo de Admissibilidade em duas partes: **Aba 1a (Dados do Requerimento)** e **Aba 1b (Indicação do Imóvel/Área)**, e refletir essa divisão nos resumos apresentados nas abas subsequentes (Aba 2, Aba 3, Aba 7 e Histórico).

---

## Proposed Changes

### 1. Visual Division on Aba 1 (`resources/views/processos/abas/aba1.blade.php`)
- **Aba 1a (Dados do Requerimento):** Permanecerá dentro do primeiro acordeon existente ("Dados do Requerimento"), que agrupa informações do Requerente, Representante Legal, Informações Adicionais e Documentos Anexados.
- **Aba 1b (Indicação do Imóvel):** O título "Indicação do Imóvel" e todo o conteúdo abaixo dele (botão "Adicionar Imóvel/Área", Conceituação do Imóvel, RIPs Associados, Mapa Interativo, Cadastros Mínimos e observações) serão envelopados em um novo acordeon/bloco visual separado chamado `📍 Indicação do Imóvel (RIPs/Áreas)`.

### 2. Creation of Separate Summary Reports (`public/foco-01a-resumo.html` & `public/foco-01b-resumo.html`)
Atualmente, `foco-01-resumo.html` exibe todas as informações consolidadas da Aba 1. Vamos criar dois resumos menores e focados:
- **`public/foco-01a-resumo.html`**: Exibirá apenas as seções: **Informações do Requerente**, **Dados do Processo SEI e Requerimento** e **Dados do Representante Legal**.
- **`public/foco-01b-resumo.html`**: Exibirá apenas a seção: **Indicação do Imóvel** (Conceituação, RIPs, Cadastros Mínimos, Observações).

### 3. Update Subsequent Tabs (Aba 2, Aba 3, Aba 7 & Histórico)
Em cada uma das abas subsequentes que exibem o resumo da Aba 1, vamos substituir o iframe único da Aba 1 por dois acordeons separados.

---

## Plano de Rollback / Desfazer

Se necessário reverter as alterações e restaurar o estado original:

### Estado Anterior (Antes)
- `aba1.blade.php` continha a seção `<h2>Indicação do Imóvel</h2>` sem acordeon próprio.
- `aba2.blade.php`, `aba3.blade.php` e `historico.blade.php` carregavam o iframe único `<iframe src="{{ asset('foco-01-resumo.html') }}">`.

### Estado Novo (Depois)
- `aba1.blade.php` envolve a seção de indicação no acordeon `<div class="accordion-item" id="acc_aba1b">`.
- As abas subsequentes utilizam os dois iframes independentes: `foco-01a-resumo.html` e `foco-01b-resumo.html`.

### Passos para Reverter (Rollback)
1. **Restaurar os arquivos modificados:**
   - Desfazer a modificação nos arquivos blade executando o restore dos blocos modificados usando o backup ou controle de versão (ex: `git checkout resources/views/processos/abas/aba1.blade.php resources/views/processos/abas/aba2.blade.php resources/views/processos/abas/aba3.blade.php resources/views/processos/historico.blade.php`).
2. **Apagar os arquivos de resumo gerados:**
   - Remover `public/foco-01a-resumo.html` and `public/foco-01b-resumo.html`.
