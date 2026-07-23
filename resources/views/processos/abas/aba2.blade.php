<style>
  .custom-empty-select { background-color: #ffffff !important; border: 1px solid #3b82f6 !important; box-shadow: 0 0 4px rgba(59,130,246,0.3) !important; }
  .switch { position: relative; display: inline-block; width: 34px; height: 20px; }
  .switch input { opacity: 0; width: 0; height: 0; }
  .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #22c55e; transition: .4s; }
  .slider:before { position: absolute; content: ""; height: 16px; width: 16px; left: 2px; bottom: 2px; background-color: white; transition: .4s; }
  input:checked + .slider { background-color: #ef4444; }
  input:checked + .slider:before { transform: translateX(14px); }
  .slider.round { border-radius: 20px; }
  .slider.round:before { border-radius: 50%; }
  .edit-toggle { display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: bold; cursor: pointer; margin: 0; }
  .toggle-label-left { color: #16a34a; transition: opacity 0.3s; opacity: 1; }
  .toggle-label-right { color: #dc2626; transition: opacity 0.3s; opacity: 0.4; }
  .edit-toggle:has(input:checked) .toggle-label-left { opacity: 0.4; }
  .edit-toggle:has(input:checked) .toggle-label-right { opacity: 1; }

  #map { height: 500px; width: 100%; border: 1px solid #ddd; border-radius: 8px; margin: 10px 0; z-index: 1; }
  .cep-row { display: flex; gap: 10px; align-items: flex-start; }
  #cep-info { margin-top: 5px; font-size: 0.85em; min-height: 1.2em; }
  .cep-info-ok { color: #28a745; font-weight: bold; }
  .cep-info-erro { color: #dc3545; font-weight: bold; }
  .btn-search { padding: 10px 15px; height: 42px; white-space: nowrap; }
  .lista-geo { list-style: none; padding: 0; margin-top: 15px; }
  .lista-geo li { background: #f8f9fa; border: 1px solid #e2e8f0; padding: 10px 15px; margin-bottom: 8px; border-radius: 6px; display: flex; justify-content: space-between; align-items: center; }
  
  .consolidated-box {
      background-color: #f1f5f9;
      border-left: 4px solid #0056b3;
      padding: 15px;
      border-radius: 4px;
      margin-bottom: 20px;
  }
  .consolidated-box h4 { margin-top: 0; color: #1e3a5f; font-size: 1.1em; }
  .consolidated-box p { margin: 5px 0; font-size: 0.95em; color: #475569; }

  /* MODAL GEO */
  .geo-modal-overlay {
      display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
      background: rgba(0,0,0,0.6); backdrop-filter: blur(4px); z-index: 100000;
      align-items: center; justify-content: center;
  }
  .geo-modal-content {
      background: #fff; width: 90%; max-width: 900px; border-radius: 12px;
      display: flex; flex-direction: column; overflow: hidden;
      box-shadow: 0 10px 25px rgba(0,0,0,0.2);
  }
  .geo-modal-header {
      padding: 15px 20px; background: #1e3a5f; color: white;
      display: flex; justify-content: space-between; align-items: center;
  }
  .geo-modal-header h3 { margin: 0; font-size: 1.1em; }
  .geo-modal-close {
      background: none; border: none; color: white; font-size: 1.5em; cursor: pointer;
  }
  .geo-modal-body { padding: 20px; flex: 1; }
  .geo-modal-footer {
      padding: 15px 20px; background: #f8fafc; border-top: 1px solid #e2e8f0;
      display: flex; justify-content: flex-end; gap: 10px;
  }
  #modal-map { height: 500px; width: 100%; border: 1px solid #ddd; border-radius: 8px; }

  .campo-alterado {
      background-color: #fffacd !important;
      border-color: #f59e0b !important;
  }
  .valor-original-hint {
      display: block;
      font-size: 11px;
      color: #64748b;
      margin-top: 3px;
      font-style: italic;
  }
</style>
<div class="form-container">

    <h2>Diagnóstico Preliminar</h2>

    <!-- ========== ACCORDIONS ABA 1 (SOMENTE LEITURA) ========== -->
    <div class="accordion-container" style="margin-bottom: 25px; display: flex; flex-direction: column; gap: 15px;">

      <!-- Aba 1a: Dados do Requerimento -->
      <div class="accordion-item" id="acc_aba1a" style="border: 2px solid #1e3a5f; border-radius: 8px; overflow: hidden;">
        <div class="accordion-header" style="background-color: #1e3a5f; color: white; padding: 15px 20px; cursor: pointer; display: flex; justify-content: space-between; align-items: center; font-weight: bold; font-size: 1.1em;" onclick="const body = this.nextElementSibling; const icon = this.querySelector('span:last-child'); if(body.style.display === 'none'){ body.style.display = 'block'; icon.style.transform = 'rotate(180deg)'; } else { body.style.display = 'none'; icon.style.transform = 'rotate(0deg)'; }">
          <span>📋 Dados do Requerimento</span>
          <span style="transition: transform 0.3s; font-size: 1.2em;">▼</span>
        </div>
        <div class="accordion-body" style="padding: 20px; display: none; border-top: 1px solid #cbd5e1; background: #fff;">
          @php $req = $requerimento ?? null; @endphp
          <div style="display:flex;flex-direction:column;">
            <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;"><span style="width:240px;font-weight:600;color:#334155;">Nome do Requerente:</span><span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $req?->nome_requerente ?? '-' }}</span></div>
            <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;"><span style="width:240px;font-weight:600;color:#334155;">CPF/CNPJ:</span><span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $req?->cpf_cnpj_requerente ?? '-' }}</span></div>
            <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;"><span style="width:240px;font-weight:600;color:#334155;">Telefone:</span><span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $req?->contato_requerente ?? '-' }}</span></div>
            <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;"><span style="width:240px;font-weight:600;color:#334155;">Número do Requerimento:</span><span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $req?->numero_requerimento ?? $processo->numero_requerimento }}</span></div>
            <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;"><span style="width:240px;font-weight:600;color:#334155;">Data do Requerimento:</span><span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $req?->data_hora_recebimento ?? $processo->created_at?->format('d/m/Y') ?? '-' }}</span></div>
            <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;"><span style="width:240px;font-weight:600;color:#334155;">Número do Processo SEI:</span><span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $req?->nup_sei ?? '-' }}</span></div>
            <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;"><span style="width:240px;font-weight:600;color:#334155;">Prioridade Legal:</span><span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;color:#ea580c;font-weight:bold;">{{ $req?->prioridade_legal ?? 'Não se aplica' }}</span></div>
            <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;"><span style="width:240px;font-weight:600;color:#334155;">Tipo de Requerimento:</span><span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $req?->tipo_requerimento ?? $processo->tipo_requerimento ?? '-' }}</span></div>
          </div>
          @if($req?->nome_representante)
          <div style="margin-top:16px; padding-top:16px; border-top:1px dashed #cbd5e1;">
            <div style="font-size:0.85rem; font-weight:700; color:#1e3a5f; margin-bottom:10px;">Representante Legal</div>
            <div style="display:flex;flex-direction:column;">
              <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;"><span style="width:240px;font-weight:600;color:#334155;">Nome:</span><span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $req?->nome_representante ?? '-' }}</span></div>
              <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;"><span style="width:240px;font-weight:600;color:#334155;">CPF/CNPJ do Representante:</span><span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $req?->cpf_cnpj_representante ?? '-' }}</span></div>
              <div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;"><span style="width:240px;font-weight:600;color:#334155;">Telefone do Representante:</span><span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">{{ $req?->contato_representante ?? '-' }}</span></div>
            </div>
          </div>
          @endif
        </div>
      </div>

      <!-- Aba 1b: Indicação do Imóvel -->
      <div class="accordion-item" id="acc_aba1b" style="border: 2px solid #1e3a5f; border-radius: 8px; overflow: hidden;">
        <div class="accordion-header" style="background-color: #1e3a5f; color: white; padding: 15px 20px; cursor: pointer; display: flex; justify-content: space-between; align-items: center; font-weight: bold; font-size: 1.1em;" onclick="const body = this.nextElementSibling; const icon = this.querySelector('span:last-child'); if(body.style.display === 'none'){ body.style.display = 'block'; icon.style.transform = 'rotate(180deg)'; } else { body.style.display = 'none'; icon.style.transform = 'rotate(0deg)'; }">
          <span>📍 RIP(s) ou Cadastro(s) Mínimo(s)</span>
          <span style="transition: transform 0.3s; font-size: 1.2em;">▼</span>
        </div>
        <div class="accordion-body" style="padding: 20px; display: none; border-top: 1px solid #cbd5e1; background: #fff;">
          @php
            $focoRips = $processo->foco?->rips ?? collect();
            $focoCadastros = $processo->foco?->cadastrosMinimos ?? collect();

            if ($focoRips->isEmpty()) {
                $draftAba1 = \App\Models\FocoDraft::where('processo_id', $processo->id)
                    ->where('user_id', auth()->id())
                    ->where('aba', '1')
                    ->first();
                
                if ($draftAba1) {
                    $draftRips = $draftAba1->data['rips'] ?? $draftAba1->data['rips[]'] ?? [];
                    if (!is_array($draftRips)) $draftRips = [$draftRips];
                    
                    if (!empty($draftRips)) {
                        $focoRips = collect($draftRips)->filter()->map(function($rip) {
                            return (object) ['numero_rip' => $rip];
                        });
                    }
                }
            }

            if ($focoCadastros->isEmpty()) {
                $draftAba1 = $draftAba1 ?? \App\Models\FocoDraft::where('processo_id', $processo->id)
                    ->where('user_id', auth()->id())
                    ->where('aba', '1')
                    ->first();
                    
                if ($draftAba1) {
                    $draftCads = $draftAba1->data['cadastros_minimos'] ?? $draftAba1->data['cadastros_minimos[]'] ?? [];
                    if (!empty($draftCads)) {
                        $cads = is_array($draftCads) ? $draftCads : json_decode($draftCads, true) ?? [];
                        if (!is_array($cads)) $cads = [$cads]; // fallback if it was a single string that didn't decode to array
                        
                        $focoCadastros = collect($cads)->map(function($cad) {
                            if (is_string($cad)) $cad = json_decode($cad, true) ?? [];
                            return (object) $cad;
                        });
                    }
                }
            }
          @endphp

          @if($focoRips->isEmpty() && $focoCadastros->isEmpty())
            <div id="rips-aba2-container">
              <p style="color:#64748b; font-style:italic;">Nenhum RIP ou Cadastro Mínimo associado. Os dados são carregados dinamicamente abaixo.</p>
            </div>
            <script>
            document.addEventListener('DOMContentLoaded', async function() {
              const container = document.getElementById('rips-aba2-container');
              const processId = window.CURRENT_PROCESS_ID;
              const SUPA_URL = window.SUPABASE_URL;
              const SUPA_KEY = window.SUPABASE_ANON_KEY;
              if (!processId || !SUPA_URL || !SUPA_KEY) return;

              function buildField(label, value) {
                return `<div style="display:flex;align-items:baseline;margin-bottom:6px;padding:5px 0;font-size:0.9rem;">
                  <span style="display:flex;width:240px;"><span style="font-weight:600;color:#334155;white-space:nowrap;">${label}</span><span style="flex:1;border-bottom:1px dotted #94a3b8;min-width:10px;"></span><span style="white-space:nowrap;color:#334155;">:</span></span>
                  <span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;color:#0f172a;border-radius:3px;">${value || '-'}</span>
                </div>`;
              }

              let rips = [], cadastros = [];
              let conceituacao = '';
              try {
                const urlInd = `${SUPA_URL}/rest/v1/tabela_indicacao?select=*&numero_requerimento=eq.${encodeURIComponent(processId)}&limit=1`;
                const resInd = await fetch(urlInd, { headers: { 'apikey': SUPA_KEY, 'Authorization': `Bearer ${SUPA_KEY}` } });
                if (resInd.ok) {
                  const rows = await resInd.json();
                  if (rows?.[0]?.dados_json) {
                    const dj = typeof rows[0].dados_json === 'string' ? JSON.parse(rows[0].dados_json) : rows[0].dados_json;
                    if (dj) {
                      rips = dj.rips || [];
                      cadastros = dj.cadastros_minimos || [];
                      conceituacao = dj.conceituacao_imovel || '';
                    }
                  }
                }
              } catch(e) { console.warn('Erro indicacao:', e); }

              if (rips.length === 0 && cadastros.length === 0 && !conceituacao) {
                try {
                  const reqUrl = `${SUPA_URL}/rest/v1/tabela_requerimentos?select=*&numero_requerimento=eq.${encodeURIComponent(processId)}&limit=1`;
                  const reqRes = await fetch(reqUrl, { headers: { 'apikey': SUPA_KEY, 'Authorization': `Bearer ${SUPA_KEY}` } });
                  if (reqRes.ok) {
                    const reqList = await reqRes.json();
                    if (reqList && reqList.length > 0) {
                      const dj = typeof reqList[0].dados_json === 'string' ? JSON.parse(reqList[0].dados_json) : reqList[0].dados_json;
                      if (dj) {
                        rips = dj.rips || [];
                        cadastros = dj.cadastros_minimos || [];
                      }
                    }
                  }
                } catch (e) {
                  console.warn('Erro tabela_requerimentos:', e);
                }
              }

              console.log('aba2 fallback: processId =', processId, 'rips found =', rips);


              container.innerHTML = '';
              if (rips.length === 0 && cadastros.length === 0) {
                container.innerHTML = '<p style="color:#64748b;font-style:italic;">Nenhum RIP ou Cadastro Mínimo associado a este processo.</p>';
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
                container.appendChild(block);
              }

              cadastros.forEach((cad, idx) => {
                const block = document.createElement('div');
                block.style.cssText = 'background:white;border:1px solid #cbd5e1;border-radius:8px;overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,0.05);margin-bottom:8px;';
                block.innerHTML = `<div style="background:#e2e8f0;color:#1e293b;padding:12px 16px;cursor:pointer;display:flex;justify-content:space-between;align-items:center;font-weight:bold;font-size:0.95em;" onclick="const b=this.nextElementSibling;const i=this.querySelector('span:last-child');if(b.style.display==='none'){b.style.display='block';i.style.transform='rotate(180deg)';}else{b.style.display='none';i.style.transform='rotate(0deg)';}"><span>📝 Cadastro Mínimo #${idx+1} (Sem RIP)</span><span style="transition:transform 0.2s;">▼</span></div>
                <div style="padding:16px;display:none;background:#fff;"><div style="display:flex;flex-direction:column;">${buildField('CEP',cad.cep)}${buildField('Área (m²)',cad.area)}${buildField('Logradouro',cad.logradouro||cad.endereco)}${buildField('Município/UF',(cad.municipio||'')+' / '+(cad.uf||''))}</div></div>`;
                container.appendChild(block);
              });
            });
            </script>
          @else
            {{-- RIPs já disponíveis no MySQL --}}
            <div style="display: flex; flex-direction: column; gap: 10px;" id="rips-aba2-mysql">
              @foreach($focoRips as $rip)
              <div style="background:white;border:1px solid #cbd5e1;border-radius:8px;overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                <div style="background:#e2e8f0;color:#1e293b;padding:12px 16px;cursor:pointer;display:flex;justify-content:space-between;align-items:center;font-weight:bold;font-size:0.95em;" onclick="const b=this.nextElementSibling;const i=this.querySelector('span:last-child');if(b.style.display==='none'){b.style.display='block';i.style.transform='rotate(180deg)';}else{b.style.display='none';i.style.transform='rotate(0deg)';}">
                  <span>🏠 Imóvel (RIP): {{ $rip->numero_rip }}</span>
                  <span style="transition:transform 0.2s;">▼</span>
                </div>
                <div style="padding:16px;display:none;background:#fff;" id="rip-spu-aba2-{{ $loop->index }}">
                  <p style="color:#64748b;font-style:italic;font-size:0.85rem;">Carregando dados do SPU...</p>
                </div>
              </div>
              <script>
                document.addEventListener('DOMContentLoaded', async function() {
                  const el = document.getElementById('rip-spu-aba2-{{ $loop->index }}');
                  let d = {};
                  try { if (typeof window.fetchSPU === 'function') d = await window.fetchSPU('{{ $rip->numero_rip }}'); } catch(e) {}
                  function f(l,v){return `<div style="display:flex;align-items:baseline;margin-bottom:6px;font-size:0.9rem;"><span style="width:240px;font-weight:600;color:#334155;">${l}:</span><span style="flex:1;margin-left:6px;padding:3px 10px;background:#f1f5f9;border-radius:3px;">${v||'-'}</span></div>`;}
                  el.innerHTML = `<div>
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
                  <span>📝 Cadastro Mínimo #{{ $loop->index+1 }} (Sem RIP)</span>
                  <span style="transition:transform 0.2s;">▼</span>
                </div>
                <div style="padding:16px;display:none;background:#fff;">
                  <div><strong>CEP:</strong> {{ $cad->cep ?? '-' }} | <strong>Área:</strong> {{ $cad->area_m2 ?? '-' }}m²</div>
                </div>
              </div>
              @endforeach
            </div>
          @endif
        </div>
      </div>
    </div>
    <!-- ======================================================= -->

    @php
        $simuladoCookie = request()->cookie('perfil_simulado');
        $user = auth()->user();
        $isAdmin = $user && ($user->hasRole('Administrador') || $user->hasRole('Direção'));
        
        $canEditAba2 = false;
        if ($simuladoCookie === 'ALL' || $simuladoCookie === 'CARACTERIZACAO') {
            $canEditAba2 = true;
        } elseif (!$simuladoCookie && $isAdmin) {
            $canEditAba2 = true;
        } elseif ($user && $user->hasRole('Equipe Caracterização')) {
            $canEditAba2 = true;
        }
    @endphp
    <fieldset @if(!$canEditAba2) disabled @endif>
    <form method="POST" action="{{ route('processos.tramitar', $processo->id) }}" id="form02">
        @csrf
        <input type="hidden" name="aba_atual" value="2">
        <input type="hidden" name="next_aba" value="index">

      <!-- ========== ACCORDION INDICAÇÕES ========== -->
<style>
  fieldset { border: none !important; }
  .custom-empty-select { background-color: #ffffff !important; border: 1px solid #3b82f6 !important; box-shadow: 0 0 4px rgba(59,130,246,0.3) !important; }

          .accordion-container {
              display: flex;
              flex-direction: column;
              gap: 15px;
              margin-bottom: 25px;
          }
          .accordion-item {
              border: none;
              border-radius: 8px;
              overflow: hidden;
              background: #fff;
              box-shadow: 0 2px 4px rgba(0,0,0,0.05);
          }
          .accordion-header {
              padding: 15px 20px;
              cursor: pointer;
              display: flex;
              justify-content: space-between;
              align-items: center;
              font-weight: bold;
              font-size: 1.1em;
              transition: background 0.2s;
          }
          .accordion-header.type-rip {
              background: #eff6ff;
              color: #1e40af;
              border-left: 5px solid #3b82f6;
          }
          .accordion-header.type-cadastro {
              background: #f0fdf4;
              color: #166534;
              border-left: 5px solid #22c55e;
          }
          .accordion-header:hover {
              filter: brightness(0.95);
          }
          .accordion-body {
              display: none;
              padding: 20px;
              border-top: none;
          }
          .accordion-body.active {
              display: block;
          }
          .accordion-icon {
              font-size: 1.2em;
              transition: transform 0.3s;
          }
          #acc_aba1 .accordion-icon {
              color: white !important;
          }
          .type-rip .accordion-icon, .type-cadastro .accordion-icon {
              color: #1e3a5f !important;
          }
          .active .accordion-icon {
              transform: rotate(180deg);
          }
          /* Ocultar botões de consulta/edição conforme solicitado */
          .edit-toggle {
              display: none !important;
          }
          
          /* Estilo para placeholders e textos de campos vazios em vermelho */
          .empty-spu-field:disabled,
          select.empty-spu-field:disabled {
              color: #dc2626 !important;
              -webkit-text-fill-color: #dc2626 !important;
              opacity: 1;
          }
          .empty-spu-field::placeholder {
              color: #dc2626 !important;
              opacity: 1;
          }
      </style>

      <!-- Bloco de Solicitação de Criação de RIP -->
      <div id="container-solicitacao-criacao-rip" style="display: none; margin-bottom: 12px; width: 100%;"></div>

      <!-- Tags visuais dos RIPs associados (removido por redundância) -->
      <div id="listaRIPsAssociados" style="display:none !important; flex-wrap:wrap; gap:8px; margin-bottom:12px; padding:8px 0;"></div>

      <div id="accordion-indicacoes" class="accordion-container">
          <div id="msg-sem-indicacoes" style="text-align: center; padding: 30px; color: #64748b; display:none;">
              <i>Nenhuma indicação cadastrada na Aba 1.</i>
          </div>
      </div>
      <!-- ========== FIM ACCORDION INDICAÇÕES ========== -->


        
            <div id="global-sections-container">
          
          <!-- ==================== OCUPAÇÃO ==================== -->
          <div id="secao-ocupacao">
              <h4 style="margin: 24px 0 16px 0; color: #0056b3; border-bottom: 2px solid #ddd; padding-bottom: 8px;">
                Ocupação
              </h4>

              <!-- Situação ocupacional -->
              <div class="form-group editavel">
                <label>Situação ocupacional:</label>
                <div class="radio-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; align-items: center;">
                  <label class="radio-option">
                    <input type="radio" name="situacao_ocupacional" value="Desocupado" {{ isset($dados['situacao_ocupacional']) && $dados['situacao_ocupacional'] == 'Desocupado' ? 'checked' : '' }} required />
                    Desocupado
                  </label>
                  <label class="radio-option">
                    <input type="radio" name="situacao_ocupacional" value="Ocupado regularmente" {{ isset($dados['situacao_ocupacional']) && $dados['situacao_ocupacional'] == 'Ocupado regularmente' ? 'checked' : '' }} />
                    Ocupado regularmente
                  </label>
                  <label class="radio-option">
                    <input type="radio" name="situacao_ocupacional" value="Ocupado irregularmente" {{ isset($dados['situacao_ocupacional']) && $dados['situacao_ocupacional'] == 'Ocupado irregularmente' ? 'checked' : '' }} />
                    Ocupado irregularmente
                  </label>
                  <label class="radio-option">
                    <input type="radio" name="situacao_ocupacional" value="Não há informação" {{ isset($dados['situacao_ocupacional']) && $dados['situacao_ocupacional'] == 'Não há informação' ? 'checked' : '' }} />
                    Não há informação
                  </label>
                </div>

                <!-- Campos exibidos quando Desocupado -->
                <div id="bloco-desocupado" style="display: none; flex-direction: column; gap: 6px; margin-top: 8px;">
                  <label for="campo-tempo-desocupacao">Tempo de desocupação:</label>
                  <input type="text" id="campo-tempo-desocupacao" name="tempo_desocupacao" placeholder="Ex: 05 anos, desde 03/2010 ou desde 2010" value="{{ $dados['tempo_desocupacao'] ?? '' }}" />

                  <label for="obs-desocupado">Observações:</label>
                  <textarea id="obs-desocupado" name="obs_desocupado" placeholder="Observações sobre a desocupação...">{{ $dados['obs_desocupado'] ?? '' }}</textarea>
                </div>

                <!-- Campos exibidos quando Ocupado regularmente ou Ocupado irregularmente -->
                <div id="bloco-ocupado" style="display: none; flex-direction: column; gap: 6px; margin-top: 8px;">
                  <label for="campo-data-conhecimento-ocupacao">Data de conhecimento da ocupação:</label>
                  <input type="text" id="campo-data-conhecimento-ocupacao" name="data_conhecimento_ocupacao" placeholder="Ex: 03/2010 ou 2010" value="{{ $dados['data_conhecimento_ocupacao'] ?? '' }}" />

                  <label for="obs-ocupado">Observações:</label>
                  <textarea id="obs-ocupado" name="obs_ocupado" placeholder="Informar dados do ocupante e indicar se a ocupação é parcial ou integral.">{{ $dados['obs_ocupado'] ?? '' }}</textarea>
                </div>
              </div>

              <!-- Campos exibidos apenas quando Ocupado regularmente ou Ocupado irregularmente -->
              <div id="bloco-uso-atual" style="display: none; flex-direction: column; gap: 0;">
                <!-- Uso imobiliário atual -->
                <div class="form-group editavel">
                  <label for="campo32">Uso imobiliário atual:</label>
                  <select id="campo32" name="tipo_uso_atual" data-selected="{{ $dados['tipo_uso_atual'] ?? '' }}">
                    <option value="">Selecione...</option>
                    <option value="0101" {{ (isset($dados['tipo_uso_atual']) && $dados['tipo_uso_atual'] == '0101') ? 'selected' : '' }}>01.01 Uso administrativo e representativo</option>
                    <option value="0102" {{ (isset($dados['tipo_uso_atual']) && $dados['tipo_uso_atual'] == '0102') ? 'selected' : '' }}>01.02 Uso para agropecuária, aquicultura, produção florestal e pesca</option>
                    <option value="0103" {{ (isset($dados['tipo_uso_atual']) && $dados['tipo_uso_atual'] == '0103') ? 'selected' : '' }}>01.03 Uso ambiental e dos recursos naturais</option>
                    <option value="0104" {{ (isset($dados['tipo_uso_atual']) && $dados['tipo_uso_atual'] == '0104') ? 'selected' : '' }}>01.04 Uso cultural, esportivo e de lazer</option>
                    <option value="0106" {{ (isset($dados['tipo_uso_atual']) && $dados['tipo_uso_atual'] == '0106') ? 'selected' : '' }}>01.06 Uso habitacional</option>
                    <option value="0111" {{ (isset($dados['tipo_uso_atual']) && $dados['tipo_uso_atual'] == '0111') ? 'selected' : '' }}>01.11 Uso por povos originários e comunidades tradicionais</option>
                  </select>
                </div>

                <!-- Uso específico atual -->
                <div class="form-group editavel">
                  <label for="campo33">Uso específico atual:</label>
                  <select id="campo33" name="tipo_uso_especifico_atual" data-selected="{{ $dados['tipo_uso_especifico_atual'] ?? '' }}" disabled>
                    <option value="">Selecione primeiro o uso imobiliário atual...</option>
                  </select>
                </div>
              </div>
          </div>

          <!-- ==================== INCIDÊNCIA AMBIENTAL ==================== -->
          <div id="secao-incidencia-ambiental">
              <h4 style="margin: 24px 0 16px 0; color: #0056b3; border-bottom: 2px solid #ddd; padding-bottom: 8px;">
                Incidência ambiental
              </h4>

              <div class="form-group editavel">
                <label>Há incidência ambiental identificada?</label>
                <div id="group-pergunta-incidencia" class="checkbox-group" style="display:flex; flex-direction:row; gap:32px; flex-wrap:wrap; margin-bottom:10px; align-items:center;">
                  <label class="checkbox-option" style="display:inline-flex; align-items:center; gap:6px; margin:0;"><input type="checkbox" name="ha_incidencia[]" value="Sim" {{ isset($dados['ha_incidencia']) && in_array('Sim', (array)$dados['ha_incidencia']) ? 'checked' : '' }} /> Sim</label>
                  <label class="checkbox-option" style="display:inline-flex; align-items:center; gap:6px; margin:0;"><input type="checkbox" name="ha_incidencia[]" value="Não" {{ isset($dados['ha_incidencia']) && in_array('Não', (array)$dados['ha_incidencia']) ? 'checked' : '' }} /> Não</label>
                  <label class="checkbox-option" style="display:inline-flex; align-items:center; gap:6px; margin:0;"><input type="checkbox" name="ha_incidencia[]" value="Não há informação suficiente" {{ isset($dados['ha_incidencia']) && in_array('Não há informação suficiente', (array)$dados['ha_incidencia']) ? 'checked' : '' }} /> Não há informação suficiente</label>
                </div>

                <div id="bloco-incidencia-itens" style="display:none;">
                  <label style="margin-top:4px;">Incidências verificadas:</label>
                  <div class="checkbox-group" id="group-incidencia">
                    <label class="checkbox-option">
                      <input type="checkbox" name="incidencia_ambiental[]" value="APP" {{ isset($dados['incidencia_ambiental']) && in_array('APP', (array)$dados['incidencia_ambiental']) ? 'checked' : '' }} />
                      APP — Área de Preservação Permanente
                      <span class="hint-semaforo">
                        <span class="hint-icon" data-hint="Área protegida por legislação específica com restrições severas." data-hint-tipo="vermelho">?</span>
                      </span>
                    </label>
                    <label class="checkbox-option">
                      <input type="checkbox" name="incidencia_ambiental[]" value="Unidade de Conservação" {{ isset($dados['incidencia_ambiental']) && in_array('Unidade de Conservação', (array)$dados['incidencia_ambiental']) ? 'checked' : '' }} />
                      Unidade de Conservação Federal, Estadual ou Municipal
                      <span class="hint-semaforo">
                        <span class="hint-icon" data-hint="Sujeito a regime próprio de proteção." data-hint-tipo="amarelo">?</span>
                      </span>
                    </label>
                    <label class="checkbox-option">
                      <input type="checkbox" name="incidencia_ambiental[]" value="Área de risco" {{ isset($dados['incidencia_ambiental']) && in_array('Área de risco', (array)$dados['incidencia_ambiental']) ? 'checked' : '' }} />
                      Área de risco — geotécnica, inundação, etc.
                    </label>
                    <label class="checkbox-option">
                      <input type="checkbox" name="incidencia_ambiental[]" value="Área contaminada" {{ isset($dados['incidencia_ambiental']) && in_array('Área contaminada', (array)$dados['incidencia_ambiental']) ? 'checked' : '' }} />
                      Área contaminada — passivo ambiental
                    </label>
                    <label class="checkbox-option">
                      <input type="checkbox" name="incidencia_ambiental[]" value="Outra situação ambiental" {{ isset($dados['incidencia_ambiental']) && in_array('Outra situação ambiental', (array)$dados['incidencia_ambiental']) ? 'checked' : '' }} />
                      Outra situação ambiental
                    </label>
                  </div>

                  <div id="bloco-obs-incidencia" style="display: none; flex-direction: column; gap: 6px; margin-top: 8px;">
                    <label for="obs_incidencia_ambiental">Observações sobre incidência ambiental:</label>
                    <textarea id="obs_incidencia_ambiental" name="obs_incidencia_ambiental" placeholder="Descreva informações complementares sobre incidência ambiental...">{{ $dados['obs_incidencia_ambiental'] ?? '' }}</textarea>
                  </div>
                </div>
              </div>
          </div>

          <!-- ==================== RISCOS ==================== -->
          <div id="secao-riscos">
              <h4 style="margin: 24px 0 16px 0; color: #0056b3; border-bottom: 2px solid #ddd; padding-bottom: 8px;">
                Riscos
              </h4>

              <div class="form-group editavel">
                <label>Há riscos identificado?</label>
                <div id="group-pergunta-riscos" class="checkbox-group" style="display:flex; flex-direction:row; gap:32px; flex-wrap:wrap; margin-bottom:10px; align-items:center;">
                  <label class="checkbox-option" style="display:inline-flex; align-items:center; gap:6px; margin:0;"><input type="checkbox" name="ha_riscos[]" value="Sim" {{ isset($dados['ha_riscos']) && in_array('Sim', (array)$dados['ha_riscos']) ? 'checked' : '' }} /> Sim</label>
                  <label class="checkbox-option" style="display:inline-flex; align-items:center; gap:6px; margin:0;"><input type="checkbox" name="ha_riscos[]" value="Não" {{ isset($dados['ha_riscos']) && in_array('Não', (array)$dados['ha_riscos']) ? 'checked' : '' }} /> Não</label>
                  <label class="checkbox-option" style="display:inline-flex; align-items:center; gap:6px; margin:0;"><input type="checkbox" name="ha_riscos[]" value="Não há informação suficiente" {{ isset($dados['ha_riscos']) && in_array('Não há informação suficiente', (array)$dados['ha_riscos']) ? 'checked' : '' }} /> Não há informação suficiente</label>
                </div>

                <div id="bloco-riscos-itens" style="display:none;">
                  <label style="margin-top:4px;">Riscos verificados:</label>
                  <div class="checkbox-group" id="group-riscos">
                      <label class="checkbox-option">
                        <input type="checkbox" name="riscos[]" value="Risco de invasão/esbulho" {{ isset($dados['riscos']) && in_array('Risco de invasão/esbulho', (array)$dados['riscos']) ? 'checked' : '' }} />
                        Risco de invasão/esbulho
                      </label>
                      <label class="checkbox-option">
                        <input type="checkbox" name="riscos[]" value="Risco à segurança/saúde pública" {{ isset($dados['riscos']) && in_array('Risco à segurança/saúde pública', (array)$dados['riscos']) ? 'checked' : '' }} />
                        Risco à segurança/saúde pública
                      </label>
                      <label class="checkbox-option">
                        <input type="checkbox" name="riscos[]" value="Risco estrutural ou de desabamento" {{ isset($dados['riscos']) && in_array('Risco estrutural ou de desabamento', (array)$dados['riscos']) ? 'checked' : '' }} />
                        Risco estrutural ou de desabamento
                      </label>
                      <label class="checkbox-option">
                        <input type="checkbox" name="riscos[]" value="Risco de depredação, vandalismo ou deterioração" {{ isset($dados['riscos']) && in_array('Risco de depredação, vandalismo ou deterioração', (array)$dados['riscos']) ? 'checked' : '' }} />
                        Risco de depredação, vandalismo ou deterioração
                      </label>
                      <label class="checkbox-option">
                        <input type="checkbox" name="riscos[]" value="Outro risco identificado" {{ isset($dados['riscos']) && in_array('Outro risco identificado', (array)$dados['riscos']) ? 'checked' : '' }} />
                        Outro risco identificado
                      </label>
                  </div>

                  <div id="bloco-obs-riscos" style="display: none; flex-direction: column; gap: 6px; margin-top: 8px;">
                    <label for="obs-riscos">Observações sobre riscos:</label>
                    <textarea id="obs-riscos" name="obs_riscos" placeholder="Descreva informações complementares sobre os riscos verificados...">{{ $dados['obs_riscos'] ?? '' }}</textarea>
                  </div>
                </div>
              </div>
          </div>

          <!-- ==================== RESTRIÇÕES ==================== -->
          <div id="secao-restricoes">
              <h4 style="margin: 24px 0 16px 0; color: #0056b3; border-bottom: 2px solid #ddd; padding-bottom: 8px;">
                Condições Específicas do Imóvel
              </h4>

              <div class="form-group editavel">
                <label>Há restrições e condições limitadoras?</label>
                <div id="group-pergunta-restricoes" class="checkbox-group" style="display:flex; flex-direction:row; gap:32px; flex-wrap:wrap; margin-bottom:10px; align-items:center;">
                  <label class="checkbox-option" style="display:inline-flex; align-items:center; gap:6px; margin:0;"><input type="checkbox" name="ha_restricoes[]" value="Sim" {{ isset($dados['ha_restricoes']) && in_array('Sim', (array)$dados['ha_restricoes']) ? 'checked' : '' }} /> Sim</label>
                  <label class="checkbox-option" style="display:inline-flex; align-items:center; gap:6px; margin:0;"><input type="checkbox" name="ha_restricoes[]" value="Não" {{ isset($dados['ha_restricoes']) && in_array('Não', (array)$dados['ha_restricoes']) ? 'checked' : '' }} /> Não</label>
                  <label class="checkbox-option" style="display:inline-flex; align-items:center; gap:6px; margin:0;"><input type="checkbox" name="ha_restricoes[]" value="Não há informação suficiente" {{ isset($dados['ha_restricoes']) && in_array('Não há informação suficiente', (array)$dados['ha_restricoes']) ? 'checked' : '' }} /> Não há informação suficiente</label>
                </div>

                <div id="bloco-restricoes-itens" style="display:none;">
                  <label style="margin-top:4px;">Restrições verificadas:</label>
                  <div class="checkbox-group" id="group-restricoes">
                      <label class="checkbox-option"><input type="checkbox" name="restricoes[]" value="Faixa de fronteira" {{ isset($dados['restricoes']) && in_array('Faixa de fronteira', (array)$dados['restricoes']) ? 'checked' : '' }} /> Faixa de fronteira</label>
                      <label class="checkbox-option"><input type="checkbox" name="restricoes[]" value="Faixa de segurança" {{ isset($dados['restricoes']) && in_array('Faixa de segurança', (array)$dados['restricoes']) ? 'checked' : '' }} /> Faixa de segurança</label>
                      <label class="checkbox-option"><input type="checkbox" name="restricoes[]" value="Faixa de domínio Ferrovia/Rodovia" {{ isset($dados['restricoes']) && in_array('Faixa de domínio Ferrovia/Rodovia', (array)$dados['restricoes']) ? 'checked' : '' }} /> Faixa de domínio Ferrovia/Rodovia</label>
                      <label class="checkbox-option"><input type="checkbox" name="restricoes[]" value="Faixa de 100 metros ao longo da costa marítima" {{ isset($dados['restricoes']) && in_array('Faixa de 100 metros ao longo da costa marítima', (array)$dados['restricoes']) ? 'checked' : '' }} /> Faixa de 100 metros ao longo da costa marítima</label>
                      <label class="checkbox-option"><input type="checkbox" name="restricoes[]" value="Circunferência de 1.320 metros em torno de instalações militares" {{ isset($dados['restricoes']) && in_array('Circunferência de 1.320 metros em torno de instalações militares', (array)$dados['restricoes']) ? 'checked' : '' }} /> Circunferência de 1.320 metros em torno de instalações militares</label>
                      <label class="checkbox-option"><input type="checkbox" name="restricoes[]" value="Terra indígena" {{ isset($dados['restricoes']) && in_array('Terra indígena', (array)$dados['restricoes']) ? 'checked' : '' }} /> Terra indígena</label>
                      <label class="checkbox-option"><input type="checkbox" name="restricoes[]" value="Território quilombola ou área de comunidade tradicional" {{ isset($dados['restricoes']) && in_array('Território quilombola ou área de comunidade tradicional', (array)$dados['restricoes']) ? 'checked' : '' }} /> Território quilombola ou área de comunidade tradicional</label>
                      <label class="checkbox-option"><input type="checkbox" name="restricoes[]" value="Zona/Área de Interesse Social (ZEIS)" {{ isset($dados['restricoes']) && in_array('Zona/Área de Interesse Social (ZEIS)', (array)$dados['restricoes']) ? 'checked' : '' }} /> Zona/Área de Interesse Social — ZEIS</label>
                      <label class="checkbox-option"><input type="checkbox" name="restricoes[]" value="Área de segurança" {{ isset($dados['restricoes']) && in_array('Área de segurança', (array)$dados['restricoes']) ? 'checked' : '' }} /> Área de segurança</label>
                      <label class="checkbox-option"><input type="checkbox" name="restricoes[]" value="Área Non Aedificandi" {{ isset($dados['restricoes']) && in_array('Área Non Aedificandi', (array)$dados['restricoes']) ? 'checked' : '' }} /> Área Non Aedificandi</label>
                      <label class="checkbox-option"><input type="checkbox" name="restricoes[]" value="Restrição de uso/ocupação incidente sobre o imóvel" {{ isset($dados['restricoes']) && in_array('Restrição de uso/ocupação incidente sobre o imóvel', (array)$dados['restricoes']) ? 'checked' : '' }} /> Restrição de uso/ocupação incidente sobre o imóvel</label>
                      <label class="checkbox-option"><input type="checkbox" name="restricoes[]" value="Tombado como patrimônio histórico, artístico e/ou cultural" {{ isset($dados['restricoes']) && in_array('Tombado como patrimônio histórico, artístico e/ou cultural', (array)$dados['restricoes']) ? 'checked' : '' }} /> Tombado como patrimônio histórico, artístico e/ou cultural</label>
                      <label class="checkbox-option"><input type="checkbox" name="restricoes[]" value="Poligonal de Porto Organizado" {{ isset($dados['restricoes']) && in_array('Poligonal de Porto Organizado', (array)$dados['restricoes']) ? 'checked' : '' }} /> Poligonal de Porto Organizado</label>
                      <label class="checkbox-option"><input type="checkbox" name="restricoes[]" value="Área operacional da RFFSA" {{ isset($dados['restricoes']) && in_array('Área operacional da RFFSA', (array)$dados['restricoes']) ? 'checked' : '' }} /> Área operacional da RFFSA</label>
                      <label class="checkbox-option"><input type="checkbox" name="restricoes[]" value="Ilha oceânica ou costeira sem sede de município" {{ isset($dados['restricoes']) && in_array('Ilha oceânica ou costeira sem sede de município', (array)$dados['restricoes']) ? 'checked' : '' }} /> Ilha oceânica ou costeira sem sede de município</label>
                      <label class="checkbox-option"><input type="checkbox" name="restricoes[]" value="Ilha fluvial ou lacustre" {{ isset($dados['restricoes']) && in_array('Ilha fluvial ou lacustre', (array)$dados['restricoes']) ? 'checked' : '' }} /> Ilha fluvial ou lacustre</label>
                      <label class="checkbox-option"><input type="checkbox" name="restricoes[]" value="Localizada em loteamento" {{ isset($dados['restricoes']) && in_array('Localizada em loteamento', (array)$dados['restricoes']) ? 'checked' : '' }} /> Localizada em loteamento</label>
                      <label class="checkbox-option"><input type="checkbox" name="restricoes[]" value="Outra restrição identificada" {{ isset($dados['restricoes']) && in_array('Outra restrição identificada', (array)$dados['restricoes']) ? 'checked' : '' }} /> Outra restrição identificada</label>
                  </div>

                  <div id="bloco-obs-restricoes" style="display: none; flex-direction: column; gap: 6px; margin-top: 16px;">
                    <label for="obs-restricoes">Observações sobre as restrições:</label>
                    <textarea id="obs-restricoes" name="obs_restricoes" placeholder="Descreva informações complementares sobre as restrições verificadas...">{{ $dados['obs_restricoes'] ?? '' }}</textarea>
                  </div>
                </div>
              </div>
          </div>

          <!-- ========== GEOLOCALIZAÇÃO ========== -->
          <div id="secao-geolocalizacao" style="margin-top: 24px; margin-bottom: 24px;">
              <h4 style="margin: 0 0 16px 0; color: #0056b3; border-bottom: 2px solid #ddd; padding-bottom: 8px;">
                Geolocalização
              </h4>
              
              <input type="hidden" id="cep" name="geo_cep" value="{{ $dados['geo_cep'] ?? '' }}">
              <input type="hidden" id="latitude" name="latitude" value="{{ $dados['latitude'] ?? '' }}">
              <input type="hidden" id="longitude" name="longitude" value="{{ $dados['longitude'] ?? '' }}">

              <div class="form-group" style="background: transparent; border: none; padding: 0; display: flex; justify-content: center; margin-top: 15px;">
                  <button type="button" id="btn-open-geo-modal" class="btn-primary" style="padding: 12px 24px; font-size: 1.1em; width: auto; font-weight: bold; background-color: #0284c7; color: white; border: none; border-radius: 6px; cursor: pointer; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                      🗺️ Abrir mapa...
                  </button>
              </div>
          </div>

      </div>

      <!-- MODAL GEO -->
      <div id="geoModal" class="geo-modal-overlay">
          <div class="geo-modal-content">
              <div class="geo-modal-header">
                  <h3>Demarcação Geográfica</h3>
                  <button type="button" class="geo-modal-close" onclick="fecharGeoModal()">×</button>
              </div>
              <div class="geo-modal-body">
                  <div style="display: flex; gap: 10px; margin-bottom: 15px;">
                      <input type="text" id="modal-search-input" placeholder="Buscar endereço ou CEP..." style="flex: 1; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
                      <button type="button" class="btn-secondary" onclick="buscarNoModal()">🔍 Buscar no Mapa</button>
                  </div>
                  <div id="modal-map"></div>
                  <div style="margin-top: 10px; font-size: 0.85em; color: #64748b;">
                      💡 Dica: Utilize as ferramentas de desenho no canto superior direito do mapa para marcar o ponto ou a área exata.
                  </div>
              </div>
              <div class="geo-modal-footer">
                  <button type="button" class="btn-secondary" onclick="fecharGeoModal()">Cancelar</button>
                  <button type="button" class="btn-primary" onclick="salvarGeoModal()">Salvar Coordenadas</button>
              </div>
          </div>
      </div>

      


      

      <!-- Observações e Documentos da Aba 2 (Geral) -->
      <div style="margin-top: 30px; margin-bottom: 20px;">
          <!-- Observações (Geral) -->
          <div class="form-group editavel" style="margin-bottom: 20px;">
              <label style="font-weight: bold; display: block; margin-bottom: 5px; font-size: 0.95em; color: #1e1b4b;">Observações da Caracterização:</label>
              <textarea name="observacoes_aba2" id="observacoes_aba2" rows="4" placeholder="Insira aqui as observações gerais da análise desta aba..." style="width: 100%; border: 1px solid #cbd5e1; padding: 10px; border-radius: 4px; font-size: 0.95em; background: #ffffff; color: #1e293b; resize: vertical;">{{ $dados['observacoes_aba2'] ?? '' }}</textarea>
          </div>

          <!-- Documentos e Links Anexados -->
          <div class="form-group editavel">
              <label style="font-weight: bold; display: block; margin-bottom: 10px; font-size: 0.95em; color: #1e1b4b;">Documentos e Links Anexados</label>
              <div id="documentos-list-aba2" class="documentos-container">
                  <!-- Lista de documentos injetada aqui pelo dinâmico -->
              </div>
              <button type="button" class="btn btn-outline-success btn-sm mt-2" id="btnAdicionarDocAba2">+ Adicionar link/documento</button>
          </div>
      </div>



      <!-- Botões Principais Empilhados -->
      <div style="display: flex; flex-direction: row; justify-content: center; gap: 15px; width: 100%; max-width: 50%; margin: 30px auto 0 auto; border-top: 1px solid #ccc; padding-top: 30px;">
          <button type="button" class="btn-action" style="width: 48%; font-size: 1.2em; padding: 16px; background-color: #64748b; border: none; border-radius: 8px; color: white; cursor: pointer; font-weight: bold; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: all 0.3s ease;" onclick="if(typeof window._saveDraft === 'function') window._saveDraft();">💾 Salvar Rascunho</button>
          <button type="submit" class="btn-action" style="width: 48%; font-size: 1.2em; padding: 16px; background-color: #0284c7; border: none; border-radius: 8px; color: white; cursor: pointer; font-weight: bold; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: all 0.3s ease;">💾 Salvar e Enviar</button>
      </div>

    </form>
    </fieldset>
  </div>

    <!-- Modal Aprovação Aba 2 -->
    <div id="modalAprovacaoAba2" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:4000; align-items:center; justify-content:center;">
        <div style="background:white; padding:30px; border-radius:12px; max-width:1000px; width:95%; box-shadow:0 10px 25px rgba(0,0,0,0.3); text-align:left; position:relative; border-top: 8px solid #28a745; max-height: 90vh; overflow-y: auto;">
            <button id="btnFecharModalAprovacao" style="position:absolute; top:15px; right:15px; background:none; border:none; font-size:24px; cursor:pointer; color:#64748b;">&times;</button>
            <h3 style="color:#1e3a5f; margin-top:0; margin-bottom:15px; font-size:20px; font-weight:700;">Conferência e Aprovação - Aba 2</h3>
            <p style="font-size:0.9em; color:#64748b; margin-bottom:20px;">Por favor, revise o resumo dos dados abaixo e preencha sua manifestação.</p>
            
            <div id="containerRelatorioAprovacao" style="width: 100%; max-height: 400px; border: 1px solid #ccc; border-radius: 4px; overflow-y: auto; margin-bottom: 20px; padding: 20px; background: #fff;">
                <div id="loadingRelatorio" style="text-align: center; padding: 20px; font-weight: bold; color: #1e3a5f;">
                    Carregando resumo dos dados...
                </div>
                <div id="conteudoRelatorioAprovacao" style="display: none;" class="report-container">
                    <!-- O resumo será injetado dinamicamente via JS -->
                </div>
            </div>
            
            <div style="background: #f8fafc; padding: 20px; border-radius: 6px; border-left: 4px solid #1a7a4a; margin-bottom: 20px;">
                <h4 style="margin: 0 0 10px 0; color: #1e3a5f; font-size: 16px;">Declaração</h4>
                <p style="font-size: 14px; color: #334155; line-height: 1.5; margin-bottom: 15px; background: #fff; padding: 10px; border: 1px solid #e2e8f0; border-radius: 4px;">
                    Declaro que as informações consignadas neste formulário foram inseridas com base nos dados disponíveis nos sistemas oficiais, nos documentos constantes do processo e nas verificações realizadas no âmbito desta unidade, estando compatíveis com os elementos analisados.
                </p>
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-weight: bold; color: #1e3a5f; font-size: 15px; margin-bottom: 15px;">
                    <input type="checkbox" id="chkAprovarAba2" style="width: 20px; height: 20px; cursor: pointer;">
                    Estou de acordo e aprovo as informações apresentadas.
                </label>

                <div style="margin-top: 15px;">
                    <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 5px; font-size: 14px;">Observações da Manifestação:</label>
                    <textarea id="txtObservacoesAba2" rows="3" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 4px; font-family: inherit; font-size: 14px; resize: vertical;" placeholder="Registre eventuais ressalvas, condicionantes, inconsistências identificadas ou orientações..."></textarea>
                </div>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button id="btnCancelarAprovacao" style="padding: 10px 20px; background: #e2e8f0; color: #475569; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;">Voltar e Editar</button>
                <button id="btnConfirmarAprovacao" style="padding: 10px 20px; background: #166534; color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;" disabled>✅ Concluir Manifestação</button>
            </div>
        </div>
    </div>

