# KB: Handoff — Estado do Projeto Foco-15 (2026-07-19 23:30)

**Data:** 2026-07-19 23:30
**Última sessão:** Controle de acesso por perfil, fix cookie simulador, paginação customizada, filtro Meus Processos por UF

---

## Estado Atual do Sistema

### O que funciona
1. **Login** — customizado SPUnet, suporte email ou CPF, senha `password`
2. **Painel de processos** — filtros (UF, Município, Status, Tipo, Interessado, RIP), "Meus Processos" com filtro por UF via equipe_servidores, simulador de perfil (admin)
3. **Workflow completo** — 12 status, abas 1→2→3→7 com 7 fases de assinatura
4. **Controle de acesso por perfil** — `perfilPodeOperar()` impede abrir processos em status indevido; modal "Acesso Restrito" aparece no painel
5. **Navegação de abas restrita** — `getAbasDoPerfil()` oculta abas que o perfil não pode acessar (Destinação: 1,2,3; Caracterização: 1,2; demais: 7)
6. **Fix cookie simulador** — `encryptCookies(except: ['perfil_simulado'])` em bootstrap/app.php; cookie JS não é mais descriptografado pelo Laravel
7. **Aba 1 (Indicação do Imóvel)** — formulário completo, accordion
8. **Aba 2 (Diagnóstico Preliminar)** — diagnóstico, geolocalização, incidências
9. **Aba 3 (Análise de Viabilidade)** — análise completa, 46+ campos
10. **Aba 7 (Manifestações)** — 7 fases de assinatura, aprovação/devolução, CDE competência
11. **Autosave AJAX** — abas 1, 2, 3 e 7, salva a cada 2s de inatividade, restaura ao reabrir
12. **Equipes** — grid regional 5 regiões, add/remove por UF/perfil, 27 UFs
13. **Servidores** — CRUD completo, busca, filtro, edição, 738 registros
14. **Importação CSV/XLSX** — 728 servidores importados via maatwebsite/excel
15. **Paginação** — view customizada com botões arredondados, texto "Mostrando X a Y de Z resultados"
16. **Seeders** — 60 processos, 60 requerimentos, 10 admin + 728 servidores, 437 vínculos equipe

### Pendências restantes (2 itens)
1. **Atribuição explícita de processo a servidor** — tabela pivot `processo_servidor` ou campo `responsavel_id`
2. **Sistema de capacidades/permissões granular** — Spatie Permission com permissions específicas (ex: `devolver.processo`, `aprovar.cde`)

---

## Arquitetura

```
Foco-15/
├── app/
│   ├── Http/Controllers/
│   │   ├── ProcessoController.php    # Workflow + controle de acesso
│   │   ├── EquipeController.php      # CRUD equipes + importar
│   │   ├── ServidorController.php    # CRUD servidores
│   │   ├── DraftController.php       # Autosave AJAX
│   │   ├── ConfiguracoesController.php
│   │   └── Auth/                     # Login customizado
│   ├── Imports/
│   │   └── ServidoresImport.php      # maatwebsite/excel
│   ├── Models/
│   │   ├── Processo.php              # foco(), tramites(), requerimento()
│   │   ├── User.php                  # equipes(), cpf, cargo, telefone
│   │   ├── Foco.php                  # $table='foco', hasMany rips/cadastros
│   │   ├── FocoAba1/2/3.php
│   │   ├── FocoRip.php
│   │   ├── FocoCadastroMinimo.php
│   │   ├── FocoDraft.php             # Autosave
│   │   └── EquipeServidor.php
│   └── Providers/
│       └── AppServiceProvider.php    # Paginator::defaultView()
├── bootstrap/
│   └── app.php                       # encryptCookies(except: ['perfil_simulado'])
├── database/
│   ├── migrations/
│   │   ├── ..._create_foco_tables.php          # 6 tabelas FK → 'foco'
│   │   ├── ..._update_processos_defaults.php
│   │   ├── ..._add_municipio_to_processos.php
│   │   ├── ..._add_cpf_to_users.php
│   │   ├── ..._add_cargo_telefone_to_users.php
│   │   ├── ..._create_equipe_servidores.php
│   │   └── ..._create_foco_drafts.php
│   └── seeders/
│       ├── RoleSeeder.php           # 9 perfis (firstOrCreate)
│       ├── UserSeeder.php           # 10 admins + cargo + telefone
│       ├── ServidorSeeder.php       # 728 servidores (bulk insert)
│       ├── EquipeServidorSeeder.php # 437 vínculos
│       └── ProcessoSeeder.php       # 60 processos
├── resources/views/
│   ├── auth/login.blade.php
│   ├── processos/
│   │   ├── index.blade.php          # Painel + filtros + modal acesso negado
│   │   ├── show.blade.php           # Abas com restrição por perfil
│   │   └── abas/
│   │       ├── aba1/aba2/aba3/aba7.blade.php
│   ├── equipe/index.blade.php
│   ├── servidores/index.blade.php + edit.blade.php
│   └── vendor/pagination/custom.blade.php  # Paginação customizada
├── public/
│   ├── css/dashboard.css             # Estilos + paginação
│   └── js/autosave.js, foco-01/02/03/07.js
├── routes/web.php
└── .agents/AGENTS.md
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
| foco_drafts | 0 | Autosave |
| tramites | variável | Histórico de movimentações |

## Lógica de Controle de Acesso

### Quem acessa qual aba
| Perfil | Abas acessíveis |
|---|---|
| Equipe Destinação | 1, 2, 3 |
| Equipe Caracterização | 1, 2 |
| Chefia | 7 |
| Coordenação | 7 |
| Superintendência | 7 |
| Equipe C.G. | 7 |
| Coordenação-Geral | 7 |
| Direção | 7 |
| CDE | 7 |

### Quem opera qual status (perfilPodeOperar)
| Status | Perfis permitidos |
|---|---|
| Aguardando Análise | Equipe Destinação |
| Indicação do Imóvel | Equipe Destinação, Equipe Caracterização |
| Diagnóstico Preliminar | Equipe Caracterização, Equipe Destinação |
| Análise de Viabilidade | Destinação + todos acima de chefia |
| Validação - [Chefia/Coordenação/C.G./Coord-Geral/Direção] | Perfil correspondente |
| Deliberação - [Superintendência/CDE] | Perfil correspondente |

### Fix do cookie simulador
- **Problema:** `EncryptCookies` do Laravel descriptografava cookie setado por JS → `request()->cookie('perfil_simulado')` retornava null → `getPerfilAtual()` caía no role real do admin
- **Solução:** `bootstrap/app.php` → `$middleware->encryptCookies(except: ['perfil_simulado'])`

## Comandos Úteis

```bash
php artisan db:seed                    # Popular tudo
php artisan drafts:clean               # Limpar rascunhos >7 dias
php artisan migrate                    # Rodar migrations
php artisan route:list                 # Listar rotas
php artisan vendor:publish --tag=laravel-pagination  # Publicar views de paginação
```

## Senhas

- Todos os usuários: `password`
- Admin: admin@spu.gov.br (CPF: 12345678901)

## Próximos Passos

1. **Atribuição explícita de processo a servidor** — tabela pivot `processo_servidor` para que "Meus Processos" filtre por designação real
2. **Permissões granulares** — Spatie Permission com permissions específicas
3. Testar workflow end-to-end com equipes configuradas
4. Testar autosave em todas as abas
