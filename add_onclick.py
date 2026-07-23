with open('resources/views/processos/abas/aba1.blade.php', 'r', encoding='utf-8') as f:
    text = f.read()

text = text.replace(
    r'<button type="button" id="btnAdicionarImovelArea" class="btn-action"',
    r'<button type="button" id="btnAdicionarImovelArea" onclick="document.getElementById(\'container_conceituacao_dropdown\').style.display = document.getElementById(\'container_conceituacao_dropdown\').style.display === \'none\' ? \'block\' : \'none\';" class="btn-action"'
)

with open('resources/views/processos/abas/aba1.blade.php', 'w', encoding='utf-8') as f:
    f.write(text)
