with open('resources/views/processos/abas/aba1.blade.php', 'r', encoding='utf-8') as f:
    text = f.read()

print("inputNumeroRip count:", text.count('id="inputNumeroRip"'))
