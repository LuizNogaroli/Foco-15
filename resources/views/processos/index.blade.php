<!DOCTYPE html>
<html lang="pt-BR">
<head>

    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPUnet - Módulo de Gestão</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}?v=20260722_1620">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        #dashboard-loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            z-index: 99999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: opacity 0.4s ease;
        }
        @keyframes dashboard-spin {
            to { transform: rotate(360deg); }
        }
        @keyframes pulse-destinacao {
            0% { box-shadow: 0 0 0 0 rgba(249, 115, 22, 0.6); transform: scale(1); }
            50% { box-shadow: 0 0 0 10px rgba(249, 115, 22, 0); transform: scale(1.05); }
            100% { box-shadow: 0 0 0 0 rgba(249, 115, 22, 0); transform: scale(1); }
        }
        .badge-encaminhar {
            background-color: rgba(249, 115, 22, 0.25); /* Laranja mais suave/transparente */
            color: #9a3412; /* Laranja escuro / Marrom para leitura clara */
            border: 1px solid rgba(249, 115, 22, 0.6);
            font-weight: 800;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 11px;
            display: inline-block;
            text-align: center;
            line-height: 1.3;
            animation: pulse-destinacao 1.5s infinite ease-in-out;
            letter-spacing: 0.3px;
        }
    </style>
