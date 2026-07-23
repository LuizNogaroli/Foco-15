<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPUnet - Editar Servidor</title>
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

        .container { max-width: 700px; margin: 30px auto; padding: 0 20px; }

        .page-header { margin-bottom: 24px; }
        .page-header h1 { font-size: 1.5rem; font-weight: 700; color: #1e293b; }
        .page-header .subtitle { font-size: 0.85rem; color: #64748b; margin-top: 4px; }

        .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 0.85rem; font-weight: 500; }
        .alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .alert-error { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }

        .card { background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 22px; }

        .form-group { margin-bottom: 14px; }
        .form-group label { display: block; font-size: 0.8rem; font-weight: 600; color: #475569; margin-bottom: 4px; }
        .form-group input, .form-group select { width: 100%; padding: 8px 12px; border: 1.5px solid #d1d5db; border-radius: 6px; font-size: 0.85rem; font-family: inherit; }
        .form-group input:focus, .form-group select:focus { border-color: #1e3a5f; outline: none; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .form-actions { display: flex; gap: 10px; justify-content: flex-end; margin-top: 18px; }
        .form-error { color: #dc2626; font-size: 0.75rem; margin-top: 3px; }
        .form-hint { color: #94a3b8; font-size: 0.75rem; margin-top: 3px; }

        .btn { padding: 8px 16px; border-radius: 6px; border: none; cursor: pointer; font-size: 0.85rem; font-weight: 600; transition: all 0.2s; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
        .btn-primary { background: #1e3a5f; color: #fff; }
        .btn-primary:hover { background: #17375a; }
        .btn-outline { background: #fff; color: #475569; border: 1.5px solid #d1d5db; }
        .btn-outline:hover { background: #f8fafc; border-color: #94a3b8; }

        .section-title { font-size: 0.9rem; font-weight: 700; color: #1e293b; margin: 22px 0 12px; padding-top: 16px; border-top: 1px solid #e2e8f0; }

        .equipe-badge { display: inline-flex; align-items: center; gap: 6px; padding: 5px 12px; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 6px; font-size: 0.8rem; font-weight: 500; color: #1e40af; margin: 0 6px 6px 0; }
        .equipe-badge .uf { font-weight: 700; }
        .empty-equipe { color: #94a3b8; font-size: 0.82rem; font-style: italic; }
    </style>
</head>
<body>

    <header class="navbar">
        <div class="navbar-brand">
            <div class="logo">SPU<span>net</span></div>
            <div class="divider"></div>
            <div>
                <h1>Gestão de Servidores</h1>
                <span>Edição de servidor</span>
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
            <h1>Editar Servidor</h1>
            <div class="subtitle">{{ $user->name }} — {{ $user->email }}</div>
        </div>

        <div class="card">
            <form method="POST" action="{{ route('servidores.update', $user) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Nome completo *</label>
                    <input type="text" name="name" required value="{{ old('name', $user->name) }}">
                    @error('name') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label>E-mail institucional *</label>
                    <input type="email" name="email" required value="{{ old('email', $user->email) }}">
                    @error('email') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>CPF *</label>
                        <input type="text" name="cpf" maxlength="11" required value="{{ old('cpf', $user->cpf) }}" placeholder="Apenas números">
                        @error('cpf') <div class="form-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label>UF</label>
                        <select name="uf">
                            <option value="">Selecione...</option>
                            @foreach($ufs as $u)
                                <option value="{{ $u }}" {{ old('uf', $user->uf) === $u ? 'selected' : '' }}>{{ $u }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Cargo</label>
                        <input type="text" name="cargo" value="{{ old('cargo', $user->cargo) }}">
                    </div>
                    <div class="form-group">
                        <label>Telefone</label>
                        <input type="text" name="telefone" value="{{ old('telefone', $user->telefone) }}">
                    </div>
                </div>

                <div class="form-group">
                    <label>Nova senha (deixe vazio para manter)</label>
                    <input type="password" name="password">
                    @error('password') <div class="form-error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label>Confirmar nova senha</label>
                    <input type="password" name="password_confirmation">
                </div>

                <div class="form-actions">
                    <a href="{{ route('servidores.index') }}" class="btn btn-outline">Voltar</a>
                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                </div>
            </form>
        </div>

        @if($equipes->count() > 0)
            <div class="section-title">Equipes vinculadas</div>
            <div>
                @foreach($equipes as $eq)
                    <span class="equipe-badge">
                        <span class="uf">SPU/{{ $eq->uf }}</span> — {{ $eq->perfil }}
                    </span>
                @endforeach
            </div>
        @endif

    </div>

</body>
</html>
