# Arquitetura Futura: Versionamento de Resumos e Histórico de Despachos

## 1. Contexto e Requisito
Durante as idas e vindas de um processo (tramitações, manifestações e devoluções para correção), os dados preenchidos nas Abas 1, 2 e 3 podem sofrer alterações. O cliente determinou que o sistema deverá **manter o registro histórico e imutável de cada versão dos resumos** submetidos à Chefia, bem como registrar permanentemente no processo os "carimbos" das decisões (com nome e timestamp do decisor) e as justificativas exatas em caso de devolução.

## 2. Diretrizes de Implementação Futura

### 2.1. Versionamento Estático (Snapshots)
- Sempre que um processo for tramitado (enviado para aprovação), o sistema deverá gerar uma "fotografia" (snapshot) do estado atual das abas 1, 2 e 3.
- Essas fotografias podem ser armazenadas no banco de dados (ex: tabela `tramites` ou `historico_versoes`) no formato JSON `snapshot_dados`, ou através de arquivos/arquivos Blade versionados por timestamp (`aba1a_v20260722_1400.blade.php`, embora o banco de dados via JSON seja a prática mais limpa e escalável no ecossistema Laravel).
- Ao visualizar o "Histórico do Processo", o usuário deverá ser capaz de abrir um acordeão de um trâmite passado e enxergar os dados *exatamente como estavam* na data daquele trâmite, utilizando a estrutura visual das views em `resources/views/processos/abas/resumos/` alimentadas pelo JSON histórico, e não pelos dados atuais da tabela principal (`foco_abaX`).

### 2.2. Carimbos de Decisão e Justificativas Chapadas
- **Carimbos de Decisão:** O momento em que o gestor aperta o botão "Aprovar" ou "Devolver" precisa gerar um registro definitivo (carimbo) no trâmite, armazenando o ID/Nome do usuário, o Perfil pelo qual ele atuou (ex: "Chefia"), a decisão, e o timestamp exato (`created_at` do trâmite).
- **Justificativas de Devolução:** Se houver devolução, a justificativa digitada no formulário da Aba 7 deve ser "chapada" (hardcoded/imutável) no registro do processo (atrelada ao histórico daquele trâmite). Quando o processo voltar para a equipe técnica, a justificativa será exibida em destaque no topo da tela para guiar as correções, e permanecerá salva no log histórico mesmo após a correção ser feita.

## 3. Impacto Arquitetural
- O controlador `ProcessoController` (especificamente o método de tramitação) será o responsável por serializar os dados das abas (foco) em JSON no momento do trâmite.
- As views parciais que criamos hoje (`aba1a.blade.php`, etc.) deverão aceitar flexivelmente tanto o array `$dadosX` atual quanto um array decodificado do `snapshot_dados` de um trâmite antigo.
- Essa abordagem de versionamento protegerá juridicamente e administrativamente o fluxo do processo, garantindo auditoria completa de "quem viu o quê e quando".
