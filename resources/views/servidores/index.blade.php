<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPUnet - Gestão de Servidores</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', 'Segoe UI', Arial, sans-serif; background: #f1f5f9; color: #334155; }

        .navbar { background: #fff; border-bottom: 1px solid #e2e8f0; padding: 14px 30px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 100; }
        .navbar-brand { display: flex; align-items: center; gap: 12px; }
        .navbar-brand .logo { font-size: 1.3rem; font-weight: 800; color: #1e3a5f; letter-spacing: -1px; }
        .navbar-brand .logo span { color: #2e7d32; }
        .navbar-brand .divider { width: 1.5px; height: 22px; background: #cbd5e1; }
        .navbar-brand h1 { font-size: 0.95rem; font-weight: 600; color: #1e293b; }
        .navbar-brand span { font-size: 0.78rem; color: #64748b; }
        .navbar-actions { display: flex; gap: 10px; }
        .navbar-actions a { padding: 8px 14px; border-radius: 6px; text-decoration: none; font-size: 0.85rem; font-weight: 500; color: #64748b; transition: all 0.2s; }
        .navbar-actions a:hover { background: #f1f5f9; color: #1e293b; }
        .navbar-actions a.active { background: #1e3a5f; color: #fff; }

        .container { max-width: 1100px; margin: 30px auto; padding: 0 20px; }

        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .page-header h1 { font-size: 1.5rem; font-weight: 700; color: #1e293b; }

        .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 0.85rem; font-weight: 500; }
        .alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .alert-error { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }

        .toolbar { display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap; }
        .toolbar input, .toolbar select { padding: 8px 12px; border: 1.5px solid #d1d5db; border-radius: 6px; font-size: 0.85rem; font-family: inherit; }
        .toolbar input:focus, .toolbar select:focus { border-color: #1e3a5f; outline: none; }
        .toolbar input { flex: 1; min-width: 200px; }
        .toolbar select { min-width: 100px; }

        .btn { padding: 8px 16px; border-radius: 6px; border: none; cursor: pointer; font-size: 0.85rem; font-weight: 600; transition: all 0.2s; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
        .btn-primary { background: #1e3a5f; color: #fff; }
        .btn-primary:hover { background: #17375a; }
        .btn-success { background: #16a34a; color: #fff; }
        .btn-success:hover { background: #15803d; }
        .btn-outline { background: #fff; color: #475569; border: 1.5px solid #d1d5db; }
        .btn-outline:hover { background: #f8fafc; border-color: #94a3b8; }

        .card { background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; overflow: hidden; }
        .card-header { padding: 14px 18px; background: #f8fafc; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; }
        .card-header h3 { font-size: 0.95rem; font-weight: 700; color: #1e293b; }

        table { width: 100%; border-collapse: collapse; }
        thead th { padding: 10px 14px; text-align: left; font-size: 0.78rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.3px; background: #f8fafc; border-bottom: 1px solid #e2e8f0; }
        tbody td { padding: 11px 14px; font-size: 0.85rem; border-bottom: 1px solid #f1f5f9; }
        tbody tr:hover { background: #f8fafc; }
        .td-name { font-weight: 600; color: #1e293b; }
        .td-email { color: #64748b; font-size: 0.8rem; }
        .td-uf { font-weight: 600; color: #1e3a5f; }
        .td-cargo { color: #475569; }
        .td-actions { display: flex; gap: 6px; }
        .btn-sm { padding: 4px 10px; font-size: 0.75rem; border-radius: 5px; }
        .btn-danger { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
        .btn-danger:hover { background: #fee2e2; }

        .pagination { display: flex; gap: 6px; justify-content: center; margin-top: 24px; }
        .pagination a, .pagination span { padding: 7px 12px; border-radius: 6px; font-size: 0.82rem; text-decoration: none; color: #475569; border: 1px solid #e2e8f0; }
        .pagination a:hover { background: #f1f5f9; }
        .pagination .active { background: #1e3a5f; color: #fff; border-color: #1e3a5f; }

        .modal-overlay { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.4); z-index: 200; justify-content: center; align-items: center; }
        .modal-overlay.open { display: flex; }
        .modal { background: #fff; border-radius: 12px; width: 480px; max-width: 95vw; max-height: 90vh; overflow-y: auto; }
        .modal-header { padding: 18px 22px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; }
        .modal-header h3 { font-size: 1rem; font-weight: 700; color: #1e293b; }
        .modal-close { background: none; border: none; font-size: 1.3rem; cursor: pointer; color: #94a3b8; }
        .modal-body { padding: 22px; }
        .form-group { margin-bottom: 14px; }
        .form-group label { display: block; font-size: 0.8rem; font-weight: 600; color: #475569; margin-bottom: 4px; }
        .form-group input, .form-group select { width: 100%; padding: 8px 12px; border: 1.5px solid #d1d5db; border-radius: 6px; font-size: 0.85rem; font-family: inherit; }
        .form-group input:focus, .form-group select:focus { border-color: #1e3a5f; outline: none; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .form-actions { display: flex; gap: 10px; justify-content: flex-end; margin-top: 18px; }
        .form-error { color: #dc2626; font-size: 0.75rem; margin-top: 3px; }
    </style>
</head>
<body>

    <header class="navbar">
        <div class="navbar-brand">
            <div class="logo">SPU<span>net</span></div>
            <div class="divider"></div>
            <div>
                <h1>Gestão de Servidores</h1>
                <span>CRUD de servidores</span>
            </div>
        </div>
        <div class="navbar-actions">
            <a href="{{ route('processos.index') }}">Painel</a>
            <a href="{{ route('equipe.index') }}">Equipes</a>
            <a href="{{ route('servidores.index') }}" class="active">Servidores</a>
            <a href="{{ route('configuracoes') }}">Configurações</a>
        </div>
    </header>

    <div class="container">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <div class="page-header">
            <h1>Servidores</h1>
            <button class="btn btn-primary" onclick="openModal('novo')">+ Novo Servidor</button>
        </div>

        <form method="GET" action="{{ route('servidores.index') }}" class="toolbar">
            <input type="text" name="busca" placeholder="Buscar por nome, e-mail ou CPF..." value="{{ $busca ?? '' }}">
            <select name="uf" onchange="this.form.submit()">
                <option value="">Todas UFs</option>
                @foreach($ufs as $u)
                    <option value="{{ $u }}" {{ ($uf ?? '') === $u ? 'selected' : '' }}>{{ $u }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-outline">Buscar</button>
        </form>

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>CPF</th>
                        <th>Cargo</th>
                        <th>UF</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($servidores as $s)
                        <tr>
                            <td class="td-name">{{ $s->name }}</td>
                            <td class="td-email">{{ $s->email }}</td>
                            <td>{{ $s->cpf ? substr($s->cpf,0,3).'.'.substr($s->cpf,3,3).'.'.substr($s->cpf,6,3).'-'.substr($s->cpf,9,2) : '—' }}</td>
                            <td class="td-cargo">{{ $s->cargo ?? '—' }}</td>
                            <td class="td-uf">{{ $s->uf ?? '—' }}</td>
                            <td class="td-actions">
                                <a href="{{ route('servidores.edit', $s) }}" class="btn btn-outline btn-sm">Editar</a>
                                <form method="POST" action="{{ route('servidores.destroy', $s) }}" onsubmit="return confirm('Remover este servidor?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center;color:#94a3b8;padding:24px;">Nenhum servidor encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination">
            {{ $servidores->links() }}
        </div>

    </div>

    {{-- ═══ Modal Novo Servidor ═══ --}}
    <div class="modal-overlay" id="modal-novo">
        <div class="modal">
            <div class="modal-header">
                <h3>Novo Servidor</h3>
                <button class="modal-close" onclick="closeModal('novo')">&times;</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('servidores.store') }}">
                    @csrf
                    <div class="form-group">
                        <label>Nome completo *</label>
                        <input type="text" name="name" required value="{{ old('name') }}">
                        @error('name') <div class="form-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label>E-mail institucional *</label>
                        <input type="email" name="email" required value="{{ old('email') }}">
                        @error('email') <div class="form-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>CPF *</label>
                            <input type="text" name="cpf" maxlength="11" required value="{{ old('cpf') }}" placeholder="Apenas números">
                            @error('cpf') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label>UF</label>
                            <select name="uf">
                                <option value="">Selecione...</option>
                                @foreach($ufs as $u)
                                    <option value="{{ $u }}" {{ old('uf') === $u ? 'selected' : '' }}>{{ $u }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Cargo</label>
                            <input type="text" name="cargo" value="{{ old('cargo') }}">
                        </div>
                        <div class="form-group">
                            <label>Telefone</label>
                            <input type="text" name="telefone" value="{{ old('telefone') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Senha *</label>
                        <input type="password" name="password" required>
                        @error('password') <div class="form-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label>Confirmar senha *</label>
                        <input type="password" name="password_confirmation" required>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn btn-outline" onclick="closeModal('novo')">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openModal(id) {
            document.getElementById('modal-' + id).classList.add('open');
        }
        function closeModal(id) {
            document.getElementById('modal-' + id).classList.remove('open');
        }
        document.querySelectorAll('.modal-overlay').forEach(function(el) {
            el.addEventListener('click', function(e) {
                if (e.target === el) el.classList.remove('open');
            });
        });
    </script>

</body>
</html>
