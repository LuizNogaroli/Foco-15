// configuracoes.js

// Dados simulados (Mock)
const UFS = [
    "AC", "AL", "AM", "AP", "BA", "CE", "DF", "ES", "GO", "MA", "MG", "MS", "MT", 
    "PA", "PB", "PE", "PI", "PR", "RJ", "RN", "RO", "RR", "RS", "SC", "SE", "SP", "TO"
];

// Gera servidores dinamicamente por UF
let currentMockServers = [];

// Estado da aplicação
let currentUf = null;
let selectedServer = null;

// Estrutura de dados para armazenar as alocações: { "RJ": [ { server: "RJ-Servidor A", profile: "Chefia SPU/UF" } ] }
let assignments = {}; 

document.addEventListener('DOMContentLoaded', async () => {
    // Aguarda o carregamento do cliente supabase do db.js
    let retries = 0;
    while (!window.supabaseClient && retries < 15) {
        await new Promise(r => setTimeout(r, 200));
        retries++;
    }

    // Carrega dados do Supabase
    if (window.loadConfigRoles) {
        assignments = await window.loadConfigRoles();
    }

    // Inicializa lista de UFs
    const ufList = document.getElementById('ufList');
    UFS.forEach(uf => {
        const li = document.createElement('li');
        li.textContent = `SPU / ${uf}`;
        li.dataset.uf = uf;
        li.onclick = () => selectUf(uf, li);
        ufList.appendChild(li);
    });
});

function selectUf(uf, liElement) {
    // Update UI
    document.querySelectorAll('.uf-list li').forEach(el => el.classList.remove('active'));
    liElement.classList.add('active');

    // Update State
    currentUf = uf;
    selectedServer = null; // reseta seleção
    document.getElementById('btnAssign').disabled = true;

    // Show Panels
    document.getElementById('currentUfLabel').textContent = `SPU/${uf}`;
    document.getElementById('tableUfLabel').textContent = `SPU/${uf}`;
    document.getElementById('allocationGrid').style.display = 'grid';
    document.getElementById('assignmentsCard').style.display = 'block';
    const saveSection = document.getElementById('saveSection');
    if(saveSection) saveSection.style.display = 'block';

    // Clear server selection UI
    document.querySelectorAll('.server-list li').forEach(el => el.classList.remove('selected'));
    
    // Ensure array exists for UF
    if (!assignments[uf]) assignments[uf] = [];

    // Gerar lista de servidores com o prefixo da UF
    currentMockServers = Array.from({length: 26}, (_, i) => `${uf}-Servidor ` + String.fromCharCode(65 + i));
    renderServers(currentMockServers);

    renderAssignments();
}

function renderServers(servers) {
    const list = document.getElementById('serverList');
    list.innerHTML = '';
    servers.forEach(server => {
        const li = document.createElement('li');
        li.textContent = server;
        li.onclick = () => selectServer(server, li);
        list.appendChild(li);
    });
}

function filterServers() {
    const q = document.getElementById('searchServer').value.toLowerCase();
    const filtered = currentMockServers.filter(s => s.toLowerCase().includes(q));
    renderServers(filtered);
    
    // Reselect if still in list
    if (selectedServer) {
        const items = document.querySelectorAll('.server-list li');
        items.forEach(item => {
            if (item.textContent === selectedServer) item.classList.add('selected');
        });
    }
}

function selectServer(server, liElement) {
    document.querySelectorAll('.server-list li').forEach(el => el.classList.remove('selected'));
    liElement.classList.add('selected');
    selectedServer = server;
    document.getElementById('btnAssign').disabled = false;
}

