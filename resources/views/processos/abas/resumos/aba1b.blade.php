@php
  $focoRips = $processo->foco?->rips ?? collect();
  $focoCadastros = $processo->foco?->cadastrosMinimos ?? collect();
@endphp

@if($focoRips->isEmpty() && $focoCadastros->isEmpty())
<div style="display:flex;flex-direction:column;">
    <div id="rips-aba7-container">
        <p style="color:#64748b; font-style:italic;">Carregando informações dos RIPs via Supabase...</p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', async function() {
  const container = document.getElementById('rips-aba7-container');
  const processId = window.CURRENT_PROCESS_ID || "{{ $processo->numero_requerimento ?? '' }}";
  const SUPA_URL = window.SUPABASE_URL || 'https://rzdmnzuweyzhilfcungl.supabase.co';
  const SUPA_KEY = window.SUPABASE_ANON_KEY;

  if (!processId || !SUPA_URL || !SUPA_KEY) { 
      if (container) container.innerHTML = '<p style="color:#64748b;font-style:italic;">Erro de configuração. Não foi possível carregar os RIPs.</p>';
      return; 
  }

  function buildField(label, value) {
    return `<div style="display:flex;align-items:baseline;margin-bottom:6px;padding:5px 0;font-size:0.9rem;">
      <span style="display:flex;width:240px;"><span style="font-weight:600;color:#334155;white-space:nowrap;">${label}</span><span style="flex:1;border-bottom:1px dotted #94a3b8;min-width:10px;"></span><span style="white-space:nowrap;color:#334155;">:</span></span>
      <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;color:#0f172a;border-radius:3px;">${value || '-'}</span>
    </div>`;
  }

  let rips = [], cadastros = [];
  try {
    const urlInd = `${SUPA_URL}/rest/v1/tabela_indicacao?select=*&numero_requerimento=eq.${encodeURIComponent(processId)}&limit=1`;
    const resInd = await fetch(urlInd, { headers: { 'apikey': SUPA_KEY, 'Authorization': `Bearer ${SUPA_KEY}` } });
    if (resInd.ok) {
      const rows = await resInd.json();
      if (rows?.[0]?.dados_json) {
        const dj = typeof rows[0].dados_json === 'string' ? JSON.parse(rows[0].dados_json) : rows[0].dados_json;
        if (dj) { rips = dj.rips || []; cadastros = dj.cadastros_minimos || []; }
      }
    }
  } catch(e) { console.error('[Aba7-RIP] Erro ao consultar tabela_indicacao:', e); }

  if (rips.length === 0 && cadastros.length === 0) {
    try {
      const reqUrl = `${SUPA_URL}/rest/v1/tabela_requerimentos?select=*&numero_requerimento=eq.${encodeURIComponent(processId)}&limit=1`;
      const reqRes = await fetch(reqUrl, { headers: { 'apikey': SUPA_KEY, 'Authorization': `Bearer ${SUPA_KEY}` } });
      if (reqRes.ok) {
        const reqList = await reqRes.json();
        if (reqList && reqList.length > 0) {
          const dj = typeof reqList[0].dados_json === 'string' ? JSON.parse(reqList[0].dados_json) : reqList[0].dados_json;
          if (dj) { rips = dj.rips || []; cadastros = dj.cadastros_minimos || []; }
        }
      }
    } catch (e) { console.error('[Aba7-RIP] Erro ao consultar tabela_requerimentos:', e); }
  }

  if (container) container.innerHTML = '';
  
  if (rips.length === 0 && cadastros.length === 0) {
    if (container) container.innerHTML = '<p style="color:#64748b;font-style:italic;">Nenhum RIP ou Cadastro Mínimo associado a este processo.</p>';
    return;
  }

  for (const rip of rips) {
    let dadosSPU = {};
    try { if (typeof window.fetchSPU === 'function') dadosSPU = await window.fetchSPU(rip); } catch(e) {}
    
    const block = document.createElement('div');
    block.style.cssText = 'background:white;border:1px solid #cbd5e1;border-radius:8px;overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,0.05);margin-bottom:8px;';
    block.innerHTML = `<div style="background:#e2e8f0;color:#1e293b;padding:12px 16px;cursor:pointer;display:flex;justify-content:space-between;align-items:center;font-weight:bold;font-size:0.95em;" onclick="const b=this.nextElementSibling;const i=this.querySelector('span:last-child');if(b.style.display==='none'){b.style.display='block';i.style.transform='rotate(180deg)';}else{b.style.display='none';i.style.transform='rotate(0deg)';}"><span>🏠 Imóvel (RIP): ${rip}</span><span style="transition:transform 0.2s;">▼</span></div>
    <div style="padding:16px;display:none;background:#fff;"><div style="display:flex;flex-direction:column;">
      ${buildField('Conceituação do Imóvel', dadosSPU.conceituacao)}
      ${buildField('Condição de Urbanização', dadosSPU.condicao_urbanizacao)}
      ${buildField('Natureza do Terreno', dadosSPU.natureza || dadosSPU.natureza_terreno)}
      ${buildField('Tipo de Imóvel', dadosSPU.tipo_imovel)}
      ${buildField('CEP', dadosSPU.cep)}
      ${buildField('Logradouro', dadosSPU.logradouro || dadosSPU.endereco)}
      ${buildField('Bairro', dadosSPU.bairro)}
      ${buildField('Município / UF', (dadosSPU.municipio || '') + ' / ' + (dadosSPU.uf || ''))}
      ${buildField('Área Total (m²)', dadosSPU.area_total)}
      ${buildField('Área da União (m²)', dadosSPU.area_uniao || dadosSPU.area_terreno_uniao)}
      ${buildField('Área Construída Total (m²)', dadosSPU.area_construida_total)}
      ${buildField('Área Construída Disponível (m²)', dadosSPU.area_construida_disponivel)}
      ${buildField('Área de Terreno Disponível (m²)', dadosSPU.area_terreno_disponivel)}
      ${buildField('Benfeitorias', dadosSPU.benfeitorias)}
      ${buildField('Situação da Incorporação', dadosSPU.situacao_incorporacao || dadosSPU.situacao)}
      ${buildField('Processo de Incorporação', dadosSPU.processo_incorporacao)}
      ${buildField('LPM/1831 ou LMEO Homologadas?', dadosSPU.lpm_homologada)}
      ${buildField('Valor da Avaliação (R$)', dadosSPU.valor_avaliado || dadosSPU.valor_avaliacao)}
      ${buildField('Data da Avaliação', dadosSPU.data_avaliacao)}
      ${buildField('Instrumento de Avaliação', dadosSPU.instrumento_avaliacao)}
    </div></div>`;
    if (container) container.appendChild(block);
  }

  cadastros.forEach((cad, idx) => {
    const block = document.createElement('div');
    block.style.cssText = 'background:white;border:1px solid #cbd5e1;border-radius:8px;overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,0.05);margin-bottom:8px;';
    block.innerHTML = `<div style="background:#f1f5f9;color:#1e293b;padding:12px 16px;cursor:pointer;display:flex;justify-content:space-between;align-items:center;font-weight:bold;font-size:0.95em;" onclick="const b=this.nextElementSibling;const i=this.querySelector('span:last-child');if(b.style.display==='none'){b.style.display='block';i.style.transform='rotate(180deg)';}else{b.style.display='none';i.style.transform='rotate(0deg)';}"><span>📍 Cadastro Mínimo ${idx+1}</span><span style="transition:transform 0.2s;">▼</span></div>
    <div style="padding:16px;display:none;background:#fff;"><div style="display:flex;flex-direction:column;">
      ${buildField('CEP', cad.cep)}
      ${buildField('Logradouro', (cad.logradouro || '') + (cad.numero ? ', nº ' + cad.numero : ' S/N') + (cad.complemento ? ' - ' + cad.complemento : ''))}
      ${buildField('Município / UF', (cad.municipio || '') + ' / ' + (cad.uf || ''))}
      ${buildField('Área Estimada (m²)', cad.area)}
      ${buildField('Observações', cad.observacoes)}
    </div></div>`;
    if (container) container.appendChild(block);
  });
});
</script>
@else
<div style="display: flex; flex-direction: column; gap: 10px;" id="rips-aba7-mysql">
  @foreach($focoRips as $rip)
  <div style="background:white;border:1px solid #cbd5e1;border-radius:8px;overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,0.05);">
    <div style="background:#e2e8f0;color:#1e293b;padding:12px 16px;cursor:pointer;display:flex;justify-content:space-between;align-items:center;font-weight:bold;font-size:0.95em;" onclick="const b=this.nextElementSibling;const i=this.querySelector('span:last-child');if(b.style.display==='none'){b.style.display='block';i.style.transform='rotate(180deg)';}else{b.style.display='none';i.style.transform='rotate(0deg)';}">
      <span>🏠 Imóvel (RIP): {{ $rip->numero_rip }}</span>
      <span style="transition:transform 0.2s;">▼</span>
    </div>
    <div style="padding:16px;display:none;background:#fff;" id="rip-spu-aba7-{{ $loop->index }}">
      <p style="color:#64748b;font-style:italic;font-size:0.85rem;">Carregando dados do SPU...</p>
    </div>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', async function() {
      const el = document.getElementById('rip-spu-aba7-{{ $loop->index }}');
      let d = {};
      try { if (typeof window.fetchSPU === 'function') d = await window.fetchSPU('{{ $rip->numero_rip }}'); } catch(e) {}
      function f(l,v){return `<div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;"><span style="width:240px;font-weight:600;color:#334155;">${l}:</span><span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">${v||'-'}</span></div>`;}
      if (el) el.innerHTML = `<div>
        ${f('Conceituação do Imóvel', d.conceituacao)}
        ${f('Condição de Urbanização', d.condicao_urbanizacao)}
        ${f('Natureza do Terreno', d.natureza || d.natureza_terreno)}
        ${f('Tipo de Imóvel', d.tipo_imovel)}
        ${f('CEP', d.cep)}
        ${f('Logradouro', d.logradouro || d.endereco)}
        ${f('Bairro', d.bairro)}
        ${f('Município / UF', (d.municipio || '') + ' / ' + (d.uf || ''))}
        ${f('Área Total (m²)', d.area_total)}
        ${f('Área da União (m²)', d.area_uniao || d.area_terreno_uniao)}
        ${f('Área Construída Total (m²)', d.area_construida_total)}
        ${f('Área Construída Disponível (m²)', d.area_construida_disponivel)}
        ${f('Área de Terreno Disponível (m²)', d.area_terreno_disponivel)}
        ${f('Benfeitorias', d.benfeitorias)}
        ${f('Situação da Incorporação', d.situacao_incorporacao || d.situacao)}
        ${f('Processo de Incorporação', d.processo_incorporacao)}
        ${f('LPM/1831 ou LMEO Homologadas?', d.lpm_homologada)}
        ${f('Valor da Avaliação (R$)', d.valor_avaliado || d.valor_avaliacao)}
        ${f('Data da Avaliação', d.data_avaliacao)}
        ${f('Instrumento de Avaliação', d.instrumento_avaliacao)}
      </div>`;
    });
  </script>
  @endforeach

  @foreach($focoCadastros as $cad)
  <div style="background:white;border:1px solid #cbd5e1;border-radius:8px;overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,0.05);">
    <div style="background:#e2e8f0;color:#1e293b;padding:12px 16px;cursor:pointer;display:flex;justify-content:space-between;align-items:center;font-weight:bold;font-size:0.95em;" onclick="const b=this.nextElementSibling;const i=this.querySelector('span:last-child');if(b.style.display==='none'){b.style.display='block';i.style.transform='rotate(180deg)';}else{b.style.display='none';i.style.transform='rotate(0deg)';}">
      <span>📝 Cadastro Mínimo #{{ $loop->iteration }} (Sem RIP)</span>
      <span style="transition:transform 0.2s;">▼</span>
    </div>
    <div style="padding:16px;display:none;background:#fff;">
      <div style="display:flex;flex-direction:column;">
        <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;"><span style="width:240px;font-weight:600;color:#334155;">CEP:</span><span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $cad->cep ?: '-' }}</span></div>
        <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;"><span style="width:240px;font-weight:600;color:#334155;">Área Estimada (m²):</span><span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $cad->area ?: '-' }}</span></div>
        <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;"><span style="width:240px;font-weight:600;color:#334155;">Logradouro:</span><span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $cad->logradouro ?: '-' }} {{ $cad->numero ? ', nº '.$cad->numero : '' }}</span></div>
        <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;"><span style="width:240px;font-weight:600;color:#334155;">Município / UF:</span><span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $cad->municipio ?: '-' }} / {{ $cad->uf ?: '-' }}</span></div>
      </div>
    </div>
  </div>
  @endforeach
</div>
@endif
