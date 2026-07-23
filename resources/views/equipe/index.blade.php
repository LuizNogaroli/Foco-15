<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPUnet - Montagem de Equipes</title>
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

        .container { max-width: 1200px; margin: 30px auto; padding: 0 20px; }

        .page-header { margin-bottom: 28px; }
        .page-header h1 { font-size: 1.5rem; font-weight: 700; color: #1e293b; }

        /* ═══ Regiões ═══ */
        .regioes-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 14px; margin-bottom: 30px; }

        .regiao-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; overflow: hidden; }
        .regiao-header { padding: 12px 16px; background: #1e3a5f; color: #fff; font-size: 0.82rem; font-weight: 700; letter-spacing: 0.3px; text-transform: uppercase; }
        .regiao-body { padding: 10px; display: flex; flex-wrap: wrap; gap: 6px; }

        .uf-badge { display: inline-flex; align-items: center; justify-content: center; padding: 7px 12px; border-radius: 6px; font-size: 0.8rem; font-weight: 600; text-decoration: none; transition: all 0.15s; border: 1.5px solid #e2e8f0; color: #475569; background: #f8fafc; }
        .uf-badge:hover { border-color: #1e3a5f; color: #1e3a5f; background: #eff6ff; }
        .uf-badge.active { background: #1e3a5f; color: #fff; border-color: #1e3a5f; box-shadow: 0 2px 6px rgba(30,58,95,0.25); }

        /* ═══ Equipe da UF selecionada ═══ */
        .equipe-title { font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 18px; padding-bottom: 10px; border-bottom: 2px solid #e2e8f0; }
        .equipe-title span { color: #1e3a5f; }

        .perfil-section { background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; margin-bottom: 14px; overflow: hidden; }
        .perfil-header { padding: 12px 18px; background: #f8fafc; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; }
        .perfil-header h3 { font-size: 0.9rem; font-weight: 600; color: #1e3a5f; }
        .perfil-header .badge { font-size: 0.72rem; background: #dbeafe; color: #1e3a5f; padding: 3px 10px; border-radius: 999px; font-weight: 600; }

        .servidor-list { padding: 10px 18px; }
        .servidor-item { display: flex; justify-content: space-between; align-items: center; padding: 9px 0; border-bottom: 1px solid #f1f5f9; }
        .servidor-item:last-child { border-bottom: none; }
        .servidor-info { display: flex; align-items: center; gap: 10px; }
        .servidor-avatar { width: 32px; height: 32px; border-radius: 50%; background: #1e3a5f; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.75rem; }
        .servidor-name { font-weight: 600; color: #1e293b; font-size: 0.85rem; }
        .servidor-email { font-size: 0.75rem; color: #94a3b8; }
        .btn-remove { background: none; border: 1px solid #fecaca; color: #dc2626; padding: 4px 10px; border-radius: 5px; cursor: pointer; font-size: 0.75rem; font-weight: 500; transition: all 0.2s; }
        .btn-remove:hover { background: #fef2f2; border-color: #dc2626; }

        .add-form { padding: 10px 18px; background: #f8fafc; border-top: 1px solid #e2e8f0; }
        .add-form form { display: flex; gap: 8px; align-items: center; }
        .add-form select { padding: 7px 10px; border: 1.5px solid #d1d5db; border-radius: 6px; font-size: 0.82rem; font-family: inherit; flex: 1; }
        .add-form select:focus { border-color: #1e3a5f; outline: none; }
        .btn-add { background: #1e3a5f; color: #fff; border: none; padding: 7px 16px; border-radius: 6px; cursor: pointer; font-size: 0.82rem; font-weight: 600; transition: background 0.2s; white-space: nowrap; }
        .btn-add:hover { background: #17375a; }

        .empty-state { padding: 16px; text-align: center; color: #94a3b8; font-size: 0.82rem; }

        .modal-overlay { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.4); z-index: 200; justify-content: center; align-items: center; }
        .modal-overlay.open { display: flex; }
        .modal { background: #fff; border-radius: 12px; width: 520px; max-width: 95vw; }
        .modal-header { padding: 18px 22px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; }
        .modal-header h3 { font-size: 1rem; font-weight: 700; color: #1e293b; }
        .modal-close { background: none; border: none; font-size: 1.3rem; cursor: pointer; color: #94a3b8; }
        .modal-body { padding: 22px; }
        .modal-body p { font-size: 0.82rem; color: #64748b; margin-bottom: 14px; line-height: 1.5; }
        .modal-body code { background: #f1f5f9; padding: 2px 6px; border-radius: 4px; font-size: 0.78rem; }
        .file-upload { border: 2px dashed #d1d5db; border-radius: 8px; padding: 24px; text-align: center; cursor: pointer; transition: all 0.2s; }
        .file-upload:hover { border-color: #1e3a5f; background: #f8fafc; }
        .file-upload input { display: none; }
        .file-upload .label { font-size: 0.85rem; color: #475569; font-weight: 500; }
        .file-upload .hint { font-size: 0.75rem; color: #94a3b8; margin-top: 6px; }
        .form-actions { display: flex; gap: 10px; justify-content: flex-end; margin-top: 18px; }
        .btn { padding: 8px 16px; border-radius: 6px; border: none; cursor: pointer; font-size: 0.85rem; font-weight: 600; transition: all 0.2s; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
        .btn-primary { background: #1e3a5f; color: #fff; }
        .btn-primary:hover { background: #17375a; }
        .btn-outline { background: #fff; color: #475569; border: 1.5px solid #d1d5db; }
        .btn-outline:hover { background: #f8fafc; }

        .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 0.85rem; font-weight: 500; }
        .alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .alert-error { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }

        @media (max-width: 900px) {
            .regioes-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 550px) {
            .regioes-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <header class="navbar">
        <div class="navbar-brand">
            <div class="logo">SPU<span>net</span></div>
            <div class="divider"></div>
            <div>
                <h1>Montagem de Equipes</h1>
                <span>Configuração por UF</span>
            </div>
        </div>
        <div class="navbar-actions">
            <a href="{{ route('processos.index') }}">Painel</a>
            <a href="{{ route('equipe.index') }}" class="active">Equipes</a>
            <a href="{{ route('servidores.index') }}">Servidores</a>
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
            <h1>Montagem de Equipes</h1>
            <div style="display:flex;gap:10px;">
                <button class="btn-add" onclick="openModal('importar')" style="font-size:0.85rem;padding:8px 16px;">Importar CSV/XLSX</button>
                <a href="{{ route('servidores.index') }}" class="btn-add" style="text-decoration:none;font-size:0.85rem;padding:8px 16px;">Gestão de Servidores</a>
            </div>
        </div>

        {{-- ═══ Grid de Regiões ═══ --}}
        <div class="regioes-grid">
            @php
                $regioes = [
                    'Norte'       => ['AC','AM','AP','PA','RO','RR','TO'],
                    'Nordeste'    => ['AL','BA','CE','MA','PB','PE','PI','RN','SE'],
                    'Centro-Oeste'=> ['DF','GO','MS','MT'],
                    'Sudeste'     => ['ES','MG','RJ','SP'],
                    'Sul'         => ['PR','RS','SC'],
                ];
            @endphp

            @foreach($regioes as $regiao => $ufs)
                <div class="regiao-card">
                    <div class="regiao-header">{{ $regiao }}</div>
                    <div class="regiao-body">
                        @foreach($ufs as $ufOption)
                            <a href="{{ route('equipe.index', ['uf' => $ufOption]) }}"
                               class="uf-badge {{ $uf === $ufOption ? 'active' : '' }}">
                                {{ $ufOption }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        {{-- ═══ Equipe da UF selecionada ═══ --}}
        <div class="equipe-title">Equipe — <span>SPU/{{ $uf }}</span></div>

        @php
            $perfisPorUf = [
                'Equipe Destinação' => 'vários',
                'Equipe Caracterização' => 'vários',
                'Chefia' => '1',
                'Coordenação' => '1',
                'Superintendência' => '1',
                'Equipe C.G.' => 'vários',
                'Coordenação-Geral' => '1',
                'Direção' => '1',
                'CDE' => 'vários',
            ];
        @endphp

        @foreach($perfisPorUf as $perfil => $limite)
            @php
                $servidoresPerfil = $equipe->get($perfil, collect());
            @endphp
            <div class="perfil-section">
                <div class="perfil-header">
                    <h3>{{ $perfil }}</h3>
                    <span class="badge">{{ $servidoresPerfil->count() }}/{{ $limite === '1' ? '1' : '∞' }}</span>
                </div>

                <div class="servidor-list">
                    @forelse($servidoresPerfil as $eq)
                        <div class="servidor-item">
                            <div class="servidor-info">
                                <div class="servidor-avatar">{{ substr($eq->user->name, 0, 1) }}</div>
                                <div>
                                    <div class="servidor-name">{{ $eq->user->name }}</div>
                                    <div class="servidor-email">{{ $eq->user->email }}</div>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('equipe.destroy', $eq->id) }}" onsubmit="return confirm('Remover este servidor da equipe?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-remove">Remover</button>
                            </form>
                        </div>
                    @empty
                        <div class="empty-state">Nenhum servidor atribuído.</div>
                    @endforelse
                </div>

                <div class="add-form">
                    <form method="POST" action="{{ route('equipe.store') }}">
                        @csrf
                        <input type="hidden" name="perfil" value="{{ $perfil }}">
                        <input type="hidden" name="uf" value="{{ $uf }}">
                        <select name="user_id" required>
                            <option value="">Adicionar servidor...</option>
                            @foreach($servidores as $s)
                                @if(!$servidoresPerfil->contains('user_id', $s->id))
                                    <option value="{{ $s->id }}">{{ $s->name }} ({{ $s->email }})</option>
                                @endif
                            @endforeach
                        </select>
                        <button type="submit" class="btn-add">+ Adicionar</button>
                    </form>
                </div>
            </div>
        @endforeach

    </div>

    {{-- ═══ Modal Importar ═══ --}}
    <div class="modal-overlay" id="modal-importar">
        <div class="modal">
            <div class="modal-header">
                <h3>Importar Servidores</h3>
                <button class="modal-close" onclick="closeModal('importar')">&times;</button>
            </div>
            <div class="modal-body">
                <p>
                    O arquivo deve conter as colunas (cabeçalho obrigatório):<br>
                    <code>Nome</code>, <code>CPF</code>, <code>Cargo</code>,
                    <code>Email_Institucional</code>, <code>Telefone_de_Contato</code>,
                    <code>Superintendencia_UF</code>
                </p>
                <p>Formatos aceitos: <strong>.csv</strong> e <strong>.xlsx</strong>. CPFs duplicados serão atualizados. Senha padrão: <code>password</code>.</p>

                <form method="POST" action="{{ route('equipe.importar') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="file-upload" onclick="this.querySelector('input').click()">
                        <input type="file" name="arquivo" accept=".csv,.xlsx,.xls" required onchange="updateFileName(this)">
                        <div class="label" id="file-label">Clique para selecionar o arquivo</div>
                        <div class="hint">CSV ou XLSX (máx. 5MB)</div>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn btn-outline" onclick="closeModal('importar')">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Importar</button>
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
        function updateFileName(input) {
            var label = document.getElementById('file-label');
            label.textContent = input.files.length ? input.files[0].name : 'Clique para selecionar o arquivo';
        }
    </script>

</body>
</html>
