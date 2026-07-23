with open('resources/views/processos/abas/aba1.blade.php', 'r', encoding='utf-8') as f:
    text = f.read()

import re
matches = list(re.finditer(r'<h2[^>]*>Indica.*?o do Im.*?vel</h2>', text, re.IGNORECASE))
print("Number of 'Indicação do Imóvel' headers:", len(matches))
for m in matches:
    print(m.group(0))
