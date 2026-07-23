# Controle de Visibilidade de Abas baseadas em Perfis

## Contexto (Laravel View-Controller)
Em sistemas com fluxo de trabalho (workflows) e aprovações sequenciais, é comum termos visões específicas para preenchimento de dados (formulários técnicos) e visões dedicadas para despachos e assinaturas (visão de painel/manifestação).

## O Problema de Redirecionamento vs UI
Em nosso sistema, o `ProcessoController` lida com o roteamento principal de abas baseadas no "Status" do processo e no "Perfil" logado. 
Porém, há duas instâncias de controle separadas que devem conversar perfeitamente:
1. `getAbaEStatus()`: Define para qual **URL** (`?aba=X`) o usuário é redirecionado ao clicar em "Abrir processo".
2. `getAbasDoPerfil()`: Define quais abas gráficas (`<button class="circle-btn">`) serão visíveis e clicáveis no menu do cabeçalho da página para o perfil atual.

Se `getAbaEStatus()` envia o perfil `Chefia` para a URL da `Aba 7`, mas o `getAbasDoPerfil()` está configurado para expor visualmente apenas a `Aba 3`, a barra de navegação omitirá a aba atual do usuário, quebrando a indicação visual de navegação.

## A Boa Prática para Revisores
Perfis de revisão e deliberação (Chefias, Coordenações, Direção) que emitem despachos na "Aba de Manifestação" frequentemente necessitam consultar as abas técnicas anteriores (que estão travadas como somente-leitura pelo status atual).
Portanto, a configuração ideal no controlador é garantir que o perfil hierarquicamente superior herde permissão de **Visualização** do leque de abas do escopo em análise (ex: concedendo `[1, 2, 3, 7]` e não apenas `[7]`), provendo assim a autonomia de auditoria dos dados para fundamentar sua assinatura de deferimento/indeferimento.
