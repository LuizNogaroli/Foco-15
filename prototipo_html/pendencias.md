# Pendências

Atualizado em: 2026-07-19 23:30

## Tarefas a resolver:
- [x] ~~Nas abas 1, 2 e 3 resolver a questão do salvar rascunho e concluir e enviar~~ → Autosave AJAX implementado — abas 1, 2, 3 e 7 (2026-07-19)
- [x] ~~Indicador visual de autosave no menu superior~~ → Dot discreto no header: cinza=idle, amarelo=pulsando=salvando, verde=salvo, vermelho=erro (2026-07-19)
- [x] ~~Melhorar visualização da paginação~~ → View customizada `vendor.pagination.custom`, CSS com botões arredondados, texto limpo, sem SVGs gigantes (2026-07-19)
- [ ] No painel administrativo, resolver a mecânica de criar equipes e atribuir processos e capacidades
  - [x] ~~Criar equipes~~ → CRUD completo em /equipe (2026-07-18)
  - [x] ~~Importar servidores~~ → CSV/XLSX via maatwebsite/excel (2026-07-18)
  - [x] ~~CRUD de servidores~~ → /servidores com busca, filtro, edição, exclusão (2026-07-18)
  - [ ] Atribuição explícita de processo a servidor (designação individual)
  - [ ] Sistema de capacidades/permissões granular além do role
- [x] ~~Meus Processos não filtrava por UF~~ → Filtro agora consulta equipe_servidores para UFs do perfil; admin simulador busca UFs de todos servidores com aquele perfil (2026-07-19)
- [x] ~~Controle de acesso por perfil no painel~~ → `perfilPodeOperar()` impede abrir processos em status indevido; modal "Acesso Restrito" (2026-07-19)
- [x] ~~Controle de abas na navegação do processo~~ → `getAbasDoPerfil()` restringe quais abas aparecem no menu superior (2026-07-19)
- [x] ~~Cookie perfil_simulado descriptografado pelo Laravel~~ → `encryptCookies(except: ['perfil_simulado'])` em bootstrap/app.php (2026-07-19)
