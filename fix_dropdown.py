with open('resources/views/processos/abas/aba1.blade.php', 'r', encoding='utf-8') as f:
    text = f.read()

# If $dados['conceituacao_imovel'] is set, display should be block, else none.
import re
text = re.sub(
    r'<div id="container_conceituacao_dropdown" style="display: none;',
    r'<div id="container_conceituacao_dropdown" style="display: {{ !empty($dados[\'conceituacao_imovel\']) ? \'block\' : \'none\' }};',
    text
)

# Also let's make sure btnAdicionarImovelArea has an inline onclick just in case the JS fails
text = re.sub(
    r'<button type="button" id="btnAdicionarImovelArea"',
    r'<button type="button" id="btnAdicionarImovelArea" onclick="document.getElementById(\'container_conceituacao_dropdown\').style.display = document.getElementById(\'container_conceituacao_dropdown\').style.display === \'none\' ? \'block\' : \'none\';"',
    text
)

with open('resources/views/processos/abas/aba1.blade.php', 'w', encoding='utf-8') as f:
    f.write(text)
