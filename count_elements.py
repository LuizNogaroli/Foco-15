with open('resources/views/processos/abas/aba1.blade.php', 'r', encoding='utf-8') as f:
    text = f.read()
    
print("btnAdicionarImovelArea count:", text.count("btnAdicionarImovelArea"))
print("conceituacao_imovel count:", text.count("conceituacao_imovel"))
