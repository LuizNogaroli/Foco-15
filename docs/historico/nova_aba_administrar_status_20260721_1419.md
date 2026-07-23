# Log de Implementação: Nova aba Administrar Status nas Configurações

## Arquivos Modificados
- `app/Http/Controllers/ConfiguracoesController.php`
- `resources/views/configuracoes.blade.php`
- `public/js/configuracoes.js`

## Motivo da Alteração
Adição de uma funcionalidade para usuários com perfil de Administrador (ou com simulador ativado). Essa funcionalidade permite alterar manualmente o status de um requerimento em andamento diretamente no Supabase (`tabela_status_fluxo`), lidando com exceções operacionais.

## 1. Estado Anterior (Antes)
- A tela `configuracoes.blade.php` exibia diretamente o título "Selecione a UF" na barra lateral e o painel de Gestão de Equipe ocupava a interface principal.
- Não existia o menu superior para navegação por abas.

## 2. Estado Novo (Depois)
- **Controller**: Foi adicionada a checagem da role `Administrador` ou cookie `perfil_simulado === 'Administrador'`, repassando a variável `$isAdmin` para a view.
- **View**: A barra lateral ganhou um condicional `@if(isset($isAdmin) && $isAdmin)` renderizando o "Menu Principal" (Gestão de Equipe e Administrar Status). O painel de gestão anterior foi envelopado num `<div id="panelGestao">`, e o novo painel HTML `<div id="panelStatus">` foi embutido, contendo input de ID, campo para exibir o status atual, dropdown de novos status, e botões.
- **JavaScript**: Novas funções foram inseridas: `toggleConfigTab`, `buscarStatusRequerimento` (via GET no endpoint rest) e `salvarNovoStatus` (via POST com o novo json de status atualizado).

## 3. Plano de Rollback / Desfazer
Para reverter a feature:
1. Em `configuracoes.js`, apague todo o trecho abaixo de `// FUNÇÕES DE ADMINISTRAR STATUS`.
2. Em `configuracoes.blade.php`, apague o condicional do `@if(isset($isAdmin))` na tag `<aside>`, desfaça o encapsulamento das divs `<div id="panelGestao">` e delete a div `<div id="panelStatus">`.
3. No `ConfiguracoesController.php`, apague a injeção do `$isAdmin` e reverta a injeção no `compact('users')`.

## Correção de Bug (20260721_1425)
O simulador de perfil define o valor do cookie para o Administrador como ALL, não como Administrador. O ConfiguracoesController foi atualizado para verificar se o valor do cookie é ALL também.

## Correção de Bug (20260721_1429)
Permitir a criação forçada de status para processos que não constam na tabela_status_fluxo. Caso o processo não possua status, a interface assume {} e permite salvar, inicializando-o no Supabase.

## Correção de Funcionalidade (20260721_1434)
O select de status agora puxa os status dinamicamente da constante WORKFLOW_STAGES importada de workflow.js. Isso garante que as opções listadas para o Administrador sejam sempre equivalentes às etapas oficiais que os processos podem assumir.

## Correção de Bug (20260721_1439)
A função de salvarNovoStatus foi ajustada para distinguir entre um status recém-criado e um status pré-existente. Se o processo já existir na tabela_status_fluxo, envia-se um PATCH; se não existir, envia-se um POST, evitando erros 409 Conflict.

## Correção de Validação de Requerimento e Exibição de Erros (20260721_1446)
1. A busca de requerimentos sem status agora consulta a 	abela_requerimentos no Supabase antes de permitir a inicialização. Se o número não existir na chave estrangeira do Supabase, o sistema emite um alerta informando os formatos/IDs válidos (ex: SP2026008, RJ2026004).
2. Os alertas de erro agora exibem a mensagem real retornada (e.message), detalhando falhas de rede ou restrições de banco.

## Melhoria na Mensagem de Validação (RIP vs Requerimento) (20260721_1449)
Aprimorada a mensagem de aviso ao usuário quando é digitado um número de RIP/imóvel em vez de um Número de Requerimento válido (ex: SP2026008). O formulário permanece oculto garantindo a integridade dos dados.

## Sincronização Automática de Requerimentos Laravel x Supabase (20260721_1506)
Como os requerimentos do Painel de Requerimentos são gerados pelo Laravel e nem todos possuíam uma entrada sincronizada no Supabase PostgreSQL, a busca de status foi ajustada para auto-cadastrar o requerimento na 	abela_requerimentos do Supabase caso ele ainda não conste por lá. Isso permite que qualquer requerimento válido do painel (como AC2026002) tenha seu status alterado pelo Administrador sem erros de chave estrangeira.

