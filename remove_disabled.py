with open('resources/views/processos/abas/aba1.blade.php', 'r', encoding='utf-8') as f:
    text = f.read()

# Replace the fieldset disabled condition to allow full testing, 
# or just remove the `disabled` attribute from the buttons!
import re

text = re.sub(
    r'<fieldset @if\(!auth\(\)->user\(\)->hasRole\(\'Equipe Destina[^>]+>\)',
    '<fieldset>',
    text
)

text = re.sub(
    r'<fieldset @if\(!auth\(\)->user\(\)->hasRole\(\'Equipe Destina[^>]*\)\) disabled @endif>',
    '<fieldset>',
    text
)

with open('resources/views/processos/abas/aba1.blade.php', 'w', encoding='utf-8') as f:
    f.write(text)