function assignProfile() {
    if (!currentUf || !selectedServer) return;

    const profile = document.querySelector('input[name="profile"]:checked').value;
    const canDistribute = document.getElementById('chkDistribute').checked;

    // Verifica se já não está alocado nesse mesmo perfil
    const existing = assignments[currentUf].find(a => a.server === selectedServer && a.profile === profile);
    if (existing) {
        alert(`${selectedServer} já está alocado como ${profile} em SPU/${currentUf}.`);
        return;
    }

    // Adiciona a alocação
    assignments[currentUf].push({ server: selectedServer, profile: profile, canDistribute: canDistribute });
    
    // Reset do checkbox
    document.getElementById('chkDistribute').checked = false;
    
    renderAssignments();
    
    // Feedback visual opcional
    const btn = document.getElementById('btnAssign');
    const originalText = btn.textContent;
    btn.textContent = 'Adicionado à Lista ✔️';
    btn.style.backgroundColor = '#15803d';
    setTimeout(() => {
        btn.textContent = originalText;
        btn.style.backgroundColor = '';
    }, 1500);
}

function removeAssignment(uf, index) {
    assignments[uf].splice(index, 1);
    renderAssignments();
}

async function salvarAlteracoes() {
    const btn = document.getElementById('btnSaveFinal');
    const originalText = btn.innerHTML;
    btn.innerHTML = '⏳ Salvando no Banco de Dados...';
    btn.disabled = true;

    if (window.saveConfigRoles) {
        const success = await window.saveConfigRoles(assignments);
        if (success) {
            btn.innerHTML = '✅ Configurações Salvas com Sucesso!';
            btn.style.backgroundColor = '#15803d';
        } else {
            btn.innerHTML = '❌ Erro ao Salvar (Tente Novamente)';
            btn.style.backgroundColor = '#b91c1c';
            alert('Atenção: Ocorreu um erro de conexão com o banco de dados Supabase.');
        }
    } else {
        alert('Supabase não inicializado.');
    }

    setTimeout(() => {
        btn.innerHTML = originalText;
        btn.style.backgroundColor = '#1e3a5f';
        btn.disabled = false;
    }, 3000);
}