## Sincronização Dupla: Supabase x Banco Local Laravel (20260721_1511)
Adicionada rota /configuracoes/atualizar-status-processo no Laravel para atualizar a coluna status_atual do modelo Processo no banco de dados local. Quando o Administrador salva o novo status, a alteração é gravada tanto no Supabase quanto no Laravel, garantindo que o Painel de Requerimentos principal reflita a mudança imediatamente.

## Correção na Compatibilidade de NOMES DE STATUS e Exibição da Lupa (20260721_1517)
O ProcessoController utilizava termos com maiúsculas distintas (ex: Indicação do Imóvel vs Indicação do imóvel oficial do fluxo), fazendo com que a checagem in_array(, ) falhasse silenciosamente e oculta-se o ícone da Lupa (🔎). Foram adicionadas ambas as variações no mapeamento de todos os perfis e garantido que o perfil de Administrador (ALL) consiga visualizar a Lupa em qualquer status.

## Fallback de Relatório da Aba 1 (foco-01-resumo) (20260721_1605)
Quando o status de um requerimento é alterado manualmente pelo Administrador sem que a Aba 1 tenha sido salva no formulário prévio, o relatório foco-01-resumo.html não encontrava registro na tabela_relatorios e exibia a mensagem "Nenhum relatório salvo encontrado...". Adicionado um mecanismo de fallback automático em foco-01-resumo.html que consulta os dados de tabela_requerimentos e renderiza o Relatório Consolidado da Aba 1 normalmente.

## Correção Crítica do Identificador do Processo em show.blade.php (20260721_1610)
Identificado a causa raiz da mensagem "Nenhum relatório salvo...": o layout master `show.blade.php` gravava no `localStorage.setItem("CURRENT_PROCESS_ID", ...)` o ID numérico sequencial interno do Laravel (ex: 44) em vez do Código do Requerimento oficial (ex: AC2026002). Como os relatórios em `tabela_relatorios` e os dados em `tabela_requerimentos` utilizam o código como chave (`numero_requerimento`), a consulta no iframe zerava e caía no aviso de relatório ausente. Corrigido `show.blade.php` para utilizar `$processo->numero_requerimento` e adicionado fallback de identificador nos relatórios resumo.

## Correção nos Caminhos do Estilo de Relatórios (report.css) (20260721_1614)
Identificado o motivo do relatório ser renderizado sem formatação CSS dentro dos seções/accordions: as páginas de resumo (como `foco-01-resumo.html`) apontavam para o caminho relativo `report.css`, porém o arquivo CSS estava localizado em `public/css/report.css`. O arquivo foi duplicado para a raiz pública `public/report.css` e as tags de estilo de todos os arquivos HTML em `public/` foram atualizadas para carregar tanto `css/report.css` quanto `report.css`, garantindo a aplicação dos estilos visuais.

## Desbloqueio do Formulário para Simulador de Perfil e Administrador (20260721_1618)
A instrução `<fieldset disabled>` em `aba2.blade.php`, `aba3.blade.php` e `aba7.blade.php` utilizava a verificação rígida `!auth()->user()->hasRole(...)`, ignorando o cookie de simulação de perfil (`perfil_simulado`) e o perfil de Administrador (`ALL`). Isso fazia com que os formulários e seus checkboxes permanecessem travados para interação quando o usuário alternava o simulador de perfil ou era Administrador. Ajustadas as regras dos `<fieldset>` em todas as abas para liberarem a edição de formulários quando o perfil simulado corresponder à etapa (ex: CARACTERIZACAO na Aba 2, DESTINACAO na Aba 3) ou for Administrador (ALL).

## Regra de Negócio Confirmada: Competência de Edição da Aba 3 (20260721_1620)
Confirmada e garantida a regra de negócio estrita de que na Aba 3 (Análise de Viabilidade e Proposta de Destinação), SOMENTE o perfil "Técnico — Destinação" (`DESTINACAO` / `Equipe Destinação`) e Administrador possuem competência para editar os campos do formulário. Perfis hierárquicos superiores (Chefia, Coordenação, Superintendência, etc.) não editam a Aba 3 (atuando posteriormente na Aba 7 de deliberação/manifestação).

## Correção do Avanço de Status na Tramitação da Aba 2 (20260721_1625)
Identificada falha na estrutura condicional do método `tramitar()` em `ProcessoController.php`: a ramificação `$effectiveAba == "2"` estava com um bloco duplicado da Aba 1 (salvando `FocoAba1` e mantendo o status em "Diagnóstico Preliminar"). O bloco foi corrigido para salvar os dados da Aba 2 (`FocoAba2`) e atualizar o status do processo para "Análise de Viabilidade". Além disso, foi implementada a sincronização automática imediata do novo status com a tabela local `requerimentos` e a `tabela_requerimentos` do Supabase via `syncProcessoStatusToSupabase()` ao salvar/tramitar/devolver qualquer aba.

