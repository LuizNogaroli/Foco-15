import re

with open('prototipo_html/foco-01.html', 'r', encoding='utf-8') as f:
    foco = f.read()

match = re.search(r'(<!-- Bot[^>]*Adicionar Im[^>]*vel[^>]*>.*)</form>', foco, re.DOTALL | re.IGNORECASE)

if match:
    rest_of_form = match.group(1)
    
    with open('resources/views/processos/abas/aba1.blade.php', 'r', encoding='utf-8') as f:
        aba1 = f.read()
    
    # Also replace <!-- Botes Inferiores -->
    aba1 = re.sub(r'<!-- Bot[^>]*es Inferiores -->', rest_of_form + '\n        <!-- Botões Inferiores -->', aba1)
    
    # Fix the weird ending
    aba1 = aba1.replace('</form>`n</fieldset>', '</form>\n    </fieldset>')
    
    with open('resources/views/processos/abas/aba1.blade.php', 'w', encoding='utf-8') as f:
        f.write(aba1)
    print("Successfully merged missing form fields!")
else:
    print("Could not find the rest of the form in foco-01.html")
