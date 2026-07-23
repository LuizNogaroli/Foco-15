with open('resources/views/processos/abas/aba1.blade.php', 'r', encoding='utf-8') as f:
    text = f.read()

import re

# We can replace the value attributes based on the id attribute using a regex.
# Example: id="campo11" ... value=""
fields_map = {
    'campo11': '{{ $requerimento->numero_requerimento ?? \'\' }}',
    'tipo_requerimento': '{{ $requerimento->tipo_requerimento ?? \'\' }}',
    'campo12': '{{ $requerimento->data_hora_recebimento ?? \'\' }}',
    'campo13': '{{ $requerimento->nup_sei ?? \'\' }}',
    'campo14': '{{ $requerimento->cpf_cnpj_requerente ?? \'\' }}',
    'campo15': '{{ $requerimento->nome_requerente ?? \'\' }}',
    'campo19': '{{ $requerimento->contato_requerente ?? \'\' }}',
    'campo14_rep': '{{ $requerimento->cpf_cnpj_representante ?? \'\' }}',
    'campo15_rep': '{{ $requerimento->nome_representante ?? \'\' }}',
    'campo19_rep': '{{ $requerimento->contato_representante ?? \'\' }}',
    'campo17': '{{ $requerimento->projeto_prioritario ?? \'Não\' }}',
    'prioridade_legal': '{{ $requerimento->prioridade_legal ?? \'Não se aplica\' }}'
}

for field, val in fields_map.items():
    # Find the input tag for this id
    pattern = r'(<input[^>]+id="' + field + r'"[^>]*)(?:value="[^"]*")([^>]*>)'
    
    # Wait, some inputs might not have value="". We can just replace the value="" part if it exists, or add it.
    def replacer(match):
        part1 = match.group(1)
        part2 = match.group(2)
        # Avoid double value=""
        return f'{part1}value="{val}"{part2}'
        
    text = re.sub(pattern, replacer, text)
    
with open('resources/views/processos/abas/aba1.blade.php', 'w', encoding='utf-8') as f:
    f.write(text)

print("Values mapped")
