with open('resources/views/processos/abas/aba1.blade.php', 'r', encoding='utf-8') as f:
    text = f.read()

import re
# Remove the inline onclick attribute
text = re.sub(r'onclick="document\.getElementById\(\'container_conceituacao_dropdown\'\)\.style\.display\s*=\s*document\.getElementById\(\'container_conceituacao_dropdown\'\)\.style\.display === \'none\' \? \'block\' : \'none\';"', '', text)

with open('resources/views/processos/abas/aba1.blade.php', 'w', encoding='utf-8') as f:
    f.write(text)
