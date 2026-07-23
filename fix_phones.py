with open('resources/views/processos/abas/aba1.blade.php', 'r', encoding='utf-8') as f:
    text = f.read()

import re

# Fix telefone_requerente
text = re.sub(
    r'value="\{\{ \$dados\[\'telefone_requerente\'\] \?\? \'\' \}\}"',
    r'value="{{ $requerimento->contato_requerente ?? \'\' }}"',
    text
)

# Fix telefone_representante
text = re.sub(
    r'value="\{\{ \$dados\[\'telefone_representante\'\] \?\? \'\' \}\}"',
    r'value="{{ $requerimento->contato_representante ?? \'\' }}"',
    text
)

# Also make them readonly since they come from the portal, and we don't want the user changing them directly.
# Wait, let's just make sure they are populated.

with open('resources/views/processos/abas/aba1.blade.php', 'w', encoding='utf-8') as f:
    f.write(text)
