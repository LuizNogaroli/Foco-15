import sys
import re

path = r'c:\Users\luizn\Documents\1-PROGRAMAS\Foco-15\public\js\configuracoes.js'
with open(path, 'r', encoding='utf-8') as f:
    content = f.read()

# Substituir a constante manual e a função de preencher
old_code = '''// Opções predefinidas baseadas nos fluxos comuns do SPU
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
}'''

new_code = '''// Busca as opções de status baseadas em WORKFLOW_STAGES (definido globalmente)
function preencherSelectStatus() {
    const select = document.getElementById('selectNewStatus');
    if (!select || select.options.length > 0) return;
    
    select.innerHTML = '<option value="">-- Selecione um novo status --</option>';
    
    // Fallback caso WORKFLOW_STAGES não esteja disponível
    const stages = window.WORKFLOW_STAGES || {
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
}'''

content = content.replace(old_code, new_code)

# E atualizar a lógica de salvarNovoStatus() para processar esse JSON stringificado
old_salvar = '''async function salvarNovoStatus() {
    const novoStatusVal = document.getElementById('selectNewStatus').value;
    if (!novoStatusVal || !window.currentAdminProcessId || !window.currentAdminJsonData) {
        alert('Selecione um status antes de salvar.');
        return;
    }
    
    const id = window.currentAdminProcessId;
    const jsonToSave = { ...window.currentAdminJsonData };
    jsonToSave.status_geral = novoStatusVal;
    jsonToSave.status = novoStatusVal;'''

new_salvar = '''async function salvarNovoStatus() {
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
    }'''

content = content.replace(old_salvar, new_salvar)

with open(path, 'w', encoding='utf-8') as f:
    f.write(content)

print('Updated configuracoes.js')
