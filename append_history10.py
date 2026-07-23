import sys

path = r'c:\Users\luizn\Documents\1-PROGRAMAS\Foco-15\docs\historico\nova_aba_administrar_status_20260721_1419.md'
with open(path, 'a', encoding='utf-8') as f:
    f.write('\n## Resgate Triplo de Dados para o Accordion de RIPs/Cadastros Mínimos na Aba 3 (20260721_1636)\n')
    f.write('Implementado mecanismo de consulta tripla com fallback automático no accordion "RIP(s) ou Cadastro(s) Mínimo(s)" em `aba3.blade.php`: a consulta busca primeiro na `tabela_indicacao` do Supabase; em caso de ausência, recorre a `tabela_requerimentos`; e por fim, consome diretamente as relações do banco MySQL local (`$processo->foco->rips` e `$processo->foco->cadastrosMinimos`), garantindo que os imóveis e cadastros associados apareçam de forma consistente em qualquer estado do processo.\n')

print("History log updated with RIP accordion fallback fix.")
