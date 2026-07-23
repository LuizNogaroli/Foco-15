<link rel="stylesheet" href="{{ asset('css/report.css') }}">
<style>
.acordeao-wrapper {
  margin-top: 16px;
  border: 2px solid #1e3a5f;
  border-radius: 8px;
  overflow: hidden;
}
.acordeao-header {
  display: flex;
  align-items: center;
  justify-content: flex-start;
  padding: 12px 16px;
  background: #1e3a5f;
  cursor: pointer;
  user-select: none;
  gap: 10px;
  transition: background 0.2s;
}
.acordeao-header:hover { background: #2d5282; }
.acordeao-titulo {
  display: flex;
  align-items: center;
  gap: 10px;
  font-weight: bold;
  font-size: 1.1em;
  color: #ffffff;
  flex: 1;
}
.acordeao-badge-ok {
  display: none;
  align-items: center;
  gap: 4px;
  background: #dcfce7;
  color: #16a34a;
  font-size: 0.82em;
  font-weight: 700;
  padding: 2px 9px;
  border-radius: 20px;
  border: 1px solid #86efac;
  white-space: nowrap;
  margin-right: 50px;
}
.acordeao-badge-ok.visivel { display: flex; }
.acordeao-badge-pendente {
  display: flex;
  align-items: center;
  gap: 4px;
  background: #fef3c7;
  color: #92400e;
  font-size: 0.82em;
  font-weight: 700;
  padding: 2px 9px;
  border-radius: 20px;
  border: 1px solid #fde68a;
  white-space: nowrap;
  margin-right: 50px;
}
.acordeao-badge-pendente.oculto { display: none; }
.acordeao-seta { font-size: 0.85em; color: #ffffff; transition: transform 0.25s; flex-shrink: 0; }
.acordeao-wrapper.aberto .acordeao-seta { transform: rotate(180deg); }
.acordeao-corpo { display: none; padding: 20px 20px 24px; background: #fff; border-top: 1px solid #e2e8f0; }
.acordeao-wrapper.aberto .acordeao-corpo { display: block; }
.acordeao-corpo fieldset { border: none; padding: 0; margin: 0; }
.decl-opcao-btns { display: flex; flex-direction: column; gap: 10px; margin: 14px 0 6px; }
.decl-opcao-btns > input[type="radio"] { display: none; }
.decl-opcao-btn-label { display: flex; align-items: flex-start; gap: 12px; padding: 11px 14px; border: none; border-radius: 7px; cursor: pointer; background: #f8fafc; transition: 0.18s; font-size: 0.93em; color: #1e293b; line-height: 1.5; }
.decl-opcao-btn-label:hover { background: #eff6ff; }
.opcao-icone { flex-shrink: 0; width: 20px; height: 20px; border-radius: 50%; border: 2px solid #94a3b8; background: #fff; display: flex; align-items: center; justify-content: center; transition: 0.18s; margin-top: 1px; font-size: 0.75em; color: transparent; }
.decl-opcao-btns > input[type="radio"]:checked + .decl-opcao-btn-label { border-color: #1e3a5f; background: #eff6ff; box-shadow: 0 0 0 3px rgba(30,58,95,0.10); font-weight: 500; }
.decl-opcao-btns > input[type="radio"]:checked + .decl-opcao-btn-label .opcao-icone { border-color: #1e3a5f; background: #1e3a5f; color: #fff; }
.decl-obs-group { margin-top: 16px; }
.decl-obs-group label { display: block; font-size: 0.92em; font-weight: 600; color: #374151; margin-bottom: 5px; }
.decl-obs-group textarea { width: 100%; min-height: 80px; border: none; background: #f1f5f9; border-radius: 5px; padding: 10px; font-size: 0.91em; resize: vertical; color: #1e293b; outline: none; }
.decl-obs-group textarea:focus { box-shadow: 0 0 0 2px #cbd5e1; }
.decl-btn-assinar { margin-top: 20px; display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
.btn-assinar { padding: 8px 22px; background: #1e3a5f; color: #fff; border: none; border-radius: 5px; font-size: 0.93em; font-weight: 600; cursor: pointer; transition: 0.2s; }
.btn-assinar:hover:not(:disabled) { background: #2d5282; }
.btn-assinar:disabled { background: #94a3b8; cursor: not-allowed; }
.btn-devolver { padding: 8px 22px; background: #be123c; color: #fff; border: none; border-radius: 5px; font-size: 0.93em; font-weight: 600; cursor: pointer; transition: 0.2s; }
.btn-devolver:hover:not(:disabled) { background: #9f1239; }
.decl-assinado-overlay { display: none; background: #f0fdf4; border: 1px solid #86efac; border-radius: 5px; padding: 14px 16px; margin-top: 16px; font-size: 0.91em; color: #15803d; line-height: 1.7; }
.decl-assinado-overlay.visivel { display: block; }
.decl-pergunta-inline { display: flex; align-items: center; gap: 16px; flex-wrap: wrap; margin: 8px 0 4px; font-size: 0.94em; color: #1e293b; }
.decl-radio-inline { display: flex; align-items: center; gap: 6px; cursor: pointer; }
.decl-radio-inline input { width: 15px; height: 15px; accent-color: #1e3a5f; }
.decl-radio-group { display: flex; flex-direction: column; gap: 8px; margin: 8px 0 4px; }
.decl-radio-item { display: flex; align-items: flex-start; gap: 10px; font-size: 0.93em; color: #1e293b; cursor: pointer; line-height: 1.5; }
.decl-radio-item input { margin-top: 3px; width: 16px; height: 16px; flex-shrink: 0; accent-color: #1e3a5f; }
.decl-sublabel { font-weight: 600; font-size: 0.92em; color: #1e3a5f; margin: 16px 0 4px; border-bottom: 1px solid #e2e8f0; padding-bottom: 4px; }
.decl-bloco-condicional { display: none; }
.decl-bloco-condicional.visivel { display: block; }
.decl-info-nota { background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 5px; padding: 10px 14px; font-size: 0.88em; color: #1e40af; margin-bottom: 14px; line-height: 1.5; }
.secao-ativa { border: 2px solid #2563eb !important; }
.secao-ativa .acordeao-header { background: #dbeafe !important; color: #1e3a5f !important; }
.secao-ativa .acordeao-titulo { color: #1e3a5f !important; }
.secao-ativa .acordeao-seta { color: #1e3a5f !important; }
iframe.resumo-frame { width: 100%; height: 72vh; min-height: 520px; border: none; display: block; background: #fff; }
.hist-empty { text-align: center; padding: 40px 20px; color: #94a3b8; font-size: 0.95em; }
.decl-origem-stamp {
    background: #f1f5f9;
    border-left: 4px solid #2563eb;
    padding: 10px 14px;
    margin-bottom: 20px;
    font-size: 0.9em;
    color: #0f172a;
    font-weight: 600;
    border-radius: 0 6px 6px 0;
}
.decl-section-title {
    font-weight: 700;
    font-size: 0.98em;
    color: #1e3a5f;
    margin: 20px 0 10px;
    padding-bottom: 6px;
    border-bottom: 1px solid #e2e8f0;
}
</style>

<div class="form-container">
    <h2>Manifestações</h2>

    {{-- INÍCIO DOS RESUMOS DAS ABAS TÉCNICAS --}}
    <div style="margin-bottom: 30px;">
        <div class="acordeao-wrapper">
            <div class="acordeao-header" onclick="this.parentElement.classList.toggle('aberto')">
                <div class="acordeao-titulo">📋 Dados do Requerimento</div>
                <span class="acordeao-seta">▼</span>
            </div>
            <div class="acordeao-corpo" style="padding: 15px; background: #fff;">
                @if(!empty($dados1))
                    <div class="report-container">
                        @include('processos.abas.resumos.aba1a')
                    </div>
                @else
                    <div class="hist-empty">Nenhum dado preenchido para esta etapa.</div>
                @endif
            </div>
        </div>

        <div class="acordeao-wrapper">
            <div class="acordeao-header" onclick="this.parentElement.classList.toggle('aberto')">
                <div class="acordeao-titulo">📋 RIP(s) ou Cadastro(s) Mínimo(s)</div>
                <span class="acordeao-seta">▼</span>
            </div>
            <div class="acordeao-corpo" style="padding: 15px; background: #fff;">
                @if(!empty($dados1))
                    <div class="report-container">
                        @include('processos.abas.resumos.aba1b')
                    </div>
                @else
                    <div class="hist-empty">Nenhum dado preenchido para esta etapa.</div>
                @endif
            </div>
        </div>

        <div class="acordeao-wrapper">
            <div class="acordeao-header" onclick="this.parentElement.classList.toggle('aberto')">
                <div class="acordeao-titulo">📋 Diagnóstico preliminar do imóvel</div>
                <span class="acordeao-seta">▼</span>
            </div>
            <div class="acordeao-corpo" style="padding: 15px; background: #fff;">
                @if(!empty($dados2))
                    <div class="report-container">
                        @include('processos.abas.resumos.aba2')
                    </div>
                @else
                    <div class="hist-empty">Nenhum dado preenchido para esta etapa.</div>
                @endif
            </div>
        </div>

        <div class="acordeao-wrapper">
            <div class="acordeao-header" onclick="this.parentElement.classList.toggle('aberto')">
                <div class="acordeao-titulo">📋 Análise de Viabilidade</div>
                <span class="acordeao-seta">▼</span>
            </div>
            <div class="acordeao-corpo" style="padding: 15px; background: #fff;">
                @if(!empty($dados3))
                    <div class="report-container">
                        @include('processos.abas.resumos.aba3_analise')
                        <hr style="margin: 30px 0; border: 0; border-top: 1px dashed #cbd5e1;">
                        @include('processos.abas.resumos.aba3_proposta')
                    </div>
                @else
                    <div class="hist-empty">Nenhum dado preenchido para esta etapa.</div>
                @endif
            </div>
        </div>
    </div>
    <hr style="margin: 30px 0; border: 0; border-top: 1px solid #e2e8f0;">
    {{-- FIM DOS RESUMOS --}}

    <form method="POST" action="{{ route('processos.tramitar', $processo->id) }}" id="form07">
        @csrf
        <input type="hidden" name="next_aba" value="index">

        @php
            $status = $processo->status_atual;

            // Determinar qual secao esta ativa
            $secoes = [
                'chefia' => ['status' => 'Validação - Chefia', 'perfil' => 'Chefia', 'label' => 'Chefia', 'assinatura' => 'assinatura_chefia'],
                'coordenacao' => ['status' => 'Validação - Coordenação', 'perfil' => 'Coordenação', 'label' => 'Coordenação SPU/UF', 'assinatura' => 'assinatura_coordenacao'],
                'superintendencia' => ['status' => 'Deliberação - Superintendência', 'perfil' => 'Superintendência', 'label' => 'Superintendência', 'assinatura' => 'assinatura_superintendencia'],
                'equipe_cg' => ['status' => 'Validação - Equipe C.G.', 'perfil' => 'Equipe C.G.', 'label' => 'Equipe C.G.', 'assinatura' => 'assinatura_equipe_cg'],
                'coordenacao_geral' => ['status' => 'Validação - Coordenação-Geral', 'perfil' => 'Coordenação-Geral', 'label' => 'Coordenação-Geral', 'assinatura' => 'assinatura_coordenacao_geral'],
                'direcao' => ['status' => 'Validação - Direção', 'perfil' => 'Direção', 'label' => 'Direção', 'assinatura' => 'assinatura_direcao'],
                'cde' => ['status' => 'Deliberação - CDE', 'perfil' => 'CDE', 'label' => 'CDE', 'assinatura' => 'assinatura_cde'],
            ];

            $chaveAtiva = null;
            foreach ($secoes as $chave => $s) {
                if ($s['status'] === $status) {
                    $chaveAtiva = $chave;
                    break;
                }
            }

            // Descobrir o indice da secao ativa para renderizar as concluidas antes
            $ordem = ['chefia', 'coordenacao', 'superintendencia', 'equipe_cg', 'coordenacao_geral', 'direcao', 'cde'];
            $idxAtual = array_search($chaveAtiva, $ordem);
        @endphp

        @php
            function getOrigemTexto($chave, $processo, $dados) {
                if ($chave === 'chefia') {
                    $dataOrigem = $processo->created_at ? date('d/m/Y H:i', strtotime($processo->created_at)) : 'N/A';
                    return "Origem: Análise de Viabilidade (Técnico), em " . $dataOrigem;
                } elseif ($chave === 'coordenacao') {
                    return "Origem: Chefia, em " . ($dados['assinatura_chefia_data'] ?? 'N/A');
                } elseif ($chave === 'superintendencia') {
                    return "Origem: Coordenação de Destinação, em " . ($dados['assinatura_coordenacao_data'] ?? 'N/A');
                } elseif ($chave === 'equipe_cg') {
                    return "Origem: Superintendência, em " . ($dados['assinatura_superintendencia_data'] ?? 'N/A');
                } elseif ($chave === 'coordenacao_geral') {
                    return "Origem: Equipe C.G., em " . ($dados['assinatura_equipe_cg_data'] ?? 'N/A');
                } elseif ($chave === 'direcao') {
                    return "Origem: Coordenação-Geral, em " . ($dados['assinatura_coordenacao_geral_data'] ?? 'N/A');
                } elseif ($chave === 'cde') {
                    return "Origem: Direção, em " . ($dados['assinatura_direcao_data'] ?? 'N/A');
                }
                return "";
            }
        @endphp

        {{-- SECOES JA CONCLUIDAS (anteriores ao status atual) --}}
        @if($idxAtual !== false && $idxAtual > 0)
            @for($i = 0; $i < $idxAtual; $i++)
                @php 
                    $s = $secoes[$ordem[$i]]; 
                    $chaveConc = $ordem[$i]; 
                    $origemTextoConc = getOrigemTexto($chaveConc, $processo, $dados);
                @endphp
                @if(isset($dados[$s['assinatura'] . '_nome']))
                <div class="acordeao-wrapper" style="opacity: 0.6;">
                    <div class="acordeao-header" onclick="this.parentElement.classList.toggle('aberto')">
                        <div class="acordeao-titulo">📋 {{ $s['label'] }}</div>
                        <span class="acordeao-badge-ok visivel">✔ Concluído</span>
                        <span class="acordeao-seta">▼</span>
                    </div>
                    <div class="acordeao-corpo">
                        @if($origemTextoConc)
                        <div class="decl-origem-stamp" style="opacity: 0.8; padding: 6px 14px; margin-bottom: 12px;">
                            {{ $origemTextoConc }}
                        </div>
                        @endif

                        <div class="decl-assinado-overlay visivel" style="display:block;">
                            <strong>✔ Manifestação registrada</strong><br>
                            Assinado por: {{ $dados[$s['assinatura'] . '_nome'] }} em {{ $dados[$s['assinatura'] . '_data'] }}<br>
                            @if($chaveConc === 'superintendencia')
                                Deliberação: {{ ucfirst(str_replace('_', ' ', $dados['sup_deliberacao'] ?? '')) }}<br>
                                @if(($dados['sup_regime_concorda'] ?? '') === 'nao')
                                    Regime sugerido: {{ $dados['sup_regime_novo'] ?? 'Nenhum' }}<br>
                                @endif
                                Observações: {{ $dados['obs_superintendencia'] ?? 'Nenhuma observação' }}
                            @else
                                Parecer: {{ ($dados['decl_'. $chaveConc .'_opcao'] ?? '') == 'suficiente' ? 'Suficiente' : 'Insuficiente' }}<br>
                                Observações: {{ $dados['obs_'. $chaveConc] ?? 'Nenhuma observação' }}
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            @endfor
        @endif

        {{-- SECAO ATIVA --}}
        @foreach($secoes as $chave => $s)
            @if($chave === $chaveAtiva)
            @php $origemTextoAtiva = getOrigemTexto($chave, $processo, $dados); @endphp
            <div class="acordeao-wrapper aberto secao-ativa" id="acordeao-{{ strtoupper(substr($chave, 0, 1)) }}">
                <div class="acordeao-header" onclick="this.parentElement.classList.toggle('aberto')">
                    <div class="acordeao-titulo">📋 {{ $s['label'] }}</div>
                    @if(isset($dados[$s['assinatura'] . '_nome']))
                        <span class="acordeao-badge-ok visivel">✔ Concluído</span>
                    @else
                        <span class="acordeao-badge-pendente">⏳ Pendente</span>
                    @endif
                    <span class="acordeao-seta">▼</span>
                </div>

                <div class="acordeao-corpo">
                    @if(isset($dados[$s['assinatura'] . '_nome']))
                        {{-- JA ASSINADO (CASO OCORRA NA ATIVA, EXCEPCIONAL) --}}
                        <div class="decl-assinado-overlay visivel" style="display:block;">
                            <strong>✔ Manifestação registrada</strong><br>
                            Assinado por: {{ $dados[$s['assinatura'] . '_nome'] }} em {{ $dados[$s['assinatura'] . '_data'] }}
                        </div>
                    @else
                        {{-- PENDENTE - FORMULARIO --}}
                        <fieldset @if($perfil !== 'ALL' && $s['perfil'] !== $perfil) disabled @endif>
                        
                        @if($origemTextoAtiva)
                        <div class="decl-origem-stamp">
                            {{ $origemTextoAtiva }}
                        </div>
                        @endif

                        @if($chave === 'superintendencia')
                            {{-- FORMULARIO DA SUPERINTENDENCIA --}}
                            {{-- Aspectos de Interesse Público --}}
                            <div style="margin-bottom: 20px;">
                                <div class="decl-section-title">Aspectos de Interesse Público</div>
                                <div class="decl-opcao-btns">
                                    <input type="radio" name="sup_interesse" id="sup-int-1" value="consistente" {{ ($dados['sup_interesse'] ?? '') == 'consistente' ? 'checked' : '' }}>
                                    <label class="decl-opcao-btn-label" for="sup-int-1"><span class="opcao-icone">✔</span><span>Evidenciado de forma consistente</span></label>
                                    
                                    <input type="radio" name="sup_interesse" id="sup-int-2" value="ajustes" {{ ($dados['sup_interesse'] ?? '') == 'ajustes' ? 'checked' : '' }}>
                                    <label class="decl-opcao-btn-label" for="sup-int-2"><span class="opcao-icone">✔</span><span>Evidenciado com necessidade de ajustes</span></label>
                                    
                                    <input type="radio" name="sup_interesse" id="sup-int-3" value="insuficiente" {{ ($dados['sup_interesse'] ?? '') == 'insuficiente' ? 'checked' : '' }}>
                                    <label class="decl-opcao-btn-label" for="sup-int-3"><span class="opcao-icone">✔</span><span>Não suficientemente demonstrado</span></label>
                                </div>
                            </div>

                            {{-- Escolha do Destinatário --}}
                            <div style="margin-bottom: 20px;">
                                <div class="decl-section-title">Escolha do Destinatário</div>
                                <div class="decl-opcao-btns">
                                    <input type="radio" name="sup_destinatario" id="sup-dest-1" value="consistente" {{ ($dados['sup_destinatario'] ?? '') == 'consistente' ? 'checked' : '' }}>
                                    <label class="decl-opcao-btn-label" for="sup-dest-1"><span class="opcao-icone">✔</span><span>Fundamentação consistente</span></label>

                                    <input type="radio" name="sup_destinatario" id="sup-dest-2" value="ressalvas" {{ ($dados['sup_destinatario'] ?? '') == 'ressalvas' ? 'checked' : '' }}>
                                    <label class="decl-opcao-btn-label" for="sup-dest-2"><span class="opcao-icone">✔</span><span>Fundamentação suficiente com ressalvas</span></label>

                                    <input type="radio" name="sup_destinatario" id="sup-dest-3" value="insuficiente" {{ ($dados['sup_destinatario'] ?? '') == 'insuficiente' ? 'checked' : '' }}>
                                    <label class="decl-opcao-btn-label" for="sup-dest-3"><span class="opcao-icone">✔</span><span>Fundamentação insuficiente</span></label>
                                </div>
                            </div>

                            {{-- Impactos --}}
                            <div style="margin-bottom: 20px;">
                                <div class="decl-section-title">Impactos sociais, territoriais e ambientais</div>
                                <div class="decl-opcao-btns">
                                    <input type="radio" name="sup_impactos" id="sup-imp-1" value="positivo_relevante" {{ ($dados['sup_impactos'] ?? '') == 'positivo_relevante' ? 'checked' : '' }}>
                                    <label class="decl-opcao-btn-label" for="sup-imp-1"><span class="opcao-icone">✔</span><span>Impacto positivo relevante</span></label>

                                    <input type="radio" name="sup_impactos" id="sup-imp-2" value="positivo_moderado" {{ ($dados['sup_impactos'] ?? '') == 'positivo_moderado' ? 'checked' : '' }}>
                                    <label class="decl-opcao-btn-label" for="sup-imp-2"><span class="opcao-icone">✔</span><span>Impacto positivo moderado</span></label>

                                    <input type="radio" name="sup_impactos" id="sup-imp-3" value="neutro" {{ ($dados['sup_impactos'] ?? '') == 'neutro' ? 'checked' : '' }}>
                                    <label class="decl-opcao-btn-label" for="sup-imp-3"><span class="opcao-icone">✔</span><span>Impacto neutro</span></label>

                                    <input type="radio" name="sup_impactos" id="sup-imp-4" value="adverso" {{ ($dados['sup_impactos'] ?? '') == 'adverso' ? 'checked' : '' }}>
                                    <label class="decl-opcao-btn-label" for="sup-imp-4"><span class="opcao-icone">✔</span><span>Impacto potencialmente adverso</span></label>
                                </div>
                            </div>

                            {{-- Regime de destinação --}}
                            <div style="margin-bottom: 20px;">
                                <div class="decl-section-title">Regime de destinação</div>
                                <div style="background: #e0f2fe; padding: 10px; border-radius: 6px; margin-bottom: 10px; font-size: 13px;">
                                    ℹ Regime proposto pelo analista: <strong>{{ $dados3['regime_destinacao'] ?? 'Não informado' }}</strong>
                                </div>
                                <div class="decl-opcao-btns">
                                    <input type="radio" name="sup_regime_concorda" id="sup-reg-sim" value="sim" {{ ($dados['sup_regime_concorda'] ?? '') == 'sim' ? 'checked' : '' }} onchange="toggleRegimeDropdown()">
                                    <label class="decl-opcao-btn-label" for="sup-reg-sim"><span class="opcao-icone">✔</span><span>Concordo.</span></label>

                                    <input type="radio" name="sup_regime_concorda" id="sup-reg-nao" value="nao" {{ ($dados['sup_regime_concorda'] ?? '') == 'nao' ? 'checked' : '' }} onchange="toggleRegimeDropdown()">
                                    <label class="decl-opcao-btn-label" for="sup-reg-nao"><span class="opcao-icone">✔</span><span>Não concordo.</span></label>
                                </div>
                                
                                <div id="div-regime-sugerido" style="display: {{ ($dados['sup_regime_concorda'] ?? '') == 'nao' ? 'block' : 'none' }}; margin-top: 10px;">
                                    <label class="decl-sublabel">Selecione o regime de destinação desejado:</label>
                                    <select name="sup_regime_novo" class="form-control" style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #cbd5e1;">
                                        <option value="">Selecione...</option>
                                        <option value="Aforamento" {{ ($dados['sup_regime_novo'] ?? '') == 'Aforamento' ? 'selected' : '' }}>Aforamento</option>
                                        <option value="Alienação/Venda" {{ ($dados['sup_regime_novo'] ?? '') == 'Alienação/Venda' ? 'selected' : '' }}>Alienação/Venda</option>
                                        <option value="Cessão de Direito Real de Uso (CDRU)" {{ ($dados['sup_regime_novo'] ?? '') == 'Cessão de Direito Real de Uso (CDRU)' ? 'selected' : '' }}>Cessão de Direito Real de Uso (CDRU)</option>
                                        <option value="Cessão de Uso em Condições Especiais (CUCE)" {{ ($dados['sup_regime_novo'] ?? '') == 'Cessão de Uso em Condições Especiais (CUCE)' ? 'selected' : '' }}>Cessão de Uso em Condições Especiais (CUCE)</option>
                                        <option value="Cessão de Uso Gratuita" {{ ($dados['sup_regime_novo'] ?? '') == 'Cessão de Uso Gratuita' ? 'selected' : '' }}>Cessão de Uso Gratuita</option>
                                        <option value="Cessão de Uso Onerosa" {{ ($dados['sup_regime_novo'] ?? '') == 'Cessão de Uso Onerosa' ? 'selected' : '' }}>Cessão de Uso Onerosa</option>
                                        <option value="Concessão de Direito Real de Uso (CDRU)" {{ ($dados['sup_regime_novo'] ?? '') == 'Concessão de Direito Real de Uso (CDRU)' ? 'selected' : '' }}>Concessão de Direito Real de Uso (CDRU)</option>
                                        <option value="Doação" {{ ($dados['sup_regime_novo'] ?? '') == 'Doação' ? 'selected' : '' }}>Doação</option>
                                        <option value="Entrega" {{ ($dados['sup_regime_novo'] ?? '') == 'Entrega' ? 'selected' : '' }}>Entrega</option>
                                        <option value="Guarda Provisória" {{ ($dados['sup_regime_novo'] ?? '') == 'Guarda Provisória' ? 'selected' : '' }}>Guarda Provisória</option>
                                        <option value="Inscrição de Ocupação" {{ ($dados['sup_regime_novo'] ?? '') == 'Inscrição de Ocupação' ? 'selected' : '' }}>Inscrição de Ocupação</option>
                                        <option value="Permissão de Uso" {{ ($dados['sup_regime_novo'] ?? '') == 'Permissão de Uso' ? 'selected' : '' }}>Permissão de Uso</option>
                                        <option value="Termo de Autorização de Uso (TAU)" {{ ($dados['sup_regime_novo'] ?? '') == 'Termo de Autorização de Uso (TAU)' ? 'selected' : '' }}>Termo de Autorização de Uso (TAU)</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Deliberação --}}
                            <div style="margin-bottom: 20px;">
                                <div class="decl-section-title">Deliberação</div>
                                <div class="decl-opcao-btns">
                                    <input type="radio" name="sup_deliberacao" id="sup-delib-1" value="favoravel" {{ ($dados['sup_deliberacao'] ?? '') == 'favoravel' ? 'checked' : '' }}>
                                    <label class="decl-opcao-btn-label" for="sup-delib-1"><span class="opcao-icone">✔</span><span>Favorável à proposta.</span></label>

                                    <input type="radio" name="sup_deliberacao" id="sup-delib-2" value="favoravel_ressalvas" {{ ($dados['sup_deliberacao'] ?? '') == 'favoravel_ressalvas' ? 'checked' : '' }}>
                                    <label class="decl-opcao-btn-label" for="sup-delib-2"><span class="opcao-icone">✔</span><span>Favorável, com ressalvas.</span></label>

                                    <input type="radio" name="sup_deliberacao" id="sup-delib-3" value="complementacao" {{ ($dados['sup_deliberacao'] ?? '') == 'complementacao' ? 'checked' : '' }}>
                                    <label class="decl-opcao-btn-label" for="sup-delib-3"><span class="opcao-icone">✔</span><span>Necessária complementação de informações/documentos.</span></label>

                                    <input type="radio" name="sup_deliberacao" id="sup-delib-4" value="cancelamento" {{ ($dados['sup_deliberacao'] ?? '') == 'cancelamento' ? 'checked' : '' }}>
                                    <label class="decl-opcao-btn-label" for="sup-delib-4"><span class="opcao-icone">✔</span><span>Cancelamento.</span></label>
                                </div>
                            </div>

                            <div class="decl-obs-group" style="margin-bottom: 20px;">
                                <label for="obs_superintendencia">Observações:</label>
                                <textarea id="obs_superintendencia" name="obs_superintendencia" placeholder="Registre eventuais ressalvas, condicionantes ou orientações. (Obrigatório em caso de Complementação, Cancelamento ou Novo Regime)">{{ $dados['obs_superintendencia'] ?? '' }}</textarea>
                            </div>

                            {{-- Competência --}}
                            <div style="margin-bottom: 20px; border-top: 1px dashed #bae6fd; padding-top: 15px;">
                                <div class="decl-section-title" style="margin-top:0; border-bottom: none;">De quem é a competência para deliberar sobre essa proposta de destinação?</div>
                                <div class="decl-opcao-btns">
                                    <input type="radio" name="sup_competencia" id="sup-comp-1" value="somente_superintendencia" {{ ($dados['sup_competencia'] ?? '') == 'somente_superintendencia' ? 'checked' : '' }}>
                                    <label class="decl-opcao-btn-label" for="sup-comp-1"><span class="opcao-icone">✔</span><span>Superintendência, somente.</span></label>

                                    <input type="radio" name="sup_competencia" id="sup-comp-2" value="precisa_cde" {{ ($dados['sup_competencia'] ?? '') == 'precisa_cde' ? 'checked' : '' }}>
                                    <label class="decl-opcao-btn-label" for="sup-comp-2"><span class="opcao-icone">✔</span><span>Superintendência, mas precisa da deliberação da CDE.</span></label>

                                    <input type="radio" name="sup_competencia" id="sup-comp-3" value="cde" {{ ($dados['sup_competencia'] ?? '') == 'cde' ? 'checked' : '' }}>
                                    <label class="decl-opcao-btn-label" for="sup-comp-3"><span class="opcao-icone">✔</span><span>CDE</span></label>
                                </div>
                            </div>

                        @elseif($chave === 'cde')
                            {{-- FORMULARIO DA CDE --}}
                            
                            {{-- Aspectos de Interesse Público --}}
                            <div style="margin-bottom: 20px;">
                                <div class="decl-section-title">Aspectos de Interesse Público</div>
                                <div class="decl-opcao-btns">
                                    <input type="radio" name="cde_interesse" id="cde-int-1" value="consistente" {{ ($dados['cde_interesse'] ?? '') == 'consistente' ? 'checked' : '' }}>
                                    <label class="decl-opcao-btn-label" for="cde-int-1"><span class="opcao-icone">✔</span><span>Evidenciado de forma consistente</span></label>
                                    
                                    <input type="radio" name="cde_interesse" id="cde-int-2" value="insuficiente" {{ ($dados['cde_interesse'] ?? '') == 'insuficiente' ? 'checked' : '' }}>
                                    <label class="decl-opcao-btn-label" for="cde-int-2"><span class="opcao-icone">✔</span><span>Não suficientemente demonstrado</span></label>
                                </div>
                            </div>

                            {{-- Escolha do Destinatário --}}
                            <div style="margin-bottom: 20px;">
                                <div class="decl-section-title">Escolha do Destinatário</div>
                                <div class="decl-opcao-btns">
                                    <input type="radio" name="cde_destinatario" id="cde-dest-1" value="consistente" {{ ($dados['cde_destinatario'] ?? '') == 'consistente' ? 'checked' : '' }}>
                                    <label class="decl-opcao-btn-label" for="cde-dest-1"><span class="opcao-icone">✔</span><span>Fundamentação consistente</span></label>

                                    <input type="radio" name="cde_destinatario" id="cde-dest-2" value="insuficiente" {{ ($dados['cde_destinatario'] ?? '') == 'insuficiente' ? 'checked' : '' }}>
                                    <label class="decl-opcao-btn-label" for="cde-dest-2"><span class="opcao-icone">✔</span><span>Fundamentação insuficiente</span></label>
                                </div>
                            </div>

                            {{-- Regime de Destinação --}}
                            <div style="margin-bottom: 20px;">
                                <div class="decl-section-title">Regime de Destinação</div>
                                <div style="background: #e0f2fe; padding: 10px; border-radius: 6px; margin-bottom: 10px; font-size: 13px;">
                                    ℹ Regime proposto pelo analista: <strong>{{ $dados3['regime_destinacao'] ?? 'Não informado' }}</strong>
                                </div>
                                <div class="decl-opcao-btns">
                                    <input type="radio" name="cde_regime" id="cde-reg-1" value="manter" {{ ($dados['cde_regime'] ?? '') == 'manter' ? 'checked' : '' }}>
                                    <label class="decl-opcao-btn-label" for="cde-reg-1"><span class="opcao-icone">✔</span><span>Manter regime proposto</span></label>

                                    <input type="radio" name="cde_regime" id="cde-reg-2" value="alterar" {{ ($dados['cde_regime'] ?? '') == 'alterar' ? 'checked' : '' }}>
                                    <label class="decl-opcao-btn-label" for="cde-reg-2"><span class="opcao-icone">✔</span><span>Alterar regime</span></label>
                                </div>
                            </div>

                            {{-- Deliberação Final --}}
                            <div style="margin-bottom: 20px;">
                                <div class="decl-section-title">Deliberação Final</div>
                                <div class="decl-opcao-btns">
                                    <input type="radio" name="cde_deliberacao" id="cde-delib-1" value="aprovar" {{ ($dados['cde_deliberacao'] ?? '') == 'aprovar' ? 'checked' : '' }}>
                                    <label class="decl-opcao-btn-label" for="cde-delib-1"><span class="opcao-icone">✔</span><span>Aprovar a proposta, nos termos apresentados.</span></label>

                                    <input type="radio" name="cde_deliberacao" id="cde-delib-2" value="indeferir" {{ ($dados['cde_deliberacao'] ?? '') == 'indeferir' ? 'checked' : '' }}>
                                    <label class="decl-opcao-btn-label" for="cde-delib-2"><span class="opcao-icone">✔</span><span>Indeferir a proposta.</span></label>
                                </div>
                            </div>

                            {{-- Competência --}}
                            <div style="margin-bottom: 20px;">
                                <div class="decl-section-title">Processo de competência da Superintendência ou da CDE?</div>
                                <div class="decl-opcao-btns">
                                    <input type="radio" name="competencia_cde" id="cde-comp-1" value="superintendencia" {{ ($dados['competencia_cde'] ?? '') == 'superintendencia' ? 'checked' : '' }}>
                                    <label class="decl-opcao-btn-label" for="cde-comp-1"><span class="opcao-icone">✔</span><span>Competência da Superintendência</span></label>

                                    <input type="radio" name="competencia_cde" id="cde-comp-2" value="cde" {{ ($dados['competencia_cde'] ?? '') == 'cde' ? 'checked' : '' }}>
                                    <label class="decl-opcao-btn-label" for="cde-comp-2"><span class="opcao-icone">✔</span><span>Competência da CDE</span></label>
                                </div>
                            </div>

                            <div class="decl-obs-group" style="margin-bottom: 20px;">
                                <label for="obs_cde">Observações/Condicionantes:</label>
                                <textarea id="obs_cde" name="obs_cde" placeholder="Descreva as condicionantes ou ressalvas...">{{ $dados['obs_cde'] ?? '' }}</textarea>
                            </div>

                        @else
                            {{-- FORMULARIO PADRAO (Chefia, Coordenação, Equipe CG, Direção, etc) --}}
                            <div class="decl-section-title" style="margin-top:0; border-bottom: none;">
                                {{ $chave === 'equipe_cg' ? 'Conferência da deliberação da Superintendência' : 'Parecer sobre a viabilidade' }}
                            </div>
                            <div class="decl-opcao-btns">
                                <input type="radio" name="decl_{{ $chave }}_opcao" id="decl-{{ $chave }}-radio1" value="suficiente" {{ ($dados['decl_'. $chave .'_opcao'] ?? '') == 'suficiente' ? 'checked' : '' }}>
                                <label class="decl-opcao-btn-label" for="decl-{{ $chave }}-radio1">
                                    <span class="opcao-icone">✔</span>
                                    <span>Os elementos constantes do formulário são <strong>suficientes</strong> para apreciação dos aspectos de mérito da destinação proposta.</span>
                                </label>

                                <input type="radio" name="decl_{{ $chave }}_opcao" id="decl-{{ $chave }}-radio2" value="insuficiente" {{ ($dados['decl_'. $chave .'_opcao'] ?? '') == 'insuficiente' ? 'checked' : '' }}>
                                <label class="decl-opcao-btn-label" for="decl-{{ $chave }}-radio2">
                                    <span class="opcao-icone">✔</span>
                                    <span><strong>NÃO</strong> há elementos suficientes para apreciação dos aspectos de mérito da destinação proposta, sendo necessária a complementação das informações.</span>
                                </label>
                            </div>

                            <div class="decl-obs-group">
                                <label for="obs-{{ $chave }}">Observações:</label>
                                <textarea id="obs-{{ $chave }}" name="obs_{{ $chave }}" placeholder="Observações adicionais...">{{ $dados['obs_'. $chave] ?? '' }}</textarea>
                            </div>
                        @endif

                        </fieldset>

                        <div class="decl-btn-assinar" style="justify-content: flex-end;">
                            @if($perfil === 'ALL' || $perfil === $s['perfil'])
                                <button type="submit" name="acao_aba7_rascunho" value="{{ $chave }}" class="btn-inst btn-inst-outline" style="padding: 8px 22px; font-weight: 600;">💾 Salvar Rascunho</button>
                                <button type="submit" name="acao_aba7" value="{{ $chave }}" class="btn-assinar" style="padding: 8px 22px; font-weight: 600;">📤 Salvar e Enviar</button>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
            @endif
        @endforeach



    </form>
</div>

<script>
function toggleRegimeDropdown() {
    const radioNao = document.querySelector('input[name="sup_regime_concorda"][value="nao"]');
    const divSugerido = document.getElementById('div-regime-sugerido');
    if (radioNao && divSugerido) {
        divSugerido.style.display = radioNao.checked ? 'block' : 'none';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const form07 = document.getElementById('form07');
    if (!form07) return;

    form07.addEventListener('submit', function(e) {
        const form = e.target;
        if (!form.checkValidity()) {
            e.preventDefault();
            form.reportValidity();
        }
    });
});
</script>
