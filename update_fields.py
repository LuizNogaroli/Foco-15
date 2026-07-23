import re

with open('14-foco-01.html', 'r', encoding='utf-8') as f:
    foco = f.read()

# Extract from 1.3 to end of "Documentos anexados" section in 14-foco-01
# Actually, I'll extract from 1.3 down to 1.11
match = re.search(r'(<!-- 1\.3.*?)(<!-- 1\.11)', foco, re.DOTALL | re.IGNORECASE)
if match:
    fields_block = match.group(1)
    
    with open('resources/views/processos/abas/aba1.blade.php', 'r', encoding='utf-8') as f:
        aba1 = f.read()
    
    # Replace the chunk in aba1.blade.php
    # from "<!-- 1.3" to the end of the "<!-- 1.5 Nome do Requerente" block.
    # Wait, in aba1 it ends at </div> </div> </div> (the accordion body end)
    # Let's just find where to insert it.
    
    # In aba1:
    aba1 = re.sub(r'<!-- 1\.3.*?<!-- 1\.5 Nome do Requerente -->\s*<div class="form-group inline">\s*<label[^>]*>.*?</label>\s*<input[^>]*>\s*</div>', fields_block, aba1, flags=re.DOTALL)
    
    # Also I need to add Blade variable binding to these fields if I want them to render old values.
    # I can just do a regex replace to bind `value="{{ $dados['nome_do_campo'] ?? '' }}"`
    # Let's do that for the replaced block.
    def replace_value(m):
        name = m.group(1)
        return f'name="{name}" value="{{{{ $dados[\'{name}\'] ?? \'\' }}}}"'
    
    # But wait, campo17 and prioridade_legal are readonly
    
    with open('resources/views/processos/abas/aba1.blade.php', 'w', encoding='utf-8') as f:
        f.write(aba1)
    print("Replaced!")
else:
    print("Not found")
