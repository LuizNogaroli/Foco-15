import os

files = [
    r'c:\Users\luizn\Documents\1-PROGRAMAS\Foco-15\public\foco-01-resumo.html',
    r'c:\Users\luizn\Documents\1-PROGRAMAS\Foco-15\prototipo_html\foco-01-resumo.html',
    r'c:\Users\luizn\Documents\1-PROGRAMAS\Foco-15\public\foco-02-resumo.html',
    r'c:\Users\luizn\Documents\1-PROGRAMAS\Foco-15\prototipo_html\foco-02-resumo.html',
    r'c:\Users\luizn\Documents\1-PROGRAMAS\Foco-15\public\foco-03-resumo.html',
    r'c:\Users\luizn\Documents\1-PROGRAMAS\Foco-15\prototipo_html\foco-03-resumo.html'
]

old_line = "const processId = localStorage.getItem('CURRENT_PROCESS_ID');"
new_line = "const processId = localStorage.getItem('CURRENT_PROCESS_ID') || window.parent?.CURRENT_PROCESS_ID || window.parent?.parent?.CURRENT_PROCESS_ID;"

for fpath in files:
    if os.path.exists(fpath):
        with open(fpath, 'r', encoding='utf-8') as f:
            content = f.read()
        content = content.replace(old_line, new_line)
        with open(fpath, 'w', encoding='utf-8') as f:
            f.write(content)
        print('Updated processId fallback in:', fpath)