function renderAssignments() {
    const tbody = document.getElementById('assignmentsTableBody');
    tbody.innerHTML = '';

    const list = assignments[currentUf] || [];

    if (list.length === 0) {
        tbody.innerHTML = `<tr><td colspan="3" class="empty-state">Nenhum servidor alocado nesta UF.</td></tr>`;
        return;
    }

    // Ordenar por Perfil e depois por Nome
    const sortedList = [...list].sort((a, b) => {
        if (a.profile !== b.profile) return a.profile.localeCompare(b.profile);
        return a.server.localeCompare(b.server);
    });

    sortedList.forEach((item, index) => {
        // Encontrar o index original para exclusão
        const originalIndex = list.findIndex(x => x === item);

        const tr = document.createElement('tr');
        
        // Estilizar o perfil com cor para facilitar leitura
        let profileColor = '#1e3a5f';
        let badgeBg = '#f1f5f9';
        if (item.profile === 'Superintendência') { profileColor = '#b91c1c'; badgeBg = '#fee2e2'; }
        else if (item.profile === 'Chefia SPU/UF') { profileColor = '#c2410c'; badgeBg = '#ffedd5'; }
        else if (item.profile === 'Coordenação SPU/UF') { profileColor = '#0369a1'; badgeBg = '#e0f2fe'; }

        let permissionBadge = '';
        if (item.canDistribute) {
            permissionBadge = `<span class="badge-permission">✓ Distribui Processos</span>`;
        }

        tr.innerHTML = `
            <td><b>${item.server}</b></td>
            <td>
                <span class="badge-profile" style="color: ${profileColor}; background-color: ${badgeBg};">${item.profile}</span>
                ${permissionBadge}
            </td>
            <td style="text-align: center;">
                <button class="btn-remove" title="Remover Alocação" onclick="removeAssignment('${currentUf}', ${originalIndex})">🗑️</button>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

// ==========================================
// FUNÇÕES DE ADMINISTRAR STATUS
// ==========================================

function toggleConfigTab(tabName) {
    const tabGestao = document.getElementById('menuTabGestao');
    const tabStatus = document.getElementById('menuTabStatus');
    const panelGestao = document.getElementById('panelGestao');
    const panelStatus = document.getElementById('panelStatus');
    const sidebarEquipes = document.getElementById('sidebarEquipes');
    
    if (!tabGestao || !tabStatus) return;

    if (tabName === 'gestao') {
        tabGestao.classList.add('active');
        tabStatus.classList.remove('active');
        panelGestao.style.display = 'block';
        panelStatus.style.display = 'none';
        sidebarEquipes.style.display = 'block';
    } else if (tabName === 'status') {
        tabStatus.classList.add('active');
        tabGestao.classList.remove('active');
        panelStatus.style.display = 'block';
        panelGestao.style.display = 'none';
        sidebarEquipes.style.display = 'none';
        
        preencherSelectStatus();
    }
}

// Busca as opções de status baseadas em WORKFLOW_STAGES (definido globalmente)
function preencherSelectStatus() {
    const select = document.getElementById('selectNewStatus');
    if (!select || select.options.length > 0) return;
    
    select.innerHTML = '<option value="">-- Selecione um novo status --</option>';
    
    // Fallback caso WORKFLOW_STAGES não esteja disponível
    const stages = typeof WORKFLOW_STAGES !== 'undefined' ? WORKFLOW_STAGES : {
        1: { tag_fluxo: 'Normal', status: 'Aguardando análise', instancia: 'Painel de Requerimentos' }
    };

    // Obter array de valores únicos para o select
    const uniqStatuses = [];
    Object.values(stages).forEach(s => {
        const fullStatus = s.status + " - " + s.instancia;
        if (!uniqStatuses.some(u => u.status === s.status && u.instancia === s.instancia)) {
            uniqStatuses.push(s);
        }
    });

    uniqStatuses.forEach(s => {
        const opt = document.createElement('option');
        // Usar status_geral como o value, para ser salvo de acordo (ou status, db.js usa status_geral)
        opt.value = JSON.stringify({ status: s.status, tag_fluxo: s.tag_fluxo, instancia: s.instancia, perfil: s.perfil, descricao: s.descricao });
        opt.textContent = `[${s.tag_fluxo}] ${s.status} - ${s.instancia}`;
        select.appendChild(opt);
    });
}

async function buscarStatusRequerimento() {
    const id = document.getElementById('inputProcessId').value.trim();
    if (!id) {
        alert('Digite o número do requerimento.');
        return;
    }
    
    try {
        const response = await fetch(`${window.SUPABASE_URL}/rest/v1/tabela_status_fluxo?select=dados_json&numero_requerimento=eq.${encodeURIComponent(id)}&order=id.desc&limit=1`, {
            method: 'GET',
            headers: {
                'apikey': window.SUPABASE_ANON_KEY,
                'Authorization': 'Bearer ' + window.SUPABASE_ANON_KEY
            }
        });
        
        if (!response.ok) throw new Error('Erro na requisição ao buscar status');
        
        const data = await response.json();
        const statusResult = document.getElementById('statusResult');
        const textSpan = document.getElementById('currentStatusText');
        
        if (data && data.length > 0) {
            const json = data[0].dados_json || {};
            const text = (json.status_geral || json.status || 'Desconhecido') + ' - ' + (json.instancia || 'Sem Instância');
            textSpan.textContent = text;
            window.currentAdminJsonData = json;
            window.currentAdminStatusExists = true;
            statusResult.style.display = 'block';
            window.currentAdminProcessId = id;
        } else {
            // Verificar se o requerimento existe em tabela_requerimentos antes de tentar cadastrar
            const reqCheck = await fetch(`${window.SUPABASE_URL}/rest/v1/tabela_requerimentos?select=numero_requerimento&numero_requerimento=eq.${encodeURIComponent(id)}`, {
                method: 'GET',
                headers: {
                    'apikey': window.SUPABASE_ANON_KEY,
                    'Authorization': 'Bearer ' + window.SUPABASE_ANON_KEY
                }
            });
            const reqData = await reqCheck.json();

            if (!reqData || reqData.length === 0) {
                // Se o requerimento existe no Painel (Laravel) mas não tinha sido sincronizado no Supabase, cria a base no Supabase automaticamente
                await fetch(`${window.SUPABASE_URL}/rest/v1/tabela_requerimentos`, {
                    method: 'POST',
                    headers: {
                        'apikey': window.SUPABASE_ANON_KEY,
                        'Authorization': 'Bearer ' + window.SUPABASE_ANON_KEY,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        numero_requerimento: id,
                        dados_json: { uf: id.substring(0, 2) }
                    })
                });
            }

            textSpan.textContent = 'Sem status inicializado (Novo)';
            window.currentAdminJsonData = {}; // Initialize empty JSON
            window.currentAdminStatusExists = false;
            statusResult.style.display = 'block';
            window.currentAdminProcessId = id;
        }
    } catch (e) {
        console.error(e);
        alert('Erro ao buscar o requerimento: ' + e.message);
    }
}

async function salvarNovoStatus() {
    const novoStatusVal = document.getElementById('selectNewStatus').value;
    if (!novoStatusVal || !window.currentAdminProcessId || !window.currentAdminJsonData) {
        alert('Selecione um status antes de salvar.');
        return;
    }
    
    const id = window.currentAdminProcessId;
    const jsonToSave = { ...window.currentAdminJsonData };
    
    // novoStatusVal é um JSON stringificado vindo do select
    try {
        const parsedStatus = JSON.parse(novoStatusVal);
        jsonToSave.status = parsedStatus.status;
        jsonToSave.status_geral = parsedStatus.tag_fluxo; // Ou o equivalente
        jsonToSave.instancia = parsedStatus.instancia;
        jsonToSave.perfil = parsedStatus.perfil;
        jsonToSave.descricao = parsedStatus.descricao;
        jsonToSave.checkpoint = parsedStatus.status;
    } catch(e) {
        console.error("Erro no parse do status", e);
    }
    
    try {
        let response;
        if (window.currentAdminStatusExists) {
            // Se já existe, atualiza com PATCH
            response = await fetch(`${window.SUPABASE_URL}/rest/v1/tabela_status_fluxo?numero_requerimento=eq.${encodeURIComponent(id)}`, {
                method: 'PATCH',
                headers: {
                    'apikey': window.SUPABASE_ANON_KEY,
                    'Authorization': 'Bearer ' + window.SUPABASE_ANON_KEY,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    dados_json: jsonToSave
                })
            });
        } else {
            // Se não existe, cria com POST
            response = await fetch(`${window.SUPABASE_URL}/rest/v1/tabela_status_fluxo`, {
                method: 'POST',
                headers: {
                    'apikey': window.SUPABASE_ANON_KEY,
                    'Authorization': 'Bearer ' + window.SUPABASE_ANON_KEY,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    numero_requerimento: id,
                    dados_json: jsonToSave
                })
            });
        }
        
        if (!response.ok) {
            const errText = await response.text();
            throw new Error('Erro do Supabase: ' + errText);
        }

        // Sincronizar também no banco de dados local do Laravel (tabela processos) para atualizar o Painel de Requerimentos
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (csrfToken) {
            try {
                await fetch('/configuracoes/atualizar-status-processo', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        numero_requerimento: id,
                        novo_status: jsonToSave.status,
                        tag_fluxo: jsonToSave.status_geral
                    })
                });
            } catch (laravelErr) {
                console.warn("Erro ao sincronizar com banco local Laravel:", laravelErr);
            }
        }
        
        alert('Status atualizado com sucesso!');
        buscarStatusRequerimento();
    } catch (e) {
        console.error(e);
        alert('Erro ao atualizar o status: ' + e.message);
    }
}
