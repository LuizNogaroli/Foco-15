with open('resources/views/processos/show.blade.php', 'r', encoding='utf-8') as f:
    text = f.read()

import re
text = re.sub(r"\'processos.abas.aba1\',\s*\[\'processo\' => \$processo,\s*\'dados\' => \$dados\]\)", "'processos.abas.aba1', ['processo' => $processo, 'dados' => $dados, 'requerimento' => $requerimento ?? null])", text)

with open('resources/views/processos/show.blade.php', 'w', encoding='utf-8') as f:
    f.write(text)
