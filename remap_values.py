with open('resources/views/processos/abas/aba1.blade.php', 'r', encoding='utf-8') as f:
    text = f.read()

import re

# Update value mapping to use $requerimento
replacements = {
    r'value="\{\{ \$processo->numero_requerimento \}\}"': r'value="{{ $requerimento->numero_requerimento ?? $processo->numero_requerimento }}"',
    r'value="\{\{ \$processo->tipo_requerimento \}\}"': r'value="{{ $requerimento->tipo_requerimento ?? $processo->tipo_requerimento }}"',
    r'value="\{\{ \$processo->created_at->format\(\'d/m/Y\'\) \}\}"': r'value="{{ $requerimento->data_hora_recebimento ?? $processo->created_at->format(\'d/m/Y\') }}"',
    r'value="\{\{ \$dados\[\'processo_sei\'\] \?\? \'\' \}\}"': r'value="{{ $requerimento->nup_sei ?? \'\' }}"',
    r'value="\{\{ \$dados\[\'cpf_cnpj_requerente\'\] \?\? \'\' \}\}"': r'value="{{ $requerimento->cpf_cnpj_requerente ?? \'\' }}"',
    r'value="\{\{ \$dados\[\'nome_requerente\'\] \?\? \'\' \}\}"': r'value="{{ $requerimento->nome_requerente ?? \'\' }}"',
    r'value="\{\{ \$dados\[\'contato_requerente\'\] \?\? \'\' \}\}"': r'value="{{ $requerimento->contato_requerente ?? \'\' }}"',
    r'value="\{\{ \$dados\[\'cpf_cnpj_representante\'\] \?\? \'\' \}\}"': r'value="{{ $requerimento->cpf_cnpj_representante ?? \'\' }}"',
    r'value="\{\{ \$dados\[\'nome_representante\'\] \?\? \'\' \}\}"': r'value="{{ $requerimento->nome_representante ?? \'\' }}"',
    r'value="\{\{ \$dados\[\'contato_representante\'\] \?\? \'\' \}\}"': r'value="{{ $requerimento->contato_representante ?? \'\' }}"',
    r'value="\{\{ \$dados\[\'projeto_prioritario\'\] \?\? \'Nǜo\' \}\}"': r'value="{{ $requerimento->projeto_prioritario ?? \'Não\' }}"',
    r'value="\{\{ \$dados\[\'projeto_prioritario\'\] \?\? \'Não\' \}\}"': r'value="{{ $requerimento->projeto_prioritario ?? \'Não\' }}"',
    r'value="\{\{ \$dados\[\'prioridade_legal\'\] \?\? \'Nǜo se aplica\' \}\}"': r'value="{{ $requerimento->prioridade_legal ?? \'Não se aplica\' }}"',
    r'value="\{\{ \$dados\[\'prioridade_legal\'\] \?\? \'Não se aplica\' \}\}"': r'value="{{ $requerimento->prioridade_legal ?? \'Não se aplica\' }}"'
}

for k, v in replacements.items():
    text = re.sub(k, v, text)

with open('resources/views/processos/abas/aba1.blade.php', 'w', encoding='utf-8') as f:
    f.write(text)

print("Values re-mapped")
