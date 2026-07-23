with open('resources/views/processos/abas/aba1.blade.php', 'r', encoding='utf-8') as f:
    text = f.read()

import re
match = re.search(r'Indica.*o do Im.*vel', text, re.IGNORECASE)
if match:
    print("Found:", text[match.start():match.start()+500])
else:
    print("Not found")
