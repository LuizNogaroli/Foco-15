import sys

path = r'c:\Users\luizn\Documents\1-PROGRAMAS\Foco-15\docs\historico\nova_aba_administrar_status_20260721_1419.md'
with open(path, 'a', encoding='utf-8') as f:
    f.write('\n## Correção no Carregamento do Resumo da Aba 2 (20260721_1632)\n')
    f.write('Implementado mecanismo de fallback dinâmico em `foco-02-resumo.html`: quando o relatório ainda não estiver gravado especificamente em `tabela_relatorios` (aba=aba2), o script realiza a consulta dos dados em `tabela_requerimentos` (campo `dados_json`), montando o resumo do Diagnóstico Preliminar instantaneamente para exibição nos accordions de revisão (ex: Aba 3).\n')

print("History log updated with foco-02-resumo fix.")
