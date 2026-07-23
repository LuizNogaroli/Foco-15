# Memorial Descritivo: Módulo de Configurações e Gestão de Equipes

**Data:** 2026-07-18  
**Módulo Analisado:** Painel Administrativo (`configuracoes.html`, `configuracoes.js` e funções no `db.js`)

---

## 1. Funcionamento Atual (UX e Lógica de Interface)

O painel de configurações foi projetado para permitir que um administrador monte as equipes de trabalho da SPU distribuídas por Unidade da Federação (UF). O fluxo funciona da seguinte forma:

1. **Seleção de UF:** Uma barra lateral esquerda (`<aside>`) lista todos os estados. O administrador seleciona o estado que deseja configurar.
2. **Seleção de Servidor:** Ao escolher a UF, o painel principal exibe uma lista de servidores. Atualmente, esta lista é **simulada (mockada)** dinamicamente pelo arquivo `configuracoes.js`, gerando nomes como "SPU/{UF}-Servidor A" a "Servidor Z".
3. **Atribuição de Perfil e Capacidades:**
   - O administrador escolhe um servidor e seleciona um perfil (Equipe SPU/UF, Chefia SPU/UF, Coordenação SPU/UF ou Superintendência).
   - Existe uma chave de ativação (toggle) **"Permitir distribuição"**, que define uma capacidade especial: se esse servidor tem permissão para distribuir processos no painel gerencial.
4. **Quadro de Lotação (Grid):** Ao clicar em "Adicionar", a alocação vai para uma tabela visual logo abaixo (Quadro de Lotação). Validações impedem que o mesmo servidor seja adicionado ao mesmo perfil duas vezes na mesma UF.
5. **Salvamento em Lote:** Nenhuma alteração é salva imediatamente no banco. O usuário deve clicar no botão "Salvar Todas as Configurações" no final da página para persistir as mudanças.

---

## 2. Implementação Técnica e o Banco de Dados

A persistência dessas configurações é orquestrada pelo arquivo `db.js`, por meio das funções `window.saveConfigRoles` e `window.loadConfigRoles`. 

### Como os dados estão sendo salvos:
Em vez de utilizar as tabelas dedicadas mencionadas na documentação (`tabela_spu` para cadastro e `tabela_atribuicao` para vínculos), o protótipo atual está armazenando **toda a estrutura de equipes do Brasil inteiro** em um único registro JSON na tabela de rascunhos (`foco_drafts`).

- **Chave de identificação:** `process_id = 'GLOBAL_CONFIG_ROLES'`
- **Formato:** O objeto JavaScript `assignments` (que agrupa servidores por UF) é convertido e salvo inteiramente na coluna `form_data`. Exemplo:
  ```json
  {
    "RJ": [
      { "server": "RJ-Servidor A", "profile": "Chefia SPU/UF", "canDistribute": true }
    ],
    "SP": [ ... ]
  }
  ```

---

## 3. Questões Técnicas Envolvidas e Pendências para Resolver

Para tornar este módulo robusto e funcional ("resolver a mecânica de criar equipes e atribuir processos"), temos os seguintes desafios técnicos que precisam ser abordados:

> [!WARNING]
> **Problema de Concorrência (Overwriting)**
> Como todos os perfis do Brasil são salvos em uma única linha (`GLOBAL_CONFIG_ROLES`), se dois administradores de estados diferentes tentarem montar suas equipes ao mesmo tempo, um vai sobrescrever (apagar) o trabalho do outro quando clicar em "Salvar".

> [!CAUTION]
> **Descolamento do Modelo Relacional Real**
> O documento de *Handoff* informa que o sistema possui (ou deveria possuir) uma `tabela_spu` e uma `tabela_atribuicao`. O armazenamento em JSON único não permite que o Supabase faça verificações relacionais (por exemplo, buscar facilmente no dashboard "Quais processos estão atribuídos para usuários com o perfil Chefia?").

### O que precisará ser feito (Plano de Ação para esta Pendência):
1. **Substituir o Mock:** Mudar a lógica do `configuracoes.js` para não gerar servidores "A, B, C" falsos, mas sim fazer um `.select()` na `tabela_spu` para listar os servidores reais cadastrados.
2. **Refatorar o Salvamento (CRUD Relacional):** Abandonar o uso da linha global `GLOBAL_CONFIG_ROLES` na tabela de drafts. O salvamento deve inserir registros individuais na `tabela_spu` (ou atualizá-la) definindo a UF, o Perfil e a flag `can_distribute` para cada usuário.
3. **Sincronizar com o Dashboard (`index.html`):** Uma vez que a equipe seja configurada de forma relacional, a coluna "Atribuído para" no dashboard e os fluxos de devolutiva poderão consultar diretamente a tabela para saber a quem o processo pertence e quem pode tramitá-lo.
