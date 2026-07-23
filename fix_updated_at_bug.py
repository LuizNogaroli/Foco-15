import os

files = [
    r'c:\Users\luizn\Documents\1-PROGRAMAS\Foco-15\public\foco-02-resumo.html',
    r'c:\Users\luizn\Documents\1-PROGRAMAS\Foco-15\prototipo_html\foco-02-resumo.html'
]

old_code = "const dateObj = new Date(data[0].updated_at);"
new_code = "// dateObj ja foi inicializado com fallback ou data[0].updated_at"

for fpath in files:
    if os.path.exists(fpath):
        with open(fpath, 'r', encoding='utf-8') as f:
            c = f.read()
        if old_code in c:
            c = c.replace(old_code, new_code)
            with open(fpath, 'w', encoding='utf-8') as f:
                f.write(c)
            print('Successfully fixed updated_at bug in:', fpath)
        else:
            print('old_code not found in:', fpath)
