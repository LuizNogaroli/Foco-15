with open('resources/views/processos/abas/aba1.blade.php', 'r', encoding='utf-8') as f:
    text = f.read()

# Replace \'\' with '' in the specific line
text = text.replace(r"{{ $doc['url'] ?? \'\' }}", r"{{ $doc['url'] ?? '' }}")

with open('resources/views/processos/abas/aba1.blade.php', 'w', encoding='utf-8') as f:
    f.write(text)
