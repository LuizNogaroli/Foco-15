<script>
    window.INLINE_RIPS = @json($processo->foco && $processo->foco->rips ? $processo->foco->rips->pluck('numero_rip')->toArray() : []);
    window.INLINE_CADASTROS = @json($processo->foco && $processo->foco->cadastrosMinimos ? $processo->foco->cadastrosMinimos->toArray() : []);
</script>
<style>
    /* ═══ Paleta institucional Aba 1 ═══ */
    :root {
        --aba1-navy: #1e3a5f;
        --aba1-navy-strong: #12395b;
        --aba1-navy-hover: #17375a;
        --aba1-border: transparent;
        --aba1-muted: #64748b;
        --aba1-field-bg: #f8fafc;
    }

    .accordion-container { display: flex; flex-direction: column; gap: 15px; margin-bottom: 25px; }
    .accordion-item { border: none !important; border-radius: 10px; overflow: hidden; background: #fff; box-shadow: 0 2px 8px rgba(15,23,42,0.06); }
    fieldset { border: none !important; }
    .accordion-header { padding: 15px 20px; cursor: pointer; display: flex; justify-content: space-between; align-items: center; font-weight: 600; font-size: 1.02rem; letter-spacing: 0.01em; transition: background 0.2s; }
    .accordion-header:hover { filter: brightness(0.96); }
    .accordion-body { display: block; padding: 22px; border-top: none; }
    .accordion-body.collapsed { display: none; }
    .accordion-icon { font-size: 0.85rem; transition: transform 0.3s; color: #fff !important; }
    .active .accordion-icon { transform: rotate(180deg); }
    .accordion-header .accordion-title { display: inline-flex; align-items: center; gap: 10px; }
    .accordion-header .accordion-title svg { flex: 0 0 auto; }

    body { font-family: 'Segoe UI', Arial, sans-serif !important; line-height: 1.5 !important; color: #333 !important; background-color: #f1f5f9 !important; margin: 0 !important; padding: 0 !important; display: block !important; overflow-y: scroll !important; }

    /* ═══ Cabeçalho do documento ═══ */
    .doc-heading { text-align: center; margin-bottom: 28px; padding-bottom: 20px; border-bottom: 1px solid var(--aba1-border); }
    .doc-heading .doc-eyebrow { font-size: 0.78rem; letter-spacing: 0.12em; text-transform: uppercase; color: var(--aba1-muted); font-weight: 700; margin-bottom: 6px; }
    .doc-heading .doc-numero { font-size: 1.6rem; color: var(--aba1-navy); font-weight: 700; margin: 0; letter-spacing: 0.01em; word-wrap: break-word; overflow-wrap: break-word; }

    /* ═══ Campos readonly (dados do portal) ═══ */
    .form-group.inline > input[readonly] {
        background-color: var(--aba1-field-bg);
        border: 1px solid var(--aba1-border) !important;
        border-radius: 6px;
        padding: 8px 12px !important;
        color: #1e293b;
        font-weight: 500;
        cursor: default;
    }
    .form-group.inline > input[readonly]:focus { box-shadow: none; border-color: var(--aba1-border) !important; }

    /* ═══ Subtítulos de seção ═══ */
    .aba1-subsection { margin: 26px 0 16px 0; color: var(--aba1-navy); font-size: 1.02rem; font-weight: 700; border-bottom: 2px solid var(--aba1-border); padding-bottom: 8px; letter-spacing: 0.01em; }

    /* ═══ Botões institucionais ═══ */
    .btn-inst { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; font-size: 0.95rem; font-weight: 600; letter-spacing: 0.01em; transition: background 0.2s, transform 0.15s, box-shadow 0.2s; }
    .btn-inst svg { flex: 0 0 auto; }
    .btn-inst-primary { background: var(--aba1-navy); color: #fff; box-shadow: 0 2px 6px rgba(30,58,95,0.18); }
    .btn-inst-primary:hover { background: var(--aba1-navy-hover); transform: translateY(-1px); box-shadow: 0 4px 10px rgba(30,58,95,0.24); }
    .btn-inst-outline { background: #fff; color: var(--aba1-navy); border: 1px solid var(--aba1-navy); }
    .btn-inst-outline:hover { background: #eef4fb; }
    .btn-inst-success { background: #15803d; color: #fff; box-shadow: 0 2px 6px rgba(21,128,61,0.18); }
    .btn-inst-success:hover { background: #166534; transform: translateY(-1px); }
</style>

<div class="form-container">
        <div class="doc-heading">
            <div id="label-titulo-requerimento" class="doc-eyebrow">Requerimento</div>
            <h2 id="titulo-pagina-requerimento" class="doc-numero">{{ $requerimento->tipo_requerimento ?? $processo->tipo_requerimento }}</h2>
        </div>
    
    <fieldset>
    <form method="POST" action="{{ route('processos.tramitar', $processo->id) }}" id="form01">
        @csrf
        <input type="hidden" name="next_aba" value="index">
        <input type="hidden" name="aba_atual" value="1">
        
        <div class="accordion-container" style="margin-bottom: 25px;">
            <!-- Dados do Requerimento -->
            <div class="accordion-item" style="border: none;">
                <div class="accordion-header" style="background-color: #1e3a5f; color: white;" onclick="toggleAccordion(this)">
                    <span class="accordion-title">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><line x1="10" y1="9" x2="8" y2="9"/></svg>
                        <span>Dados do Requerimento</span>
                    </span>
                    <span class="accordion-icon">▼</span>
                </div>
                <div class="accordion-body collapsed" style="padding: 15px;">
                    <div class="form-group inline">
                        <label>Número do requerimento:</label>
                        <input type="text" id="campo11" name="numero_requerimento" value="{{ $requerimento->numero_requerimento ?? $processo->numero_requerimento }}" readonly>
                    </div>
                    <div class="form-group inline">
                        <label>Tipo de requerimento:</label>
                        <input type="text" id="tipo_requerimento" name="tipo_requerimento" value="{{ $requerimento->tipo_requerimento ?? $processo->tipo_requerimento }}" readonly>
                    </div>
                    <div class="form-group inline">
                        <label>Data de Requerimento:</label>
                        <input type="text" id="campo12" name="data_requerimento" value="{{ $requerimento->data_hora_recebimento ?? $processo->created_at->format('d/m/Y') }}" readonly>
                    </div>
                    <div class="form-group inline">
                        <label>Número do processo SEI:</label>
                        <input type="text" id="campo13" name="processo_sei" class="mask-sei" maxlength="20" value="{{ $requerimento->nup_sei ?? '' }}" readonly placeholder="00000.000000/0000-00">
                    </div>
                    <div class="form-group inline">
                        <label>CPF/CNPJ:</label>
                        <input type="text" id="campo14" name="cpf_cnpj_requerente" class="mask-cpf-cnpj" maxlength="18" value="{{ $requerimento->cpf_cnpj_requerente ?? '' }}" readonly>
                    </div>
                    <div class="form-group inline">
                        <label>Nome do requerente:</label>
                        <input type="text" id="campo15" name="nome_requerente" value="{{ $requerimento->nome_requerente ?? '' }}" readonly>
                    </div>
                    <div class="form-group inline">
                        <label>Telefone celular:</label>
                        <input type="text" id="campo19" name="telefone_requerente" placeholder="(99) 99999-9999" maxlength="15" value="{{ $requerimento->contato_requerente ?? '' }}" readonly>
                    </div>

                    <h4 class="aba1-subsection">Dados do Representante Legal</h4>
                    <div class="form-group inline">
                        <label>CPF/CNPJ do representante:</label>
                        <input type="text" id="campo14_rep" name="cpf_cnpj_representante" class="mask-cpf-cnpj" maxlength="18" value="{{ $requerimento->cpf_cnpj_representante ?? '' }}" readonly placeholder="Opcional">
                    </div>
                    <div class="form-group inline">
                        <label>Nome do representante:</label>
                        <input type="text" id="campo15_rep" name="nome_representante" value="{{ $requerimento->nome_representante ?? '' }}" readonly placeholder="Opcional">
                    </div>
                    <div class="form-group inline">
                        <label>Telefone celular do representante:</label>
                        <input type="text" id="campo19_rep" name="telefone_representante" placeholder="(99) 99999-9999" maxlength="15" value="{{ $requerimento->contato_representante ?? '' }}" readonly>
                    </div>

                    <h4 class="aba1-subsection">Informações Adicionais</h4>
                    <div class="form-group inline">
                        <label>Pessoa estrangeira:</label>
                        <input type="text" id="campo17" name="is_estrangeiro" value="{{ $dados['is_estrangeiro'] ?? 'Não' }}" readonly style="background: transparent; border: none;">
                    </div>
                    <div class="form-group inline">
                        <label>Prioridade Legal:</label>
                        <input type="text" id="prioridade_legal" name="prioridade_legal" value="{{ $requerimento->prioridade_legal ?? 'Não se aplica' }}" readonly style="color: #ea580c; font-weight: bold; background: transparent; border: none;">
                    </div>

                    <!-- 1.11 Documentos anexados ao requerimento -->
                    <section class="documentos-linkados-section" aria-labelledby="titulo-documentos-linkados" style="margin-top: 25px;">
                        <details class="documentos-expansivel" open>
                            <summary class="documentos-expansivel-header" style="cursor: pointer; padding: 14px 18px; background: #1e3a5f; border: 1px solid #17375a; border-radius: 8px; display: flex; justify-content: space-between; align-items: center;">
                                <span id="titulo-documentos-linkados" style="font-weight: 600; color: #ffffff; display: inline-flex; align-items: center; gap: 10px;">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                                    Documentos anexados ao requerimento
                                </span>
                                <span class="documentos-linkados-badge" style="background: #dbeafe; padding: 4px 10px; border-radius: 999px; font-size: 11px; font-weight: 700; color: #12395b; border: 1px solid #93c5fd;">Documentos Digitais</span>
                            </summary>

                            <div class="documentos-linkados-card" style="border: 1px solid #cbd5e1; border-top: none; border-radius: 0 0 6px 6px; padding: 15px; background: #ffffff;">
                                <table class="documentos-linkados-table documentos-table-simplificada" style="width: 100%; border-collapse: collapse;">
                                    <thead>
                                        <tr style="border-bottom: 2px solid #e2e8f0; text-align: left; font-size: 12px; color: #64748b;">
                                            <th style="padding: 8px;">Nome do Documento</th>
                                            <th class="coluna-acao" style="text-align: right; padding: 8px;">Acesso / Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody id="documentos-anexados-body">
                                        @if(isset($requerimento) && !empty($requerimento->documentos_anexados))
                                            @foreach($requerimento->documentos_anexados as $doc)
                                            <tr style="border-bottom: 1px solid #e2e8f0;">
                                                <td style="padding: 10px 8px;">{{ $doc['nome'] ?? 'Documento' }}</td>
                                                <td style="text-align: right; padding: 10px 8px;">
                                                    <a href="#" onclick="alert('Simulação: Abrindo {{ $doc['url'] ?? '' }}')" class="btn-inst btn-inst-outline" style="padding: 6px 14px; font-size: 0.82rem; text-decoration: none;">Visualizar</a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @else
                                        <tr>
                                            <td colspan="2" style="text-align: center; padding: 15px; color: #64748b;">Nenhum documento anexado encontrado.</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </details>
                    </section>
                </div>
            </div>
        </div>

        <div class="accordion-container" style="margin-bottom: 25px;">
            <!-- Indicação do Imóvel (Aba 1b) -->
            <div class="accordion-item" style="border: none;">
                <div class="accordion-header" style="background-color: #1e3a5f; color: white;" onclick="toggleAccordion(this)">
                    <span class="accordion-title">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 8px; vertical-align: middle;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        <span>Indicação do Imóvel</span>
                    </span>
                    <span class="accordion-icon">▲</span>
                </div>
                <div class="accordion-body" style="padding: 15px; display: block;">
                    <!-- Botão Adicionar Imóvel/Área -->
                    <div style="display: flex; justify-content: center; margin: 15px 0;" class="editavel">
                        <button type="button" id="btnAdicionarImovelArea" class="btn-action btn-inst btn-inst-primary">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Adicionar Imóvel/Área
                        </button>
                    </div>

                    <!-- Conceituação do Imóvel (flat, sem wrapper) -->
                    <div id="container_conceituacao_dropdown" style="display: {{ !empty($dados['conceituacao_imovel']) ? 'block' : 'none' }}; width: 100%; max-width: 450px; text-align: left; margin-bottom: 15px;">
                        <label for="conceituacao_imovel" style="font-weight: 600; color: #1e3a5f; margin-bottom: 6px; font-size: 15px; display: block;">Selecione a conceituação do imóvel:</label>
                        <select id="conceituacao_imovel" name="conceituacao_imovel" class="form-control" style="width: 100%; padding: 8px 12px; border-radius: 4px; border: 1px solid #cbd5e1; font-size: 15px; color: #334155; background-color: #ffffff;">
                            <option value="">Selecione uma opção...</option>
                            <option value="Terreno/acrescido de marinha">Terreno/acrescido de marinha</option>
                            <option value="Terreno/acrescido marginal">Terreno/acrescido marginal</option>
                            <option value="Nacional interior">Nacional interior</option>
                            <option value="Espelho d'água">Espelho d'água</option>
                            <option value="Cavidades naturais subterrâneas">Cavidades naturais subterrâneas</option>
                            <option value="Manguezal">Manguezal</option>
                            <option value="Praias">Praias</option>
                        </select>
                    </div>

                    <div id="bloco-info-exige-cadastro-minimo" style="display: none; margin-bottom: 15px;">
                        <button type="button" id="btnInserirCadastroMinimo" class="btn-action btn-inst btn-inst-primary" style="padding: 8px 16px; font-size: 0.9rem;">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Inserir Cadastro Mínimo
                        </button>
                    </div>

                    <div id="bloco-info-exige-rip" style="display: none; margin-bottom: 15px;">
                        <div style="display: flex; gap: 10px; justify-content: center;">
                            <button type="button" id="btnInserirRip" class="btn-action btn-inst btn-inst-primary" style="padding: 8px 16px; font-size: 0.9rem;" onclick="event.stopPropagation();var m=document.getElementById('modalInserirRip');if(m){m.style.display='flex';}var i=document.getElementById('inputNumeroRip');if(i){i.value='';}">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                Inserir RIP existente
                            </button>
                            <button type="button" id="btnSolicitarCriacaoRip" class="btn-action btn-inst btn-inst-outline" style="padding: 8px 16px; font-size: 0.9rem;">Solicitar a criação de RIP</button>
                        </div>
                    </div>

                    <div id="listaRipsInseridos" style="display: flex; flex-direction: column; gap: 8px; width: 100%; margin-bottom: 15px;"></div>
                    <div id="listaCadastrosInseridos" style="display: flex; flex-direction: column; gap: 8px; width: 100%; margin-bottom: 15px;"></div>
                </div>
            </div>
        </div>

            <!-- Bloco Resposta à Devolutiva -->
            <div id="blocoRespostaDevolutivaAba1" class="editavel" style="display: none; background-color: #fffbeb; border: 1px solid #fde68a; border-radius: 8px; padding: 20px; margin-top: 30px; margin-bottom: 10px;">
                <h4 style="color: #d97706; margin-top: 0; border-bottom: 1px solid #fcd34d; padding-bottom: 8px;">Resposta à Devolutiva</h4>
                <label for="resposta_devolucao" style="font-weight: bold; color: #92400e;">Descreva o que foi corrigido ou complementado nesta etapa (Obrigatório):</label>
                <textarea id="resposta_devolucao" name="resposta_devolucao" style="width: 100%; min-height: 100px; padding: 10px; border: 1px solid #fcd34d; border-radius: 4px; margin-top: 10px; font-family: inherit; font-size: 14px;"></textarea>
            </div>

        <div style="margin-top: 40px; border-top: 1px solid var(--aba1-border); padding-top: 24px;">
            <div style="display: flex; flex-direction: row; justify-content: center; gap: 15px; width: 100%; margin-bottom: 30px;">
                <button type="button" class="btn-action btn-inst" style="width: 24%; font-size: 1.05rem; padding: 15px; background-color: #64748b; border: none; border-radius: 8px; color: white; cursor: pointer; font-weight: bold; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: all 0.3s ease;" onclick="if(typeof window._saveDraft === 'function') window._saveDraft();">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: text-bottom; margin-right: 5px;"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Salvar Rascunho
                </button>
                <button type="submit" class="btn-action btn-inst btn-inst-primary" style="width: 24%; font-size: 1.05rem; padding: 15px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    Salvar e Enviar
                </button>
            </div>
        </div>
    </form>
    </fieldset>
</div>

<!-- Modal Inserir RIP -->
    <div id="modalInserirRip" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:3000; align-items:center; justify-content:center;">
        <div style="background:white; padding:30px; border-radius:12px; max-width:400px; width:90%; box-shadow:0 10px 25px rgba(0,0,0,0.3); position:relative; border-top: 8px solid #1e3a5f;">
            <button id="btnFecharModalRip" style="position:absolute; top:15px; right:15px; background:none; border:none; font-size:24px; cursor:pointer; color:#64748b;">&times;</button>
            <h2 style="margin-top:0; color:#1e3a5f; font-size:20px; text-align: left; margin-bottom: 20px;">Inserir RIP</h2>
            
            <div style="margin-bottom: 20px; text-align: left;">
                <label style="display: block; font-weight: 600; margin-bottom: 5px; color: #1e3a5f;">Número do RIP:</label>
                <input type="text" id="inputNumeroRip" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; outline: none;" placeholder="Digite o RIP...">
                <span id="errRipNaoEncontrado" style="display:none; color:#dc2626; font-size:0.85em; margin-top:5px; font-weight:600;">RIP não encontrado na tabela_spu!</span>
            </div>

            <div style="display: flex; justify-content: space-between; gap: 10px;">
                <button type="button" id="btnCancelarRip" class="btn-inst btn-inst-outline" style="flex: 1;">Cancelar</button>
                <button type="button" id="btnMaisRip" class="btn-inst btn-inst-outline" style="flex: 1;">Mais</button>
                <button type="button" id="btnSalvarRip" class="btn-inst btn-inst-primary" style="flex: 1;">Inserir</button>
            </div>
        </div>
    </div>

    <!-- Modal Cadastro Mínimo -->
    <div id="modalCadastroMinimo" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:3000; align-items:center; justify-content:center;">
        <div style="background:white; padding: 20px 30px; border-radius: 8px; max-width: 750px; width: 90%; box-shadow: 0 10px 25px rgba(0,0,0,0.3); position:relative; overflow-y: auto; max-height: 90vh; border-top: 8px solid #1e3a5f;">
            <button id="btnFecharModalCadastroMinimo" style="position:absolute; top:20px; right:20px; background:none; border:none; font-size:24px; cursor:pointer; color:#64748b;">&times;</button>
            <h2 style="margin-top:0; color:#1e3a5f; font-size:22px; text-align: left; padding-bottom: 15px; border-bottom: 1px solid #e2e8f0; margin-bottom: 20px;">Cadastro Mínimo para Áreas sem RIP</h2>
            
            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 15px; margin-bottom: 15px;">
                <!-- CEP -->
                <div style="background-color: #f8fafc; border-left: 4px solid #1e3a5f; padding: 10px 15px; border-radius: 4px; text-align: left;">
                    <label style="display: block; font-weight: bold; margin-bottom: 5px; color: #1e293b; font-size: 14px;">CEP <span style="color:red;">*</span>:</label>
                    <input type="text" id="modalCep" style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px; outline: none; background: white; margin-bottom: 0;" placeholder="00000-000">
                </div>
                <!-- Logradouro -->
                <div style="background-color: #f8fafc; border-left: 4px solid #1e3a5f; padding: 10px 15px; border-radius: 4px; text-align: left;">
                    <label style="display: block; font-weight: bold; margin-bottom: 5px; color: #1e293b; font-size: 14px;">Logradouro:</label>
                    <input type="text" id="modalLogradouro" style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px; outline: none; background: white; margin-bottom: 0;" placeholder="Preenchimento automático">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 15px; margin-bottom: 15px;">
                <!-- Município -->
                <div style="background-color: #f8fafc; border-left: 4px solid #1e3a5f; padding: 10px 15px; border-radius: 4px; text-align: left;">
                    <label style="display: block; font-weight: bold; margin-bottom: 5px; color: #1e293b; font-size: 14px;">Município:</label>
                    <input type="text" id="modalMunicipio" style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px; outline: none; background: white; margin-bottom: 0;" placeholder="Preenchimento automático">
                </div>
                <!-- UF -->
                <div style="background-color: #f8fafc; border-left: 4px solid #1e3a5f; padding: 10px 15px; border-radius: 4px; text-align: left;">
                    <label style="display: block; font-weight: bold; margin-bottom: 5px; color: #1e293b; font-size: 14px;">UF:</label>
                    <input type="text" id="modalUf" style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px; outline: none; background: white; margin-bottom: 0;" placeholder="UF">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 15px; margin-bottom: 15px;">
                <!-- Número -->
                <div style="background-color: #f8fafc; border-left: 4px solid #1e3a5f; padding: 10px 15px; border-radius: 4px; text-align: left;">
                    <label style="display: block; font-weight: bold; margin-bottom: 5px; color: #1e293b; font-size: 14px;">Número:</label>
                    <input type="text" id="modalNumero" style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px; outline: none; background: white; margin-bottom: 0;" placeholder="">
                </div>
                <!-- Complemento -->
                <div style="background-color: #f8fafc; border-left: 4px solid #1e3a5f; padding: 10px 15px; border-radius: 4px; text-align: left;">
                    <label style="display: block; font-weight: bold; margin-bottom: 5px; color: #1e293b; font-size: 14px;">Complemento:</label>
                    <input type="text" id="modalComplemento" style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px; outline: none; background: white; margin-bottom: 0;" placeholder="">
                </div>
            </div>

            <div style="margin-bottom: 15px;">
                <!-- Área a ser destinada -->
                <div style="background-color: #f8fafc; border-left: 4px solid #1e3a5f; padding: 10px 15px; border-radius: 4px; text-align: left;">
                    <label style="display: block; font-weight: bold; margin-bottom: 5px; color: #1e293b; font-size: 14px;">Área a ser destinada (m²) <span style="color:red;">*</span>:</label>
                    <input type="text" id="modalArea" style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px; outline: none; background: white; margin-bottom: 0;" placeholder="Ex: 5000">
                </div>
            </div>

            <div style="margin-bottom: 25px;">
                <!-- Observações -->
                <div style="background-color: #f8fafc; border-left: 4px solid #1e3a5f; padding: 10px 15px; border-radius: 4px; text-align: left;">
                    <label style="display: block; font-weight: bold; margin-bottom: 5px; color: #1e293b; font-size: 14px;">Observações:</label>
                    <textarea id="modalObservacoes" style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px; outline: none; background: white; resize: vertical; min-height: 80px; margin-bottom: 0;" placeholder="Escreva observações aqui..."></textarea>
                    
                    <button type="button" class="btn-inst btn-inst-outline" style="margin-top: 10px; padding: 8px 12px; font-size: 0.82rem;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Adicionar link/documento
                    </button>
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 15px; padding-top: 15px; border-top: 1px solid #e2e8f0;">
                <button type="button" id="btnCancelarCadastro" class="btn-inst btn-inst-outline">Cancelar</button>
                <button type="button" id="btnSalvarCadastro" class="btn-inst btn-inst-primary">Salvar Cadastro</button>
            </div>
        </div>
    </div>
    <!-- Modal Solicitar Criação de RIP -->
    <div id="modalSolicitarCriacaoRip" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:3000; align-items:center; justify-content:center;">
        <div style="background:white; padding:30px; border-radius:12px; max-width:500px; width:90%; box-shadow:0 10px 25px rgba(0,0,0,0.3); text-align:left; position:relative; border-top: 8px solid #1e3a5f;">
            <button id="btnFecharModalSolicitacaoRip" style="position:absolute; top:15px; right:15px; background:none; border:none; font-size:24px; cursor:pointer; color:#64748b;">&times;</button>
            <h3 style="color:#1e3a5f; margin-top:0; margin-bottom:15px; font-size:20px; font-weight:700;">Solicitar Criação de RIP</h3>
            <p style="font-size:0.9em; color:#64748b; margin-bottom:20px;">Descreva a solicitação que será enviada ao setor de cadastro para a criação do RIP deste imóvel.</p>
            
            <div style="margin-bottom: 20px;">
                <label for="inputSolicitacaoCriacao" style="font-weight: bold; display: block; margin-bottom: 8px; color:#1e3a5f;">Justificativa / Descrição da Solicitação:</label>
                <textarea id="inputSolicitacaoCriacao" rows="5" placeholder="Descreva aqui os detalhes do imóvel, localização e motivo da solicitação de abertura de RIP..." style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px; resize:vertical; outline:none; font-family:inherit;"></textarea>
            </div>
            
            <div style="display:flex; justify-content:flex-end; gap:12px;">
                <button type="button" class="btn-secondary btn-inst btn-inst-outline" id="btnCancelarSolicitacaoRip">Cancelar</button>
                <button type="button" id="btnSalvarSolicitacaoRip" class="btn-inst btn-inst-primary">Enviar Solicitação</button>
            </div>
        </div>
    </div>

    <!-- Modal Aprovação Aba 1 -->
    <div id="modalAprovacaoAba1" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:4000; align-items:center; justify-content:center;">
        <div style="background:white; padding:30px; border-radius:12px; max-width:1000px; width:95%; box-shadow:0 10px 25px rgba(0,0,0,0.3); text-align:left; position:relative; border-top: 8px solid #1e3a5f; max-height: 90vh; overflow-y: auto;">
            <button id="btnFecharModalAprovacao" style="position:absolute; top:15px; right:15px; background:none; border:none; font-size:24px; cursor:pointer; color:#64748b;">&times;</button>
            <h3 style="color:#1e3a5f; margin-top:0; margin-bottom:15px; font-size:20px; font-weight:700;">Conferência e Aprovação - Aba 1</h3>
            <p style="font-size:0.9em; color:#64748b; margin-bottom:20px;">Por favor, revise o resumo dos dados abaixo e preencha sua manifestação.</p>
            
            <div id="containerRelatorioAprovacao" style="width: 100%; max-height: 400px; border: 1px solid #cbd5e1; border-radius: 6px; overflow-y: auto; margin-bottom: 20px; padding: 20px; background: #fff;">
                <div id="loadingRelatorio" style="text-align: center; padding: 20px; font-weight: bold; color: #1e3a5f;">
                    Carregando resumo dos dados...
                </div>
                <div id="conteudoRelatorioAprovacao" style="display: none;" class="report-container">
                    <!-- O resumo será injetado dinamicamente via JS -->
                </div>
            </div>
            
            <div style="background: #f8fafc; padding: 20px; border-radius: 6px; border-left: 4px solid #1e3a5f; margin-bottom: 20px;">
                <h4 style="margin: 0 0 10px 0; color: #1e3a5f; font-size: 16px;">Declaração</h4>
                <p style="font-size: 14px; color: #334155; line-height: 1.5; margin-bottom: 15px; background: #fff; padding: 10px; border: 1px solid #e2e8f0; border-radius: 4px;">
                    Declaro que as informações consignadas neste formulário foram inseridas com base nos dados disponíveis nos sistemas oficiais, nos documentos constantes do processo e nas verificações realizadas no âmbito desta unidade, estando compatíveis com os elementos analisados.
                </p>
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-weight: bold; color: #1e3a5f; font-size: 15px; margin-bottom: 15px;">
                    <input type="checkbox" id="chkAprovarAba1" style="width: 20px; height: 20px; cursor: pointer;">
                    Concordo com a declaração acima.
                </label>
                
                <h4 style="margin: 0 0 10px 0; color: #1e3a5f; font-size: 15px;">Observações:</h4>
                <p style="font-size: 12px; color: #64748b; margin-bottom: 8px;">Registre eventuais ressalvas, condicionantes, inconsistências identificadas ou orientações para complementação da proposta.</p>
                <textarea id="txtObservacoesAba1" rows="4" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; resize: vertical; outline: none; font-family: inherit; margin-bottom: 10px;"></textarea>
            </div>
            
            <div style="display:flex; justify-content:flex-end; gap:12px;">
                <button type="button" id="btnCancelarAprovacao" class="btn-inst btn-inst-outline">Cancelar</button>
                <button type="button" id="btnConfirmarAprovacao" class="btn-inst btn-inst-primary" disabled>Concluir manifestação</button>
            </div>
        </div>
    </div>
