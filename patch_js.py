import sys

path = r'c:\Users\luizn\Documents\1-PROGRAMAS\Foco-15\public\js\configuracoes.js'
content = """
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

// Opções predefinidas baseadas nos fluxos comuns do SPU
const TODOS_STATUS_POSSIVEIS = [
    { value: 'Novo Requerimento', text: 'Novo Requerimento (Recepcionado)' },
    { value: 'Em Análise de Viabilidade', text: 'Em Análise de Viabilidade' },
    { value: 'Viabilidade Confirmada', text: 'Viabilidade Confirmada' },
    { value: 'Em Análise Técnica', text: 'Em Análise Técnica (Planta/Memorial)' },
    { value: 'Aguardando Avaliação', text: 'Aguardando Avaliação' },
    { value: 'Avaliação Concluída', text: 'Avaliação Concluída' },
    { value: 'Em Elaboração de Contrato', text: 'Em Elaboração de Contrato' },
    { value: 'Aguardando Assinatura', text: 'Aguardando Assinatura' },
    { value: 'Concluído', text: 'Processo Concluído' },
    { value: 'Devolvido para Correção', text: 'Devolvido para Correção' },
    { value: 'Indeferido', text: 'Indeferido' },
    { value: 'Arquivado', text: 'Arquivado' }
];

function preencherSelectStatus() {
    const select = document.getElementById('selectNewStatus');
    if (!select || select.options.length > 0) return;
    
    select.innerHTML = '<option value="">-- Selecione um novo status --</option>';
    TODOS_STATUS_POSSIVEIS.forEach(s => {
        const opt = document.createElement('option');
        opt.value = s.value;
        opt.textContent = s.text;
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
        
        if (!response.ok) throw new Error('Erro na requisição');
        
        const data = await response.json();
        const statusResult = document.getElementById('statusResult');
        const textSpan = document.getElementById('currentStatusText');
        
        if (data && data.length > 0 && data[0].dados_json) {
            const json = data[0].dados_json;
            const text = (json.status_geral || json.status || 'Desconhecido') + ' - ' + (json.instancia || 'Sem Instância');
            textSpan.textContent = text;
            statusResult.style.display = 'block';
            window.currentAdminProcessId = id;
            window.currentAdminJsonData = json;
        } else {
            alert('Requerimento não encontrado ou sem status inicializado.');
            statusResult.style.display = 'none';
        }
    } catch (e) {
        console.error(e);
        alert('Erro ao buscar o requerimento no banco de dados.');
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
    jsonToSave.status_geral = novoStatusVal;
    jsonToSave.status = novoStatusVal;
    
    try {
        const response = await fetch(`${window.SUPABASE_URL}/rest/v1/tabela_status_fluxo`, {
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
        
        if (!response.ok) throw new Error('Erro na requisição');
        
        alert('Status atualizado com sucesso para ' + novoStatusVal + '!');
        buscarStatusRequerimento();
    } catch (e) {
        console.error(e);
        alert('Erro ao atualizar o status.');
    }
}
"""
with open(path, 'a', encoding='utf-8') as f:
    f.write(content)

print("success")