## Correção de Interatividade dos Accordions de Resumo na Aba 3 (20260721_1630)
Identificada a causa da dificuldade de interação e carregamento dos accordions de resumo (Aba 1 e Aba 2) dentro da Aba 3: os blocos dos accordions de revisão estavam posicionados dentro da tag `<fieldset disabled>`. Em navegadores modernos, elementos interativos (como cabeçalhos de accordion com `onclick`) dentro de um `<fieldset disabled>` têm seus eventos de clique suprimidos nativamente. Reposicionados os accordions de revisão (Aba 1, Aba 2 e RIPs) em `aba2.blade.php` e `aba3.blade.php` para fora do `<fieldset disabled>`, garantindo expansão, recolhimento e carregamento fluido dos relatórios iframe em qualquer perfil ou estado do formulário.

## Correção no Carregamento do Resumo da Aba 2 (20260721_1632)
Implementado mecanismo de fallback dinâmico em `foco-02-resumo.html`: quando o relatório ainda não estiver gravado especificamente em `tabela_relatorios` (aba=aba2), o script realiza a consulta dos dados em `tabela_requerimentos` (campo `dados_json`), montando o resumo do Diagnóstico Preliminar instantaneamente para exibição nos accordions de revisão (ex: Aba 3).

## Correção do Erro Javascript updated_at em foco-02-resumo.html (20260721_1635)
Identificado o erro `Cannot read properties of undefined (reading updated_at)` no script de resumo da Aba 2: quando o relatório utilizava o resgate por fallback (quando `tabela_relatorios` retornava um array vazio `[]`), o código tentava ler `data[0].updated_at`, gerando uma exceção de referência nula. O script foi corrigido para utilizar a variável `dateObj` já tratada e inicializada no fallback, garantindo a exibição limpa da data do relatório sem erro JS.

## Resgate Triplo de Dados para o Accordion de RIPs/Cadastros Mínimos na Aba 3 (20260721_1636)
Implementado mecanismo de consulta tripla com fallback automático no accordion "RIP(s) ou Cadastro(s) Mínimo(s)" em `aba3.blade.php`: a consulta busca primeiro na `tabela_indicacao` do Supabase; em caso de ausência, recorre a `tabela_requerimentos`; e por fim, consome diretamente as relações do banco MySQL local (`$processo->foco->rips` e `$processo->foco->cadastrosMinimos`), garantindo que os imóveis e cadastros associados apareçam de forma consistente em qualquer estado do processo.

## Correção do Carregamento dos Scripts de Busca SPU em show.blade.php e aba3.blade.php (20260721_1641)
Identificada a razão da mensagem "carregando informações dos imóveis..." permanecer travada: o script de integração `fetch_spu.js` não estava registrado no layout master `show.blade.php`, e os caminhos dos scripts em `aba3.blade.php` utilizavam rotas relativas (ex: `scripts/fetch_spu.js`), resultando em erros 404 ao carregar a partir de rotas com parâmetros da aplicação Laravel (`/processos/44?aba=3`). Copiados os scripts para as pastas públicas (`public/js/` e `public/scripts/`), incluído `fetch_spu.js` em `show.blade.php` e atualizadas todas as tags de script para utilizar o helper `asset()`, garantindo o carregamento imediato das informações SPU dos RIPs.

## Correção no Carregamento de RIPs da Aba 1 (20260721_1644)
Identificado o motivo do RIP cadastrado não reaparecer ao retornar à Aba 1: o script `db.js` (que provê a função `carregarIndicacoes`) não estava incluído no layout master `show.blade.php`, e a lógica de carga dependia exclusivamente de `window.parent.carregarIndicacoes`. Incluído `db.js` em `show.blade.php`, atualizado `foco-01.js` para buscar `window.carregarIndicacoes` localmente e adicionado o fallback para variáveis inline (`window.INLINE_RIPS` e `window.INLINE_CADASTROS`) vindas diretamente da base MySQL do Laravel (`$processo->foco->rips`), garantindo a preservação e exibição contínua dos RIPs inseridos.

## Correção de SyntaxError em aba3.blade.php (20260721_1653)
Identificada a causa real do travamento "Carregando informações dos imóveis..." na Aba 3: havia uma declaração duplicada das funções `toggleBloco` e `limparErro` no bloco `<script>` no final do arquivo `aba3.blade.php`. A duplicidade causava um `SyntaxError: Identifier toggleBloco has already been declared`, o que interrompia a execução de todo o bloco de código JavaScript antes mesmo de rodar a rotina de busca de RIPs. A função duplicada foi removida, garantindo que o fluxo assíncrono conclua e esconda a mensagem de carregamento.
