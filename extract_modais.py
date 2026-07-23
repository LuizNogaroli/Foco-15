import re

with open('14-foco-01.html', 'r', encoding='utf-8') as f:
    foco = f.read()

# Extract modais
# Find everything after <!-- Modais --> or just search for <div id="modalInserirRip"
# Let's search for modal blocks
match = re.search(r'(<!-- MODAL INSERIR RIP -->.*?)</body>', foco, re.DOTALL | re.IGNORECASE)
if not match:
    # try another way
    match = re.search(r'(<div id="modalInserirRip".*?)<script', foco, re.DOTALL | re.IGNORECASE)

if match:
    modais = match.group(1)
    
    with open('resources/views/processos/abas/aba1.blade.php', 'r', encoding='utf-8') as f:
        aba1 = f.read()
    
    # Append modais if not already there
    if 'id="modalInserirRip"' not in aba1:
        # insert before the last </div> which closes form-container
        aba1 = aba1.replace('</div>\n"""', modais + '\n</div>\n"""')
        aba1 = aba1 + '\n' + modais
        
        with open('resources/views/processos/abas/aba1.blade.php', 'w', encoding='utf-8') as f:
            f.write(aba1)
        print("Modais appended!")
    else:
        print("Modais already exist")
else:
    print("Modais not found")
