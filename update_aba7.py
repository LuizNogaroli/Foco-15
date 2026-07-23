import re

with open('resources/views/processos/abas/aba7.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# 1. Chefia
chefia_block = '''<fieldset @if(isset(['assinatura_chefia_nome']) || !auth()->user()->hasRole('Chefia')) disabled @endif>
                    <p style="font-size:0.94em; color:#1e293b; margin:0 0 4px;"><strong>Declaro que:</strong></p>'''

content = content.replace('<p style="font-size:0.94em; color:#1e293b; margin:0 0 4px;"><strong>Declaro que:</strong></p>', chefia_block, 1)

chefia_btn = '''</div>
                </fieldset>
                <div class="decl-btn-assinar">
                    @if(!isset(['assinatura_chefia_nome']))
                        @if(auth()->user()->hasRole('Chefia'))
                            <button type="submit" name="acao_aba7" value="chefia" class="btn-assinar">✍️ Concluir manifestação (Chefia)</button>
                        @endif
                    @else
                        <div class="decl-assinado-overlay visivel" style="display:block;">
                            <strong>✔ Manifestação registrada</strong><br>
                            Assinado por: {{ ['assinatura_chefia_nome'] }} em {{ ['assinatura_chefia_data'] }}
                        </div>
                    @endif
                </div>'''
content = re.sub(r'</div>\s*<div class="decl-btn-assinar">.*?<span id="resumo-A"></span>\s*</div>', chefia_btn, content, flags=re.DOTALL)


# 2. Coordenacao
coord_block = '''<fieldset @if(isset(['assinatura_coordenacao_nome']) || !auth()->user()->hasRole('Coordenação')) disabled @endif>
                    <p style="font-size:0.94em; color:#1e293b; margin:0 0 4px;"><strong>Declaro que:</strong></p>'''

content = content.replace('<p style="font-size:0.94em; color:#1e293b; margin:0 0 4px;"><strong>Declaro que:</strong></p>', coord_block, 1)

coord_btn = '''</div>
                </fieldset>
                <div class="decl-btn-assinar">
                    @if(!isset(['assinatura_coordenacao_nome']))
                        @if(auth()->user()->hasRole('Coordenação'))
                            <button type="submit" name="acao_aba7" value="coordenacao" class="btn-assinar">✍️ Concluir manifestação (Coordenação)</button>
                        @endif
                    @else
                        <div class="decl-assinado-overlay visivel" style="display:block;">
                            <strong>✔ Manifestação registrada</strong><br>
                            Assinado por: {{ ['assinatura_coordenacao_nome'] }} em {{ ['assinatura_coordenacao_data'] }}
                        </div>
                    @endif
                </div>'''
content = re.sub(r'</div>\s*<div class="decl-btn-assinar">.*?<span id="resumo-B"></span>\s*</div>', coord_btn, content, flags=re.DOTALL)


# 3. Superintendencia
super_block = '''<fieldset @if(isset(['assinatura_superintendencia_nome']) || !auth()->user()->hasRole('Superintendência')) disabled @endif>
                    <div style="margin-bottom:14px;">'''
content = content.replace('<div style="margin-bottom:14px;">\n                        <p class="decl-sublabel" style="margin-top:0;">A destinação é de competência da CDE?</p>', super_block + '\n                        <p class="decl-sublabel" style="margin-top:0;">A destinação é de competência da CDE?</p>', 1)

super_btn = '''</div>
                </fieldset>
                <div class="decl-btn-assinar">
                    @if(!isset(['assinatura_superintendencia_nome']))
                        @if(auth()->user()->hasRole('Superintendência'))
                            <button type="submit" name="acao_aba7" value="superintendencia" class="btn-assinar">✍️ Concluir manifestação (Superintendência)</button>
                        @endif
                    @else
                        <div class="decl-assinado-overlay visivel" style="display:block;">
                            <strong>✔ Manifestação registrada</strong><br>
                            Assinado por: {{ ['assinatura_superintendencia_nome'] }} em {{ ['assinatura_superintendencia_data'] }}
                        </div>
                    @endif
                </div>'''
content = re.sub(r'</div>\s*<div class="decl-btn-assinar">.*?<span id="resumo-C"></span>\s*</div>', super_btn, content, flags=re.DOTALL)

# Hide global conclude button if they just need to sign section by section
content = content.replace('<button type="submit" class="btn-action" style="width: 100%;', '<!-- <button type="submit" class="btn-action" style="width: 100%;')
content = content.replace('Concluir Processo</button>', 'Concluir Processo</button> -->')


with open('resources/views/processos/abas/aba7.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)
