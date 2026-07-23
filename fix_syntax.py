with open('resources/views/processos/abas/aba1.blade.php', 'r', encoding='utf-8') as f:
    text = f.read()

# Fix the syntax error by removing the backslash before quotes in the blade braces
text = text.replace(
    r"value=\"{{ $requerimento->data_hora_recebimento ?? $processo->created_at->format(\'d/m/Y\') }}\"", 
    r"value=\"{{ $requerimento->data_hora_recebimento ?? $processo->created_at->format('d/m/Y') }}\""
)

# Replace any other occurrence of \' in value={{ ... }}
import re
text = re.sub(r'value="\{\{ (.*?) \\\'(.*?)\\\' \}\}"', r'value="{{ \1 \'\2\' }}"', text)
# Or just globally replace \'\'' with '' inside blade
text = text.replace(r"\'", "'")

with open('resources/views/processos/abas/aba1.blade.php', 'w', encoding='utf-8') as f:
    f.write(text)
