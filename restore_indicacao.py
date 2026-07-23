import re

with open('14-foco-01.html', 'r', encoding='utf-8') as f:
    foco = f.read()

# Extract from "<h2 ...>Indicação do Imóvel</h2>" to just before "<!-- Botões Inferiores -->"
match = re.search(r'(<h2[^>]*>Indica[^>]*o do Im[^>]*vel</h2>.*?)(<!-- Bot[^>]*es Inferiores -->)', foco, re.DOTALL | re.IGNORECASE)
if match:
    indicacao_block = match.group(1)
    
    with open('resources/views/processos/abas/aba1.blade.php', 'r', encoding='utf-8') as f:
        aba1 = f.read()
    
    # Replace the existing indicacao block in aba1
    aba1 = re.sub(r'<h2[^>]*>Indica[^>]*o do Im[^>]*vel</h2>.*?<div style="margin-top: 40px; border-top: 1px solid #ccc; padding-top: 20px;">', indicacao_block + '\n        <div style="margin-top: 40px; border-top: 1px solid #ccc; padding-top: 20px;">', aba1, flags=re.DOTALL)
    
    with open('resources/views/processos/abas/aba1.blade.php', 'w', encoding='utf-8') as f:
        f.write(aba1)
    print("Replaced indicacao block!")
else:
    print("Not found in 14-foco-01.html")
