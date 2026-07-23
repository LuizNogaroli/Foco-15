with open('resources/views/processos/abas/aba1.blade.php', 'r', encoding='utf-8') as f:
    text = f.read()

replacements = {
    'id="campo11" name="campo11" value=""': 'id="campo11" name="campo11" value="{{ $requerimento->numero_requerimento ?? \'\' }}"',
    'id="tipo_requerimento" name="tipo_requerimento" value=""': 'id="tipo_requerimento" name="tipo_requerimento" value="{{ $requerimento->tipo_requerimento ?? \'\' }}"',
    'id="campo12" name="campo12" value=""': 'id="campo12" name="campo12" value="{{ $requerimento->data_hora_recebimento ?? \'\' }}"',
    'id="campo13" name="campo13" class="mask-sei" maxlength="20" value=""': 'id="campo13" name="campo13" class="mask-sei" maxlength="20" value="{{ $requerimento->nup_sei ?? \'\' }}"',
    'id="campo14" name="campo14" class="mask-cpf-cnpj" maxlength="18" value=""': 'id="campo14" name="campo14" class="mask-cpf-cnpj" maxlength="18" value="{{ $requerimento->cpf_cnpj_requerente ?? \'\' }}"',
    'id="campo15" name="campo15" value=""': 'id="campo15" name="campo15" value="{{ $requerimento->nome_requerente ?? \'\' }}"',
    'id="campo19" name="campo19" placeholder="(99) 99999-9999" maxlength="15" value=""': 'id="campo19" name="campo19" placeholder="(99) 99999-9999" maxlength="15" value="{{ $requerimento->contato_requerente ?? \'\' }}"',
    'id="campo14_rep" name="campo14_rep" class="mask-cpf-cnpj" maxlength="18" placeholder="Opcional" autocomplete="off"': 'id="campo14_rep" name="campo14_rep" class="mask-cpf-cnpj" maxlength="18" placeholder="Opcional" value="{{ $requerimento->cpf_cnpj_representante ?? \'\' }}" autocomplete="off"',
    'id="campo15_rep" name="campo15_rep" placeholder="Opcional" autocomplete="off"': 'id="campo15_rep" name="campo15_rep" placeholder="Opcional" value="{{ $requerimento->nome_representante ?? \'\' }}" autocomplete="off"',
    'id="campo19_rep" name="campo19_rep" placeholder="(99) 99999-9999" maxlength="15" autocomplete="off"': 'id="campo19_rep" name="campo19_rep" placeholder="(99) 99999-9999" maxlength="15" value="{{ $requerimento->contato_representante ?? \'\' }}" autocomplete="off"',
    'id="campo17" name="campo17" value="Nǜo"': 'id="campo17" name="campo17" value="{{ $requerimento->projeto_prioritario ?? \'Não\' }}"',
    'id="prioridade_legal" name="prioridade_legal" value="Nǜo se aplica"': 'id="prioridade_legal" name="prioridade_legal" value="{{ $requerimento->prioridade_legal ?? \'Não se aplica\' }}"'
}

for k, v in replacements.items():
    text = text.replace(k, v)

# Fix possible encoding issues from replace manually
text = text.replace('id="campo17" name="campo17" value="Não"', 'id="campo17" name="campo17" value="{{ $requerimento->projeto_prioritario ?? \'Não\' }}"')
text = text.replace('id="prioridade_legal" name="prioridade_legal" value="Não se aplica"', 'id="prioridade_legal" name="prioridade_legal" value="{{ $requerimento->prioridade_legal ?? \'Não se aplica\' }}"')

documentos_html = """
            <!-- 1.11 Documentos anexados ao requerimento -->
            <section class="documentos-linkados-section" aria-labelledby="titulo-documentos-linkados" style="margin-bottom: 25px;">
                <details class="documentos-expansivel" open>
                    <summary class="documentos-expansivel-header" style="cursor: pointer; padding: 12px; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 6px; display: flex; justify-content: space-between; align-items: center;">
                        <span id="titulo-documentos-linkados" style="font-weight: 600; color: #1e3a5f;">Documentos anexados ao requerimento</span>
                        <span class="documentos-linkados-badge" style="background: #e2e8f0; padding: 3px 8px; border-radius: 12px; font-size: 11px; font-weight: bold; color: #475569;">Documentos Digitais</span>
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
                                            <a href="#" onclick="alert('Simulação: Abrindo {{ $doc['url'] ?? \'\' }}')" style="color: #0056b3; text-decoration: none; font-weight: bold;">Ver Documento</a>
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
"""

# Insert the documentos html just before "<!-- Botões Inferiores -->"
if 'titulo-documentos-linkados' not in text:
    text = text.replace('<!-- Botões Inferiores -->', documentos_html + '\n            <!-- Botões Inferiores -->')

with open('resources/views/processos/abas/aba1.blade.php', 'w', encoding='utf-8') as f:
    f.write(text)
