# KB: CRUD de Servidores, Importação CSV/XLSX e Seeders em Massa

**Data:** 2026-07-18 23:50

## Contexto

O projeto Foco-15 precisava de:
1. Gestão completa de servidores (CRUD) para alimentar as equipes por UF
2. Importação de dados de servidores de planilhas CSV/XLSX (dados reais virão de sistema legado)
3. Seeders para popular a base com dados fictícios para testes

## Soluções Implementadas

### 1. Migration: cargo e telefone no user
- **Arquivo:** `database/migrations/2026_07_18_233438_add_cargo_telefone_to_users_table.php`
- Adiciona `cargo` (nullable) e `telefone` (nullable) à tabela `users`
- `cargo` = cargo de origem do servidor (ex: "Engenheiro Civil", "Técnico em Meio Ambiente"), NÃO a função no fluxo Foco

### 2. Lib maatwebsite/excel
- Instalada via Composer para suporte a CSV e XLSX
- Peso: ~8 packages (PhpSpreadsheet, ZipStream, etc.)

### 3. ServidoresImport (app/Imports/ServidoresImport.php)
- Implementa `ToModel` + `WithHeadingRow` do maatwebsite/excel
- Colunas esperadas: `Nome`, `CPF`, `Cargo`, `Email_Institucional` (ou `Email`), `Telefone_de_Contato` (ou `Telefone`), `Superintendencia_UF` (ou `UF`)
- CPFs duplicados → atualiza dados existentes (não cria duplicata)
- Senha padrão para novos: `password`
- Log de erros parcial (até 5 mensagens)

### 4. ServidorController (app/Http/Controllers/ServidorController.php)
- `GET /servidores` → listagem com busca (nome/email/CPF) + filtro UF + paginação
- `POST /servidores` → criação com validação (email e CPF únicos)
- `GET /servidores/{user}` → edição (mostra equipes vinculadas)
- `PUT /servidores/{user}` → atualização (senha opcional)
- `DELETE /servidores/{user}` → desativa vínculos de equipe + remove user

### 5. EquipeController@importar
- `POST /equipe/importar` → recebe arquivo, roda `ServidoresImport`, retorna log

### 6. Seeders
- **ServidorSeeder:** 28 UFs (27 + UC) × 26 servidores (A-Z) = 728 registros
  - Bulk insert com `DB::table()->insert()` em chunks de 100
  - Hash de senha pré-computado (bcrypt lento pra 728 chamadas)
  - Cargo de origem rotaciona entre 20 cargos típicos da SPU
- **EquipeServidorSeeder:** Distribui servidores nos 9 perfis por UF
  - Chefia/Coord/Superint/Direção/CG: 1 pessoa
  - Equipe Destinação/Caracterização: 2-4 pessoas
  - CDE: 2-3 pessoas
  - Bulk insert em chunks de 200
- **RoleSeeder:** Corrigido de `create()` para `firstOrCreate()` (idempotente)

### 7. Views
- `servidores/index.blade.php`: listagem, toolbar busca/filtro, modal novo servidor
- `servidores/edit.blade.php`: edição com campos + equipes vinculadas
- `equipe/index.blade.php`: adicionado botão "Importar CSV/XLSX" + modal + link "Gestão de Servidores"
- `processos/index.blade.php`: navbar com botões 👥 Equipe e 📋 Servidores

### 8. Navegação
- Painel → Equipe / Servidores (botões na navbar)
- Equipe → Servidores / Importar (links e botões)
- Servidores → Equipe (link na navbar)

## Decisões Técnicas
- `cargo` na tabela `users` (não em `equipe_servidores`) porque é propriedade do servidor, não do vínculo com equipe
- Hash de senha pré-computado para performance (bcrypt ~100ms × 728 = ~72s → 1 chamada)
- Bulk insert via `DB::table()` em vez de Eloquent para performance
- `RoleSeeder` com `firstOrCreate()` para ser idempotente (pode rodar múltiplas vezes)

## Resultado Final
| Tabela | Registros |
|---|---|
| Users | 738 (10 admin + 728 servidores) |
| EquipeServidores | 437 vínculos em 27 UFs |
| Processos | 60 |
| Requerimentos | 60 |
