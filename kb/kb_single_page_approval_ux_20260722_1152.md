# Consolidação de Visões e UX de Manifestação (Single-Page Form Approval)

## O Desafio da UX de Aprovações
Em sistemas com fluxo de formulário fragmentado por estágios ("Wizards"), os níveis gerenciais frequentemente precisam realizar o *review* do processo para então manifestar sua decisão (aprovar/devolver).
Se o sistema expõe todas as abas soltas no menu principal, exige que o gestor clique sequencialmente pelas abas e depois encontre o botão de despacho na última delas. Isso introduz atrito na experiência e confusão no escopo de navegação.

## A Abordagem Consolidada (Single-Page Approval)
A solução arquitetural mais elegante e eficiente é **restringir o acesso visual** do gestor (através de restrições no Controlador) para enxergar apenas a Aba de Manifestação no cabeçalho do sistema.
E, dentro do corpo dessa aba de manifestação, a aplicação puxa os dados de *read-only* (resumos) de todas as abas anteriores, apresentando-os em blocos expansíveis/contráteis (Acordeões).
Desta forma:
1. O gestor tem apenas 1 destino (A Aba de Assinatura).
2. Ele ganha uma visão unificada tipo *Dashboard* do que deve aprovar.
3. Se precisar destrinchar o Requerimento ou o Diagnóstico, ele expande o acordeão, confere os dados em *iframe* ou *partial view* read-only, minimiza-o e desce a página para assinar.

Esse padrão economiza cliques, minimiza desvios cognitivos e evita corrupção acidental de abas em elaboração.
