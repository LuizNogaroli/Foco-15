import re

def get_fields(filepath):
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # regex to find name="..."
    names = re.findall(r'name=["\']([^"\']+)["\']', content)
    
    # filter out some known things like button names
    return set([n for n in names if n != ''])

fields_old = get_fields('14-foco-01.html')
fields_new = get_fields('resources/views/processos/abas/aba1.blade.php')

missing_in_new = fields_old - fields_new
missing_in_old = fields_new - fields_old

print("Fields in 14-foco-01.html but MISSING in aba1.blade.php:")
for f in sorted(missing_in_new):
    print(" - " + f)

print("\nFields in aba1.blade.php but MISSING in 14-foco-01.html:")
for f in sorted(missing_in_old):
    print(" - " + f)

