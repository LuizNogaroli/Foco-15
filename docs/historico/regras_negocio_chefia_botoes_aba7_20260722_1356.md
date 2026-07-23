# Lógica de Negócio e Botões da Chefia (Aba 7)

## 1. Contexto do Requisito
O usuário solicitou a confirmação da seguinte regra de negócio para a manifestação da Chefia:
- Se assinalar **"suficientes"**, o status deve mudar para **"Validação - Coordenação"**.
- Se assinalar **"não há elementos suficientes"**, o status deve mudar para **"Análise de Viabilidade"** (representando uma devolução).
- Deveriam existir dois botões novos no lugar dos atuais ("Aprovar" e "Devolver"): **"Salvar Rascunho"** e **"Salvar e Enviar"**.

## 2. Solução Implementada

1. **Substituição dos Botões (View `aba7.blade.php`)**:
   - Os botões antigos "Aprovar" e "Devolver" foram removidos da seção.
   - Foram adicionados dois novos botões:
     - `💾 Salvar Rascunho` (name: `acao_aba7_rascunho`, class: `btn-inst-outline`)
     - `📤 Salvar e Enviar` (name: `acao_aba7`, class: `btn-assinar`)

2. **Lógica de Back-end (Controller `ProcessoController@tramitar`)**:
   - O controlador foi refatorado para detectar se a submissão foi um "Rascunho" (`acao_aba7_rascunho`).
   - Caso seja um Rascunho:
     - O sistema apenas salva o *snapshot* dos dados preenchidos até o momento (opção assinalada, campo de observações), garantindo que as informações não se percam.
     - **Não** registra a assinatura (nome, data/hora da Chefia).
     - **Não** altera o status do processo.
   - Caso seja "Salvar e Enviar":
     - O sistema assina o formulário com o nome e data do usuário atual (registra a manifestação como oficial).
     - Lê o valor do *radio button* (`decl_C_opcao`).
     - Aplica a regra de negócio exata:
       - Se `'suficiente'` -> Status passa para **'Validação - Coordenação'**.
       - Se `'insuficiente'` -> Status passa para **'Análise de Viabilidade'** e trâmite para **'Devolvido'**.