</head>
<body>



    <!-- BARRA DE NAVEGAÇÃO -->
    <header class="navbar">
        <div class="navbar-brand">
            <span style="font-size: 20px; color: #1e3a5f; cursor: pointer;">☰</span>
            <!-- Logo SPUnet mockado ou texto estilizado -->
            <div style="display: flex; align-items: center; gap: 8px;">
                <span style="font-size: 20px; font-weight: 800; color: #1e3a5f; letter-spacing: -1px;">SPU<span style="color: #2e7d32;">net</span></span>
                <div style="width: 1.5px; height: 24px; background-color: #cbd5e1;"></div>
                <div class="navbar-title">
                    <h1>Módulo de Gestão</h1>
                    <span>Secretaria do Patrimônio da União</span>
                </div>
            </div>
        </div>

            <!-- Seletor de Perfil (apenas admin) -->
            @if(Auth::user()->hasRole('Direção'))
            <div class="profile-switcher-wrapper">
                <span class="profile-switcher-label">Simular Perfil:</span>
                <select id="profileSelector" onchange="changeProfile()">
                    <option value="ALL">Administrador (Todos)</option>
                    <option value="DESTINACAO">Técnico — Destinação</option>
                    <option value="CARACTERIZACAO">Técnico — Caracterização</option>
                    <option value="CHEFIA">Chefia SPU/UF</option>
                    <option value="COORDENACAO">Coordenação SPU/UF</option>
                    <option value="SUPERINTENDENCIA">Superintendência</option>
                    <option value="EQUIPE_CG">Equipe C.G.</option>
                    <option value="COORDENACAO_GERAL">Coordenação-Geral</option>
                    <option value="DIRETORIA">Direção</option>
                    <option value="CDE">CDE</option>
                </select>
            </div>
            @endif
            <!-- Toggle "Meus Processos" -->
            <div class="toggle-meus-processos-wrapper">
                <label class="toggle-switch" for="toggleMeusProcessos">
                    <input type="checkbox" id="toggleMeusProcessos" onchange="toggleMeusProcessos()">
                    <span class="toggle-slider"></span>
                </label>
                <span class="toggle-label">Meus Processos</span>
            </div>

        <!-- Ícones e Avatar agrupados na direita -->
        <div class="navbar-actions">
            <button class="nav-icon-btn" title="Montagem de Equipes" onclick="window.location.href='{{ route('equipe.index') }}'">👥</button>
            <button class="nav-icon-btn" title="Gestão de Servidores" onclick="window.location.href='{{ route('servidores.index') }}'">📋</button>
            <button class="nav-icon-btn" title="Configurações de Usuário" onclick="window.location.href='{{ route('configuracoes') }}'">⚙️</button>
            <button class="nav-icon-btn" title="Painel Gerencial" onclick="window.location.href='{{ route('dashboard') }}'">📊</button>
            <button class="nav-icon-btn" title="Histórico">📂</button>
            <button class="nav-icon-btn" title="Notificações">🔔</button>
            <div class="user-menu-wrapper" style="position: relative; margin-left: 10px;">
                <div class="user-avatar" title="{{ Auth::user()->name }}" onclick="toggleUserMenu()" style="cursor: pointer; user-select: none;">{{ substr(Auth::user()->name, 0, 1) }}</div>
                <div id="userDropdown" style="display: none; position: absolute; right: 0; top: 100%; margin-top: 10px; background: white; border: 1px solid var(--spu-border); border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); width: 180px; z-index: 1000; overflow: hidden;">
                    <div style="padding: 12px; border-bottom: 1px solid var(--spu-border); font-size: 13px; font-weight: 600; color: #1e3a5f; word-break: break-word;">
                        {{ Auth::user()->name }}
                    </div>
                    <form method="POST" action="{{ route('logout') }}" style="margin: 0; padding: 4px;">
                        @csrf
                        <button type="submit" style="width: 100%; text-align: left; padding: 10px 12px; background: none; border: none; cursor: pointer; color: #dc2626; font-size: 13.5px; font-weight: 600; border-radius: 4px; transition: background 0.2s;" onmouseover="this.style.background='#fee2e2'" onmouseout="this.style.background='none'">
                            Sair do Sistema
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- BREADCRUMBS -->
    <nav class="breadcrumbs">
        <span style="font-size: 14px;">🏠</span>
        <span>&rsaquo;</span>
        <a href="#">Instrução Processual</a>
        <span>&rsaquo;</span>
        <span style="color: #64748b; font-weight: 500;">Destinações</span>
    </nav>

    <main class="main-container">

        <!-- PAINEL DE FILTROS -->
        <section class="filters-card">
            @php
                $currentView = request('view', 'padrao');
                $activeFilters = [];
                if ($currentView === 'gerencial') {
                    $regioes = (array) request('regiao');
                    foreach ($regioes as $r) { if ($r) $activeFilters[] = ['key' => 'regiao', 'value' => $r]; }
                } else {
                    $ufs = (array) request('uf');
                    foreach ($ufs as $u) { if ($u) $activeFilters[] = ['key' => 'uf', 'value' => $u]; }
                }
                if (request('municipio')) $activeFilters[] = ['key' => 'municipio', 'value' => request('municipio')];
                $stlist = (array) request('status_atual');
                foreach ($stlist as $s) { if ($s) $activeFilters[] = ['key' => 'status_atual', 'value' => $s]; }
                $tipos = (array) request('tipo_requerimento');
                foreach ($tipos as $t) { if ($t) $activeFilters[] = ['key' => 'tipo_requerimento', 'value' => $t]; }
                if (request('interessado')) $activeFilters[] = ['key' => 'interessado', 'value' => request('interessado')];
                if (request('rip')) $activeFilters[] = ['key' => 'rip', 'value' => request('rip')];
            @endphp
            <div class="filters-header" onclick="toggleFilters()">
                <h2>
                    <span>▼</span> Filtros
                </h2>
                <div class="filter-view-selector" onclick="event.stopPropagation()">
                    <button type="button" class="filter-view-btn {{ $currentView === 'padrao' ? 'active' : '' }}" onclick="switchView('padrao')">Padrão</button>
                    <button type="button" class="filter-view-btn {{ $currentView === 'gerencial' ? 'active' : '' }}" onclick="switchView('gerencial')">Gerencial</button>
                </div>
                @if(!empty($activeFilters) || request('meus_processos'))
                <div class="filter-badges-row" onclick="event.stopPropagation()">
                    @if(request('meus_processos'))
                        <span class="filter-badge">
                            Meus Processos
                            <button class="filter-badge-x" onclick="toggleMeusProcessos()" title="Remover filtro">&times;</button>
                        </span>
                    @endif
                    @foreach($activeFilters as $f)
                        <span class="filter-badge">
                            {{ $f['value'] }}
                            <button class="filter-badge-x" onclick="removeFilterValue('{{ $f['key'] }}', '{{ $f['value'] }}')" title="Remover filtro">&times;</button>
                        </span>
                    @endforeach
                    <a href="{{ route('processos.index', ['view' => $currentView]) }}" class="filter-badge-clear">Limpar todos</a>
                </div>
                @endif
            </div>
            <form method="GET" action="{{ route('processos.index') }}" class="filters-body" id="filtersBody">
                <input type="hidden" name="view" value="{{ $currentView }}">

                <!-- VIEW PADRÃO -->
                <div class="filter-group view-padrao-only" style="{{ $currentView === 'padrao' ? '' : 'display:none;' }}">
                    <label>UF</label>
                    <div class="dropdown-check" id="ddUF">
                        <button type="button" class="dropdown-check-btn" onclick="toggleDropdown('ddUF')">
                            <span class="dropdown-check-label">Todas</span>
                            <span class="dropdown-check-arrow">▾</span>
                        </button>
                        <div class="dropdown-check-panel" style="max-height: 200px; overflow-y: auto;">
                            @foreach(['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'] as $ufOption)
                            <label class="dropdown-check-item">
                                <input type="checkbox" name="uf[]" value="{{ $ufOption }}" {{ in_array($ufOption, (array) request('uf')) ? 'checked' : '' }} onchange="syncDropdownLabel('ddUF')">
                                {{ $ufOption }}
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="filter-group view-padrao-only" style="{{ $currentView === 'padrao' ? '' : 'display:none;' }}">
                    <label for="filterMunicipio">Município</label>
                    <input type="text" name="municipio" id="filterMunicipio" value="{{ request('municipio') }}" placeholder="Ex: São Paulo" style="border: 1px solid #cbd5e1; border-radius: 4px;">
                </div>

                <!-- VIEW GERENCIAL -->
                <div class="filter-group view-gerencial-only" style="{{ $currentView === 'gerencial' ? '' : 'display:none;' }}">
                    <label>Região</label>
                    <div class="dropdown-check" id="ddRegiao">
                        <button type="button" class="dropdown-check-btn" onclick="toggleDropdown('ddRegiao')">
                            <span class="dropdown-check-label">Todas</span>
                            <span class="dropdown-check-arrow">▾</span>
                        </button>
                        <div class="dropdown-check-panel" style="max-height: 200px; overflow-y: auto;">
                            @foreach([
                                'Norte' => 'Norte (AC, AM, AP, PA, RO, RR, TO)',
                                'Nordeste' => 'Nordeste (AL, BA, CE, MA, PB, PE, PI, RN, SE)',
                                'Centro-Oeste' => 'Centro-Oeste (DF, GO, MS, MT)',
                                'Sudeste' => 'Sudeste (ES, MG, RJ, SP)',
                                'Sul' => 'Sul (PR, RS, SC)',
                            ] as $regKey => $regLabel)
                            <label class="dropdown-check-item">
                                <input type="checkbox" name="regiao[]" value="{{ $regKey }}" {{ in_array($regKey, (array) request('regiao')) ? 'checked' : '' }} onchange="syncDropdownLabel('ddRegiao')">
                                {{ $regLabel }}
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="filter-group view-gerencial-only" style="{{ $currentView === 'gerencial' ? '' : 'display:none;' }}">
                    <label for="filterMunicipioG">Município</label>
                    <input type="text" name="municipio" id="filterMunicipioG" value="{{ request('municipio') }}" placeholder="Ex: São Paulo" style="border: 1px solid #cbd5e1; border-radius: 4px;" disabled>
                </div>

                <!-- FILTROS COMUNS -->
                <div class="filter-group">
                    <label>Status</label>
                    <div class="dropdown-check" id="ddStatus">
                        <button type="button" class="dropdown-check-btn" onclick="toggleDropdown('ddStatus')">
                            <span class="dropdown-check-label">Todos</span>
                            <span class="dropdown-check-arrow">▼</span>
                        </button>
                        <div class="dropdown-check-panel" style="max-height: 200px; overflow-y: auto;">
                            @foreach($statuses as $st)
                            <label class="dropdown-check-item">
                                <input type="checkbox" name="status_atual[]" value="{{ $st }}" {{ in_array($st, (array) request('status_atual')) ? 'checked' : '' }} onchange="syncDropdownLabel('ddStatus')">
                                {{ $st }}
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="filter-group">
                    <label>Tipo de Requerimento</label>
                    <div class="dropdown-check" id="ddTipo">
                        <button type="button" class="dropdown-check-btn" onclick="toggleDropdown('ddTipo')">
                            <span class="dropdown-check-label">Todos</span>
                            <span class="dropdown-check-arrow">▼</span>
                        </button>
                        <div class="dropdown-check-panel" style="max-height: 200px; overflow-y: auto;">
                            @foreach([
                                'Alterar Regime ou Contrato de Utilização de Imóvel da União',
                                'Autorização de passagem em imóveis da União',
                                'Entrega para Aquicultura',
                                'Obter Autorização de Obras em Imóvel da União',
                                'Obter Cessão de Uso de Espaço Físico em Águas Públicas',
                                'Obter Permissão de Uso para Eventos em Imóvel da União',
                                'Regularizar Utilização de Imóvel da União',
                                'Obter a Gestão Municipal de Praias Marítimas',
                                'Solicitar imóvel para uso da Administração Pública e Entidades sem Fins Lucrativos',
                                'Adquirir Imóvel Aforado da União por Remição',
                            ] as $tipoOption)
                            <label class="dropdown-check-item">
                                <input type="checkbox" name="tipo_requerimento[]" value="{{ $tipoOption }}" {{ in_array($tipoOption, (array) request('tipo_requerimento')) ? 'checked' : '' }} onchange="syncDropdownLabel('ddTipo')">
                                {{ $tipoOption }}
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="filter-group">
                    <label for="filterInteressado">Interessado</label>
                    <input type="text" name="interessado" id="filterInteressado" value="{{ request('interessado') }}" placeholder="Nome do requerente" style="border: 1px solid #cbd5e1; border-radius: 4px;">
                </div>
                
                <!-- 6º SLOT: RIP + BOTÕES -->
                <div class="filter-group" style="display: flex; flex-direction: row; gap: 10px; align-items: flex-end;">
                    <div style="flex: 1; display: flex; flex-direction: column; gap: 6px;">
                        <label for="filterRip">RIP</label>
                        <input type="text" name="rip" id="filterRip" value="{{ request('rip') }}" placeholder="Nº do RIP" style="border: 1px solid #cbd5e1; border-radius: 4px;">
                    </div>
                    <button type="submit" style="height: 38px; padding: 0 20px; background-color: #2e7d32; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">Aplicar</button>
                    <a href="{{ route('processos.index', ['view' => $currentView]) }}" style="height: 38px; display: flex; align-items: center; justify-content: center; padding: 0 20px; background-color: #ef4444; color: white; border-radius: 4px; text-decoration: none; font-weight: bold; transition: background-color 0.2s;">Limpar</a>
                </div>
            </form>
        </section>




        <!-- TABELA DE PROCESSOS -->
        <div class="table-container" style="overflow-x: auto;">
            <table class="data-table" id="processesTable">
                <thead>
                    <tr>
                        <th style="width: 50px;">UF</th>
                        <th style="width: 110px;">Nº Req. / Data</th>
                        <th style="width: 140px;">Município</th>
                        <th style="width: 200px;">Interessado</th>
                        <th style="width: 220px;">Tipo de Requerimento</th>
                        <th style="width: 160px;">Atribuído para</th>
                        <th style="width: 160px;">Tramitação</th>
                        <th style="width: 200px;">Status</th>
                        <th style="width: 60px; text-align: center;">Ação</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @forelse($processos as $proc)
                    <tr>
                        <td>{{ $proc->uf ?? '-' }}</td>
                        <td>
                            <div style="font-weight: 600;">{{ $proc->numero_requerimento }}</div>
                            <div style="font-size: 12.5px; color: #64748b; margin-top: 3px;">{{ $proc->created_at->format('d/m/Y') }}</div>
                        </td>
                        <td>-</td>
                        <td>
                            <div>{{ $proc->requerimento->nome_requerente ?? '-' }}</div>
                        </td>
                        <td>{{ $proc->tipo_requerimento }}</td>
                        <td>
                            <span style="font-size: 13px; color: #64748b;">Não atribuído</span>
                        </td>
                        <td>
                            @if($proc->tramitacao == 'Devolvido')
                                <span class="badge" style="background-color: #fecdd3; color: #be123c; border: 1px solid #fda4af; width: 100px; min-height: 30px; padding: 4px 8px; font-size: 13px; text-align: center; display: inline-block;">Devolvido</span>
                            @else
                                <span class="badge badge-normal" style="width: 100px; min-height: 30px; padding: 4px 8px; font-size: 13px;">Normal</span>
                            @endif
                        </td>
                        <td>
                            @if($proc->status_atual == 'Aprovado')
                                <span class="badge badge-confirmada">{{ $proc->status_atual }}</span>
                            @elseif($proc->status_atual == 'Devolvido')
                                <span class="badge badge-devolvido">{{ $proc->status_atual }}</span>
                            @else
                                <span class="badge badge-analise">{{ $proc->status_atual }}</span>
                            @endif
                        </td>
                        <td class="table-actions" style="vertical-align: middle;">
                            <div style="display: flex; justify-content: center; align-items: center; gap: 12px;">
                                @if(in_array($proc->status_atual, $statusesPerfil))
                                <form method="POST" action="{{ route('processos.abrir', $proc->id) }}" style="display:inline; margin:0; padding:0;">
                                    @csrf
                                    <button type="submit" class="btn-action" title="Editar / Analisar Processo" style="background: none; border: none; cursor: pointer; padding: 4px; display: flex; align-items: center;">
                                        <img src="{{ asset('images/icon-edit.svg') }}" width="24" height="24" alt="Editar">
                                    </button>
                                </form>
                                @else
                                    <span style="display: inline-block; width: 32px; text-align: center; color: #cbd5e1;" title="Ação indisponível neste status">─</span>
                                @endif
                                <a href="{{ route('processos.historico', $proc->id) }}" class="btn-action" title="Visualizar Processo / Histórico" style="display: flex; align-items: center; padding: 4px; border: none; outline: none; text-decoration: none;">
                                    <img src="{{ asset('images/icon-eye.svg') }}" width="24" height="24" alt="Visualizar">
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="empty-state">Nenhum processo encontrado no banco de dados.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div style="margin-top: 20px;">
            {{ $processos->links() }}
        </div>

    </main>

    <!-- MODAL: Acesso Negado -->
    @if(session('erro_acesso'))
    <div id="modalAcessoNegado" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:99999; align-items:center; justify-content:center;">
        <div style="background:#fff; border-radius:12px; padding:32px 40px; max-width:420px; width:90%; box-shadow:0 20px 60px rgba(0,0,0,0.3); text-align:center;">
            <div style="font-size:48px; margin-bottom:12px;">🔒</div>
            <h2 style="margin:0 0 8px; font-size:18px; color:#1e293b;">Acesso Restrito</h2>
            <p style="margin:0 0 24px; font-size:14px; color:#64748b; line-height:1.5;">{{ session('erro_acesso') }}</p>
            <button onclick="document.getElementById('modalAcessoNegado').style.display='none'" style="background:#1e3a5f; color:#fff; border:none; padding:10px 32px; border-radius:8px; font-size:14px; font-weight:600; cursor:pointer;">Entendido</button>
        </div>
    </div>
    <script>document.getElementById('modalAcessoNegado').style.display='flex';</script>
    @endif

    <script>
        function toggleFilters() {
            const body = document.getElementById('filtersBody');
            body.style.display = body.style.display === 'none' ? 'grid' : 'none';
        }

        function changeProfile() {
            const sel = document.getElementById('profileSelector');
            document.cookie = 'perfil_simulado=' + sel.value + ';path=/;max-age=86400';
            location.reload();
        }

        function toggleMeusProcessos() {
            const params = new URLSearchParams(window.location.search);
            const cb = document.getElementById('toggleMeusProcessos');
            if (cb.checked) {
                params.set('meus_processos', '1');
            } else {
                params.delete('meus_processos');
            }
            window.location.search = params.toString();
        }

        function toggleDropdown(id) {
            const dd = document.getElementById(id);
            const panel = dd.querySelector('.dropdown-check-panel');
            const isOpen = panel.classList.contains('open');
            document.querySelectorAll('.dropdown-check-panel.open').forEach(p => p.classList.remove('open'));
            if (!isOpen) panel.classList.add('open');
        }

        function syncDropdownLabel(id) {
            const dd = document.getElementById(id);
            const checks = dd.querySelectorAll('input[type="checkbox"]:checked');
            const label = dd.querySelector('.dropdown-check-label');
            const allChecks = dd.querySelectorAll('input[type="checkbox"]');
            if (checks.length === 0) {
                label.textContent = label.dataset.defaultText;
            } else if (checks.length === allChecks.length) {
                label.textContent = 'Todos';
            } else if (checks.length <= 2) {
                label.textContent = Array.from(checks).map(c => c.value).join(', ');
            } else {
                label.textContent = checks.length + ' selecionados';
            }
        }

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.dropdown-check')) {
                document.querySelectorAll('.dropdown-check-panel.open').forEach(p => p.classList.remove('open'));
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.dropdown-check').forEach(dd => {
                const label = dd.querySelector('.dropdown-check-label');
                label.dataset.defaultText = label.textContent;
                syncDropdownLabel(dd.id);
            });
        });

        function removeFilter(key) {
            const params = new URLSearchParams(window.location.search);
            params.delete(key);
            window.location.search = params.toString();
        }

        function removeFilterValue(key, value) {
            const params = new URLSearchParams(window.location.search);
            const all = params.getAll(key);
            params.delete(key);
            all.filter(v => v !== value).forEach(v => params.append(key, v));
            window.location.search = params.toString();
        }

        function switchView(view) {
            const params = new URLSearchParams(window.location.search);
            params.set('view', view);
            window.location.search = params.toString();
        }

        function toggleUserMenu() {
            const menu = document.getElementById('userDropdown');
            menu.style.display = menu.style.display === 'none' || menu.style.display === '' ? 'block' : 'none';
        }

        document.addEventListener('click', function(e) {
            const wrapper = document.querySelector('.user-menu-wrapper');
            if (wrapper && !wrapper.contains(e.target)) {
                const menu = document.getElementById('userDropdown');
                if(menu) menu.style.display = 'none';
            }
        });

        (function() {
            const params = new URLSearchParams(window.location.search);
            const match = document.cookie.match(/(?:^|;\s*)perfil_simulado=([^;]+)/);
            if (match) {
                document.getElementById('profileSelector').value = match[1];
            }
            if (params.get('meus_processos') === '1') {
                document.getElementById('toggleMeusProcessos').checked = true;
            }
        })();
    </script>
</body>
</html>
