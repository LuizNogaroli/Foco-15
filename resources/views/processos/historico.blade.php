<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico - {{ $processo->numero_requerimento }}</title>
    <link rel="stylesheet" href="{{ asset('css/styles-forms.css') }}">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f1f5f9; color: #1e293b; }

        .hist-container { max-width: 900px; margin: 40px auto; padding: 0 20px; }
        .hist-header { text-align: center; margin-bottom: 30px; }
        .hist-header h1 { font-size: 1.5rem; color: #1e3a5f; font-weight: 700; margin-bottom: 4px; }
        .hist-header .hist-sub { font-size: 0.95rem; color: #64748b; }
        .hist-header .hist-back { display: inline-block; margin-top: 14px; padding: 8px 20px; background: #1e3a5f; color: #fff; border-radius: 6px; text-decoration: none; font-size: 0.88rem; font-weight: 600; transition: background 0.2s; }
        .hist-header .hist-back:hover { background: #2d5282; }

        .hist-section { background: #fff; border-radius: 8px; margin-bottom: 16px; overflow: hidden; box-shadow: 0 1px 4px rgba(0,0,0,0.06); }
        .hist-section-header { display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; background: #1e3a5f; color: #fff; cursor: pointer; user-select: none; font-weight: 600; font-size: 1em; }
        .hist-section-header:hover { background: #2d5282; }
        .hist-section-header .hist-badge { font-size: 0.78em; padding: 2px 10px; border-radius: 20px; font-weight: 700; }
        .hist-badge-ok { background: #dcfce7; color: #16a34a; }
        .hist-badge-vazio { background: #f1f5f9; color: #94a3b8; }
        .hist-section-header .hist-seta { transition: transform 0.25s; font-size: 0.85em; }
        .hist-section.aberto .hist-seta { transform: rotate(180deg); }
        .hist-section-body { display: none; padding: 0; }
        .hist-section.aberto .hist-section-body { display: block; }

        .hist-stamps { padding: 20px; }
        .hist-stamp-card { background: #f0fdf4; border: 1px solid #86efac; border-left: 4px solid #16a34a; border-radius: 6px; padding: 12px 16px; margin-bottom: 10px; }
        .hist-stamp-card .stamp-label { font-weight: 700; color: #15803d; font-size: 0.92em; margin-bottom: 2px; }
        .hist-stamp-card .stamp-detail { font-size: 0.88em; color: #374151; }
        .hist-stamp-pendente { background: #f8fafc; border: 1px solid #e2e8f0; border-left: 4px solid #94a3b8; border-radius: 6px; padding: 12px 16px; margin-bottom: 10px; }
        .hist-stamp-pendente .stamp-label { font-weight: 600; color: #64748b; font-size: 0.92em; }

        .hist-empty { text-align: center; padding: 40px 20px; color: #94a3b8; font-size: 0.95em; }

        iframe.resumo-frame { width: 100%; height: 72vh; min-height: 520px; border: none; display: block; background: #fff; }
    </style>
</head>
<body>
    <div class="hist-container">
        <div class="hist-header">
            <h1>Histórico de Movimentações</h1>
            <div class="hist-sub">Requerimento nº {{ $processo->numero_requerimento }} &mdash; {{ $processo->status_atual }}</div>
            <a href="{{ url()->previous() }}" class="hist-back">← Voltar ao Painel</a>
        </div>

        {{-- ABA 1a --}}
        <div class="hist-section aberto">
            <div class="hist-section-header" onclick="this.parentElement.classList.toggle('aberto')">
                <span>📋 Dados do Requerimento (Aba 1a)</span>
                @if(!empty($dados1))
                    <span class="hist-badge hist-badge-ok">✔ Preenchido</span>
                @else
                    <span class="hist-badge hist-badge-vazio">Sem dados</span>
                @endif
                <span class="hist-seta">▼</span>
            </div>
            <div class="hist-section-body">
                @if(!empty($dados1))
                    <iframe src="{{ asset('foco-01a-resumo.html') }}?v={{ time() }}" class="resumo-frame" title="Resumo - Dados do Requerimento"></iframe>
                @else
                    <div class="hist-empty">Nenhum dado preenchido para esta etapa.</div>
                @endif
            </div>
        </div>

        {{-- ABA 1b --}}
        <div class="hist-section aberto">
            <div class="hist-section-header" onclick="this.parentElement.classList.toggle('aberto')">
                <span>📍 Indicação do Imóvel (Aba 1b)</span>
                @if(!empty($dados1))
                    <span class="hist-badge hist-badge-ok">✔ Preenchido</span>
                @else
                    <span class="hist-badge hist-badge-vazio">Sem dados</span>
                @endif
                <span class="hist-seta">▼</span>
            </div>
            <div class="hist-section-body">
                @if(!empty($dados1))
                    <iframe src="{{ asset('foco-01b-resumo.html') }}?v={{ time() }}" class="resumo-frame" title="Resumo - Indicação do Imóvel"></iframe>
                @else
                    <div class="hist-empty">Nenhum dado preenchido para esta etapa.</div>
                @endif
            </div>
        </div>

        {{-- ABA 2 --}}
        <div class="hist-section">
            <div class="hist-section-header" onclick="this.parentElement.classList.toggle('aberto')">
                <span>📋 Diagnóstico Preliminar do Imóvel</span>
                @if(!empty($dados2))
                    <span class="hist-badge hist-badge-ok">✔ Preenchido</span>
                @else
                    <span class="hist-badge hist-badge-vazio">Sem dados</span>
                @endif
                <span class="hist-seta">▼</span>
            </div>
            <div class="hist-section-body">
                @if(!empty($dados2))
                    <iframe src="{{ asset('foco-02-resumo.html') }}" class="resumo-frame" title="Resumo - Diagnóstico Preliminar"></iframe>
                @else
                    <div class="hist-empty">Nenhum dado preenchido para esta etapa.</div>
                @endif
            </div>
        </div>

        {{-- ABA 3 --}}
        <div class="hist-section">
            <div class="hist-section-header" onclick="this.parentElement.classList.toggle('aberto')">
                <span>📋 Análise de Viabilidade e Proposta de Destinação</span>
                @if(!empty($dados3))
                    <span class="hist-badge hist-badge-ok">✔ Preenchido</span>
                @else
                    <span class="hist-badge hist-badge-vazio">Sem dados</span>
                @endif
                <span class="hist-seta">▼</span>
            </div>
            <div class="hist-section-body">
                @if(!empty($dados3))
                    <div class="hist-stamps">
                        @if(!empty($dados3['observacoes_aba3']))
                            <div style="margin-bottom: 12px;">
                                <strong style="color:#1e3a5f; font-size:0.9em;">Observações:</strong>
                                <p style="font-size:0.9em; color:#374151; margin-top:4px; white-space: pre-wrap;">{{ $dados3['observacoes_aba3'] }}</p>
                            </div>
                        @endif
                        <div style="font-size:0.9em; color:#64748b;">Dados da Análise de Viabilidade salvos no sistema.</div>
                    </div>
                @else
                    <div class="hist-empty">Nenhum dado preenchido para esta etapa.</div>
                @endif
            </div>
        </div>

        {{-- RIPs / Cadastros --}}
        <div class="hist-section">
            <div class="hist-section-header" onclick="this.parentElement.classList.toggle('aberto')">
                <span>📋 RIP(s) / Cadastro(s) Mínimo(s)</span>
                @if(!empty($rips) || !empty($cadastros))
                    <span class="hist-badge hist-badge-ok">{{ count($rips) + count($cadastros) }} registro(s)</span>
                @else
                    <span class="hist-badge hist-badge-vazio">Nenhum</span>
                @endif
                <span class="hist-seta">▼</span>
            </div>
            <div class="hist-section-body">
                @if(!empty($rips) || !empty($cadastros))
                    <div class="hist-stamps" id="rips-historico-container">
                        @foreach($rips as $rip)
                            <div style="padding: 8px 12px; background:#f8fafc; border:1px solid #e2e8f0; border-radius:5px; margin-bottom:6px; font-size:0.9em;">
                                <strong>RIP:</strong> {{ $rip }}
                            </div>
                        @endforeach
                        @foreach($cadastros as $cad)
                            <div style="padding: 8px 12px; background:#f0fdf4; border:1px solid #86efac; border-radius:5px; margin-bottom:6px; font-size:0.9em;">
                                <strong>Cadastro Mínimo:</strong> {{ $cad['logradouro'] ?? '' }}, {{ $cad['numero'] ?? '' }} - {{ $cad['municipio'] ?? '' }}/{{ $cad['uf'] ?? '' }}
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="hist-empty">Nenhum RIP ou Cadastro Mínimo vinculado.</div>
                @endif
            </div>
        </div>

        {{-- MANIFESTAÇÕES (Chefia e acima) --}}
        @php
            $secoesManifestacoes = [
                'chefia' => ['label' => 'Chefia da Área de Destinação', 'assinatura' => 'assinatura_chefia'],
                'coordenacao' => ['label' => 'Coordenação SPU/UF', 'assinatura' => 'assinatura_coordenacao'],
                'superintendencia' => ['label' => 'Superintendência', 'assinatura' => 'assinatura_superintendencia'],
                'equipe_cg' => ['label' => 'Equipe C.G.', 'assinatura' => 'assinatura_equipe_cg'],
                'coordenacao_geral' => ['label' => 'Coordenação-Geral', 'assinatura' => 'assinatura_coordenacao_geral'],
                'direcao' => ['label' => 'Direção', 'assinatura' => 'assinatura_direcao'],
                'cde' => ['label' => 'CDE', 'assinatura' => 'assinatura_cde'],
            ];
            $temManifestacoes = false;
            foreach ($secoesManifestacoes as $s) {
                if (isset($dados3[$s['assinatura'] . '_nome'])) {
                    $temManifestacoes = true;
                    break;
                }
            }
        @endphp
        <div class="hist-section">
            <div class="hist-section-header" onclick="this.parentElement.classList.toggle('aberto')">
                <span>✍️ Manifestações</span>
                @if($temManifestacoes)
                    <span class="hist-badge hist-badge-ok">✔ Registradas</span>
                @else
                    <span class="hist-badge hist-badge-vazio">Nenhuma</span>
                @endif
                <span class="hist-seta">▼</span>
            </div>
            <div class="hist-section-body">
                <div class="hist-stamps">
                    @php $count = 0; @endphp
                    @foreach($secoesManifestacoes as $chave => $s)
                        @if(isset($dados3[$s['assinatura'] . '_nome']))
                            @php $count++; @endphp
                            <div class="hist-stamp-card">
                                <div class="stamp-label">✔ {{ $s['label'] }}</div>
                                <div class="stamp-detail">
                                    Assinado por: <strong>{{ $dados3[$s['assinatura'] . '_nome'] }}</strong>
                                    em {{ $dados3[$s['assinatura'] . '_data'] }}
                                    @if(!empty($dados3['decl_' . strtoupper(substr($chave, 0, 1)) . '_opcao']))
                                        &mdash; Decisão: <strong>{{ $dados3['decl_' . strtoupper(substr($chave, 0, 1)) . '_opcao'] == 'suficiente' ? 'Aprovado' : 'Insuficiente' }}</strong>
                                    @endif
                                </div>
                                @if(!empty($dados3['obs_' . $chave]))
                                    <div style="margin-top:6px; font-size:0.87em; color:#374151; font-style:italic;">
                                        Observações: {{ $dados3['obs_' . $chave] }}
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="hist-stamp-pendente">
                                <div class="stamp-label">⏳ {{ $s['label'] }} — Pendente</div>
                            </div>
                        @endif
                    @endforeach
                    @if($count === 0)
                        <div class="hist-empty">Nenhuma manifestação registrada até o momento.</div>
                    @endif
                </div>
            </div>
        </div>

    </div>

    <script>
        const ProcessoID = {{ $processo->id }};
    </script>
</body>
</html>
