<!DOCTYPE html>
<html lang="pt-BR">
<head>

    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Configurações - SPUnet</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/configuracoes.css') }}">
    
    <!-- SDK do Supabase e Banco de Dados -->
    <script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2"></script>
    <script src="{{ asset('js/workflow.js') }}"></script>
    <script src="{{ asset('js/db.js') }}"></script>
</head>
<body>
    <header class="navbar">
        <div class="navbar-brand">
            <button class="nav-icon-btn" title="Voltar ao Painel" onclick="window.location.href='index.html'" style="margin-right: 15px;">⬅️</button>
            <div style="display: flex; align-items: center; gap: 8px;">
                <span style="font-size: 20px; font-weight: 800; color: #1e3a5f; letter-spacing: -1px;">SPU<span style="color: #2e7d32;">net</span></span>
                <div style="width: 1.5px; height: 24px; background-color: #cbd5e1;"></div>
                <div class="navbar-title">
                    <h1>Configurações do Sistema</h1>
                    <span>Gestão de Acessos e Perfis</span>
                </div>
            </div>
        </div>
        <div class="navbar-actions">
            <button class="nav-icon-btn" title="Painel Gerencial" onclick="window.location.href='painel-gerencial.html'">📊</button>
            <div class="user-avatar" title="Usuário Administrador">A</div>
        </div>
    </header>

    <main class="config-container">
        
        <!-- SIDEBAR -->
        <aside class="sidebar">
            @if(isset($isAdmin) && $isAdmin)
            <h3 class="sidebar-title">Menu Principal</h3>
            <ul class="uf-list" style="margin-bottom: 25px; border-bottom: 1px solid #e2e8f0; padding-bottom: 15px;">
                <li class="uf-item active" id="menuTabGestao" onclick="toggleConfigTab('gestao')">👥 Gestão de Equipe</li>
                <li class="uf-item" id="menuTabStatus" onclick="toggleConfigTab('status')">⚙️ Administrar Status</li>
            </ul>
            @endif

            <div id="sidebarEquipes">
                <h3 class="sidebar-title">Selecione a UF</h3>
                <ul class="uf-list" id="ufList">
                    <!-- Populado via JS -->
                </ul>
            </div>
        </aside>

        <!-- MAIN PANEL -->
        <section class="content-panel">
            <div id="panelGestao">
            <div class="panel-header">
                <h2>Gestão de Equipe: <span id="currentUfLabel" style="color: #1e3a5f;">Selecione uma UF</span></h2>
                <p>Aloque os servidores nas suas respectivas hierarquias para a Superintendência atual.</p>
            </div>

            <div class="allocation-grid" id="allocationGrid" style="display: none;">
                
                <!-- COLUMN 1: SELECT SERVER -->
                <div class="card">
                    <h3>1. Selecione o Servidor</h3>
                    <div class="search-box">
                        <input type="text" id="searchServer" placeholder="Buscar Servidor..." oninput="filterServers()">
                    </div>
                    <ul class="server-list" id="serverList">
                        @forelse($users as $user)
                            <li class="server-item" data-uf="{{ $user->uf }}">
                                <div style="display:flex; align-items:center; gap:10px;">
                                    <div style="width:32px; height:32px; background:#1e3a5f; color:white; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:bold;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight:600;">{{ $user->name }}</div>
                                        <div style="font-size:12px; color:#64748b;">{{ $user->email }}</div>
                                    </div>
                                </div>
                                <div>
                                    @foreach($user->roles as $role)
                                        <span style="font-size:11px; background:#e2e8f0; padding:2px 6px; border-radius:4px;">{{ $role->name }}</span>
                                    @endforeach
                                </div>
                            </li>
                        @empty
                            <li class="server-item">Nenhum usuário cadastrado.</li>
                        @endforelse
                    </ul>
                </div>

                <!-- COLUMN 2: SELECT PROFILE & ASSIGN -->
                <div class="card">
                    <h3>2. Atribuir Perfil</h3>
                    <div class="profile-options" id="profileOptions">
                        <label class="radio-label">
                            <input type="radio" name="profile" value="Equipe SPU/UF" checked>
                            <span class="radio-text">Equipe SPU/UF</span>
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="profile" value="Chefia SPU/UF">
                            <span class="radio-text">Chefia SPU/UF</span>
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="profile" value="Coordenação SPU/UF">
                            <span class="radio-text">Coordenação SPU/UF</span>
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="profile" value="Superintendência">
                            <span class="radio-text">Superintendência</span>
                        </label>
                    </div>

                    <!-- TOGGLE PERMISSÃO DE DISTRIBUIÇÃO -->
                    <div class="toggle-wrapper">
                        <div class="toggle-text">
                            Permitir distribuição
                            <small>Este usuário poderá distribuir processos no painel principal</small>
                        </div>
                        <label class="switch">
                            <input type="checkbox" id="chkDistribute">
                            <span class="slider"></span>
                        </label>
                    </div>

                    <button class="btn-primary" onclick="assignProfile()" id="btnAssign" disabled>
                        Adicionar Servidor ao Perfil
                    </button>
                </div>

            </div>

            <!-- RESULT TABLE -->
            <div class="card mt-20" id="assignmentsCard" style="display: none;">
                <h3>Quadro de Lotação - <span id="tableUfLabel"></span></h3>
                <table class="assignments-table">
                    <thead>
                        <tr>
                            <th>Servidor</th>
                            <th>Perfil Alocado</th>
                            <th style="width: 80px; text-align: center;">Ações</th>
                        </tr>
                    </thead>
                    <tbody id="assignmentsTableBody">
                        <tr><td colspan="3" class="empty-state">Nenhum servidor alocado nesta UF.</td></tr>
                    </tbody>
                </table>
            </div>

            <!-- SAVE BUTTON -->
            <div style="text-align: right; margin-top: 20px;" id="saveSection" style="display: none;">
                <button class="btn-primary" style="background-color: #1e3a5f; width: auto; padding: 14px 40px; font-size: 15px;" onclick="salvarAlteracoes()" id="btnSaveFinal">
                    💾 Salvar Todas as Configurações
                </button>
            </div>

            </div><!-- end panelGestao -->

            <!-- NOVO PAINEL DE STATUS -->
            <div id="panelStatus" style="display: none;">
                <div class="panel-header">
                    <h2>Administrar Status</h2>
                    <p>Altere o status de um requerimento específico.</p>
                </div>
                <div class="card">
                    <div class="search-box" style="margin-bottom: 20px;">
                        <input type="text" id="inputProcessId" placeholder="Digite o ID do Requerimento" style="width: 300px; padding: 10px; border-radius: 6px; border: 1px solid #cbd5e1; margin-right: 10px;">
                        <button class="btn-primary" onclick="buscarStatusRequerimento()" style="padding: 10px 20px;">Buscar Status</button>
                    </div>
                    <div id="statusResult" style="display: none;">
                        <div style="background: #f8fafc; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #1e3a5f;">
                            <strong>Status Atual:</strong> <span id="currentStatusText" style="color: #1e3a5f; margin-left: 5px;"></span>
                        </div>
                        <h3 style="margin-bottom: 10px; font-size: 14px; color: #475569;">Alterar para:</h3>
                        <select id="selectNewStatus" style="width: 100%; max-width: 400px; padding: 10px; border-radius: 6px; border: 1px solid #cbd5e1; margin-bottom: 20px;">
                            <!-- Preenchido via JS -->
                        </select>
                        <div>
                            <button class="btn-primary" onclick="salvarNovoStatus()" style="background-color: #059669;">Salvar Novo Status</button>
                        </div>
                    </div>
                </div>
            </div><!-- end panelStatus -->
        </section>
    </main>

    <script src="{{ asset('js/configuracoes.js') }}"></script>
</body>
</html>
