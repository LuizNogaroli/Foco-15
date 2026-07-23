with open('resources/views/processos/abas/aba7.blade.php', 'r', encoding='utf-8') as f:
    c = f.read()
c = c.replace("isset(['assinatura_", "isset(['assinatura_")
c = c.replace("{{ ['assinatura_", "{{ ['assinatura_")
with open('resources/views/processos/abas/aba7.blade.php', 'w', encoding='utf-8') as f:
    f.write(c)
