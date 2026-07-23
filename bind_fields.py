import re

with open('resources/views/processos/abas/aba1.blade.php', 'r', encoding='utf-8') as f:
    aba1 = f.read()

# For fields campo13, campo14, campo15, campo19, campo14_rep, campo15_rep, campo19_rep
# Replace `value=""` with `value="{{ $dados['campoX'] ?? '' }}"`
fields = ['campo13', 'campo14', 'campo15', 'campo19', 'campo14_rep', 'campo15_rep', 'campo19_rep']

for field in fields:
    # regex to find name="campoX" ... value=""
    aba1 = re.sub(f'name="{field}"([^>]*)value=""', f'name="{field}"\\1value="{{{{ $dados[\'{field}\'] ?? \'\' }}}}"', aba1)
    
    # some inputs might have value="something" instead of value=""
    # but the old HTML has value=""
    # wait, prioridade_legal has value="Não se aplica"
    # campo17 has value="Não"

with open('resources/views/processos/abas/aba1.blade.php', 'w', encoding='utf-8') as f:
    f.write(aba1)
