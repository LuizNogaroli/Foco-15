blade = """<style>
    .accordion-container { display: flex; flex-direction: column; gap: 15px; margin-bottom: 25px; }
    .accordion-item { border: 1px solid #cbd5e1; border-radius: 8px; overflow: hidden; background: #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
    .accordion-header { padding: 15px 20px; cursor: pointer; display: flex; justify-content: space-between; align-items: center; font-weight: bold; font-size: 1.1em; transition: background 0.2s; }
    .accordion-header:hover { filter: brightness(0.95); }
    .accordion-body { display: none; padding: 20px; border-top: 1px solid #cbd5e1; }
    .accordion-body.active { display: block; }
    .accordion-icon { font-size: 1.2em; transition: transform 0.3s; color: white !important; }
    .active .accordion-icon { transform: rotate(180deg); }
    body { font-family: 'Segoe UI', Arial, sans-serif !important; line-height: 1.5 !important; color: #333 !important; background-color: #f1f5f9 !important; margin: 0 !important; padding: 0 !important; display: block !important; overflow-y: scroll !important; }
</style>

<div class="form-container">
    <div id="label-titulo-requerimento" style="text-align: center; font-size: 0.85rem; letter-spacing: 0.05em; color: #6b7280; font-weight: 700; margin-bottom: 4px;">Requerimento</div>
    <h2 id="titulo-pagina-requerimento" style="text-align: center; margin-top: 0; margin-bottom: 24px;">Nº {{ $processo->numero_requerimento }}</h2>
    
    <fieldset @if(!auth()->user()->hasRole('Equipe Destinação')) disabled @endif>
    <form method="POST" action="{{ route('processos.tramitar', $processo->id) }}" id="form01">
        @csrf
        <input type="hidden" name="next_aba" value="2">
        
        <div class="accordion-container" style="margin-bottom: 25px;">
            <!-- Dados do Requerimento -->
            <div class="accordion-item" style="border: 2px solid #1e3a5f;">
                <div class="accordion-header" style="background-color: #1e3a5f; color: white;" onclick="toggleAccordion(this)">
                    <span>📑 Dados do Requerimento</span>
                    <span class="accordion-icon">▼</span>
                </div>
                <div class="accordion-body active" style="display: block; padding: 15px;">
                    <div class="form-group inline">
                        <label>Número do requerimento:</label>
                        <input type="text" name="numero_requerimento" value="{{ $processo->numero_requerimento }}" readonly>
                    </div>
                    <div class="form-group inline">
                        <label>Tipo de requerimento:</label>
                        <input type="text" name="tipo_requerimento" value="{{ $processo->tipo_requerimento }}" readonly style="background: transparent; border: none; font-weight: 500; color: #1e293b;">
                    </div>
                    <div class="form-group inline">
                        <label>Data de Requerimento:</label>
                        <input type="text" name="data_requerimento" value="{{ $processo->created_at->format('d/m/Y') }}" readonly>
                    </div>
                    <div class="form-group inline">
                        <label>Número do processo SEI:</label>
                        <input type="text" name="processo_sei" class="mask-sei" maxlength="20" value="{{ $dados['processo_sei'] ?? '' }}" required placeholder="00000.000000/0000-00">
                    </div>
                    <div class="form-group inline">
                        <label>CPF/CNPJ:</label>
                        <input type="text" name="cpf_cnpj_requerente" class="mask-cpf-cnpj" maxlength="18" value="{{ $dados['cpf_cnpj_requerente'] ?? '' }}" required>
                    </div>
                    <div class="form-group inline">
                        <label>Nome do requerente:</label>
                        <input type="text" name="nome_requerente" value="{{ $dados['nome_requerente'] ?? '' }}" required>
                    </div>
                    <div class="form-group inline">
                        <label>Telefone celular:</label>
                        <input type="text" name="telefone_requerente" placeholder="(99) 99999-9999" maxlength="15" value="{{ $dados['telefone_requerente'] ?? '' }}" required>
                    </div>

                    <h4 style="margin: 20px 0 16px 0; color: #0056b3; border-bottom: 2px solid #ddd; padding-bottom: 8px;">Dados do Representante Legal</h4>
                    <div class="form-group inline">
                        <label>CPF/CNPJ do representante:</label>
                        <input type="text" name="cpf_cnpj_representante" class="mask-cpf-cnpj" maxlength="18" value="{{ $dados['cpf_cnpj_representante'] ?? '' }}" placeholder="Opcional">
                    </div>
                    <div class="form-group inline">
                        <label>Nome do representante:</label>
                        <input type="text" name="nome_representante" value="{{ $dados['nome_representante'] ?? '' }}" placeholder="Opcional">
                    </div>
                    <div class="form-group inline">
                        <label>Telefone celular do representante:</label>
                        <input type="text" name="telefone_representante" placeholder="(99) 99999-9999" maxlength="15" value="{{ $dados['telefone_representante'] ?? '' }}">
                    </div>

                    <h4 style="margin: 20px 0 16px 0; color: #0056b3; border-bottom: 2px solid #ddd; padding-bottom: 8px;">Informações Adicionais</h4>
                    <div class="form-group inline">
                        <label>Pessoa estrangeira:</label>
                        <input type="text" name="is_estrangeiro" value="{{ $dados['is_estrangeiro'] ?? 'Não' }}" readonly style="background: transparent; border: none;">
                    </div>
                    <div class="form-group inline">
                        <label>Prioridade Legal:</label>
                        <input type="text" name="prioridade_legal" value="{{ $dados['prioridade_legal'] ?? 'Não se aplica' }}" readonly style="color: #ea580c; font-weight: bold; background: transparent; border: none;">
                    </div>
                </div>
            </div>
        </div>

        <h2 style="text-align: center; color: #1e3a5f; margin: 40px 0 20px 0; font-size: 1.5rem; border-bottom: none;">Indicação do Imóvel</h2>
        <section class="conceituacao-imovel-section" style="margin-bottom: 25px; background: #eff6ff; border-left: 4px solid #007bff; border-radius: 4px; padding: 10px 15px;">
            <div style="display: flex; flex-direction: column; gap: 10px; width: 100%;">
                <label style="font-weight: 600; color: #1e3a5f; font-size: 15px;">Selecione a conceituação do imóvel:</label>
                <select name="conceituacao_imovel" class="form-control" style="width: 100%; max-width: 450px; padding: 8px 12px; border-radius: 4px; border: 1px solid #cbd5e1;">
                    <option value="">Selecione uma opção...</option>
                    <option value="Terreno/acrescido de marinha" {{ ($dados['conceituacao_imovel'] ?? '') == 'Terreno/acrescido de marinha' ? 'selected' : '' }}>Terreno/acrescido de marinha</option>
                    <option value="Terreno/acrescido marginal" {{ ($dados['conceituacao_imovel'] ?? '') == 'Terreno/acrescido marginal' ? 'selected' : '' }}>Terreno/acrescido marginal</option>
                    <option value="Nacional interior" {{ ($dados['conceituacao_imovel'] ?? '') == 'Nacional interior' ? 'selected' : '' }}>Nacional interior</option>
                </select>
            </div>
        </section>

        <div style="margin-top: 40px; border-top: 1px solid #ccc; padding-top: 20px;">
            <div style="display: flex; flex-direction: column; align-items: center; width: 100%; margin-bottom: 30px;">
                <button type="submit" class="btn-action" style="width: 50%; font-size: 1.2em; padding: 16px; background-color: #0284c7; border: none; border-radius: 8px; color: white; cursor: pointer; font-weight: bold;">
                    💾 Salvar e Avançar
                </button>
            </div>
        </div>
    </form>
    </fieldset>
</div>
"""
with open('resources/views/processos/abas/aba1.blade.php', 'w', encoding='utf-8') as f:
    f.write(blade)
