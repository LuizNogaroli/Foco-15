# KB: Handoff — Estado do Projeto Foco-15 (2026-07-19)

**Data:** 2026-07-19 01:10
**Última sessão:** CRUD servidores, importação CSV/XLSX, autosave AJAX, pendências atualizadas

---

## Estado Atual do Sistema

### O que funciona
1. **Login** — customizado SPUnet, suporte email ou CPF, senha `password`
2. **Painel de processos** — filtros (UF, Município, Status, Tipo, Interessado, RIP), "Meus Processos", simulador de perfil (admin)
3. **Workflow completo** — 12 status, abas 1→2→3→7 com 7 fases de assinatura
4. **Aba 1 (Indicação do Imóvel)** — formulário completo, accordion expansão padrão
5. **Aba 2 (Diagnóstico Preliminar)** — diagnóstico, geolocalização, incidências
6. **Aba 3 (Análise de Viabilidade)** — análise completa, 46+ campos
7. **Aba 7 (Manifestações)** — Chefia→Coordenação→Superintendência→Equipe C.G.→Coord-Geral→Direção→CDE, aprovação/devolução, CDE competência
8. **Autosave AJAX** — abas 1, 2, 3 e 7, salva a cada 2s de inatividade, restaura ao reabrir
9. **Equipes** — grid regional 5 regiões, add/remove por UF/perfil, 27 UFs
10. **Servidores** — CRUD completo, busca, filtro, edição, 738 registros (10 admin + 728 servidores)
11. **Importação CSV/XLSX** — 728 servidores importados via maatwebsite/excel
12. **Seeders** — 60 processos, 60 requerimentos, 10 tipos, 27 UFs, 30 interessados

### Pendências restantes (2 itens)
1. **Atribuição explícita de processo a servidor** — hoje o servidor vê processos do seu perfil via status, mas não é designado individualmente
2. **Sistema de capacidades/permissões granular** — além do role, controlar quem pode devolver, quem pode aprovar CDE, etc.

---

## Arquitetura

```
Foco-15/
├── app/
│   ├── Http/Controllers/
│   │   ├── ProcessoController.php    # Workflow principal
│   │   ├── EquipeController.php      # CRUD equipes + importar
│   │   ├── ServidorController.php    # CRUD servidores
│   │   ├── DraftController.php       # Autosave AJAX
│   │   ├── ConfiguracoesController.php
│   │   └── Auth/                     # Login customizado
│   ├── Imports/
│   │   └── ServidoresImport.php      # maatwebsite/excel
│   └── Models/
│       ├── Processo.php              # foco(), tramites(), requerimento()
│       ├── User.php                  # equipes(), cpf, cargo, telefone
│       ├── Foco.php                  # $table='foco', hasMany rips/cadastros
│       ├── FocoAba1/2/3.php
│       ├── FocoRip.php
│       ├── FocoCadastroMinimo.php
│       ├── FocoDraft.php             # Autosave
│       └── EquipeServidor.php
├── database/
│   ├── migrations/
│   │   ├── ..._create_foco_tables.php          # 6 tabelas foco
│   │   ├── ..._update_processos_defaults.php   # Status default
│   │   ├── ..._add_municipio_to_processos.php
│   │   ├── ..._add_cpf_to_users.php
│   │   ├── ..._create_equipe_servidores.php
│   │   └── ..._create_foco_drafts.php          # Autosave
│   └── seeders/
│       ├── RoleSeeder.php           # 9 perfis (firstOrCreate)
│       ├── UserSeeder.php           # 10 admins
│       ├── ServidorSeeder.php       # 728 servidores (bulk insert)
│       ├── EquipeServidorSeeder.php # 437 vínculos
│       └── ProcessoSeeder.php       # 60 processos
├── resources/views/
│   ├── auth/login.blade.php         # Login SPUnet
│   ├── processos/
│   │   ├── index.blade.php          # Painel + filtros + simulador
│   │   ├── show.blade.php           # Layout abas + autosave
│   │   └── abas/
│   │       ├── aba1.blade.php       # Indicação do Imóvel
│   │       ├── aba2.blade.php       # Diagnóstico Preliminar
│   │       ├── aba3.blade.php       # Análise de Viabilidade
│   │       └── aba7.blade.php       # Manifestações (7 perfis)
│   ├── equipe/index.blade.php       # Grid regional + importar
│   └── servidores/
│       ├── index.blade.php          # CRUD listagem
│       └── edit.blade.php           # Edição
├── public/js/
│   ├── autosave.js                  # Autosave AJAX
│   ├── foco-01.js, foco-02.js, foco-03.js, foco-07.js
│   └── sync.js, restore-foco-01.js
├── routes/web.php                   # Todas as rotas
└── .agents/AGENTS.md                # Regras KB + rollback
```

## Tabelas do Banco (SQLite)

| Tabela | Registros | Descrição |
|---|---|---|
| users | 738 | 10 admin + 728 servidores |
| roles | 9 | Spatie Permission |
| processos | 60 | Processos de destinação |
| requerimentos | 60 | 1:1 com processos |
| foco | 60 | 1:1 com processos |
| foco_aba1/2/3 | 60 cada | Dados por aba |
| foco_rips | variável | 1:N por processo |
| foco_cadastros_minimos | variável | 1:N por processo |
| equipe_servidores | 437 | Vínculos user×perfil×UF |
| foco_drafts | 0 | Autosave (limpo) |
| tramites | variável | Histórico de movimentações |

## Comandos Úteis

```bash
php artisan db:seed                    # Popular tudo
php artisan drafts:clean               # Limpar rascunhos >7 dias
php artisan migrate                    # Rodar migrations
php artisan route:list                 # Listar rotas
php artisan view:cache                 # Compilar views
```

## Senhas

- Todos os usuários: `password`
- Usuários de teste: admin@spu.gov.br, destinacao@spu.gov.br, etc.

## Próximos Passos (amanhã)

1. **Atribuição explícita de processo a servidor** — tabela pivot `processo_servidor` ou campo `responsavel_id` no processo
2. **Permissões granulares** — Spatie Permission com permissions específicas (ex: `devolver.processo`, `aprovar.cde`)
3. Testar workflow end-to-end com equipes configuradas
4. Testar autosave em todas as abas
