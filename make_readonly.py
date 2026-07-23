with open('resources/views/processos/abas/aba1.blade.php', 'r', encoding='utf-8') as f:
    text = f.read()

import re

# Remove required and add readonly for specific fields
fields_to_make_readonly = [
    'processo_sei',
    'cpf_cnpj_requerente',
    'nome_requerente',
    'telefone_requerente',
    'cpf_cnpj_representante',
    'nome_representante',
    'telefone_representante'
]

for field in fields_to_make_readonly:
    # Remove required
    pattern_req = r'(<input[^>]+name="' + field + r'"[^>]*?)\s*required\b'
    text = re.sub(pattern_req, r'\1', text)
    
    # Add readonly if not present
    pattern_readonly = r'(<input[^>]+name="' + field + r'"(?!.*readonly)[^>]*>)'
    
    def repl_readonly(match):
        tag = match.group(1)
        if 'readonly' not in tag:
            tag = tag.replace('>', ' readonly style="background: transparent; border: none; outline: none; padding: 0; width: 100%; font-size: 14px; font-weight: 500; color: #1e293b;">')
        return tag
        
    text = re.sub(pattern_readonly, repl_readonly, text)
    
with open('resources/views/processos/abas/aba1.blade.php', 'w', encoding='utf-8') as f:
    f.write(text)

print("Fields updated to readonly")
