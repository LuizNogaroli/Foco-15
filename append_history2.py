import sys

path = r'c:\Users\luizn\Documents\1-PROGRAMAS\Foco-15\docs\historico\nova_aba_administrar_status_20260721_1419.md'
with open(path, 'a', encoding='utf-8') as f:
    f.write('\n## Correção Crítica do Identificador do Processo em show.blade.php (20260721_1610)\n')
    f.write('Identificado a causa raiz da mensagem "Nenhum relatório salvo...": o layout master `show.blade.php` gravava no `localStorage.setItem("CURRENT_PROCESS_ID", ...)` o ID numérico sequencial interno do Laravel (ex: 44) em vez do Código do Requerimento oficial (ex: AC2026002). Como os relatórios em `tabela_relatorios` e os dados em `tabela_requerimentos` utilizam o código como chave (`numero_requerimento`), a consulta no iframe zerava e caía no aviso de relatório ausente. Corrigido `show.blade.php` para utilizar `$processo->numero_requerimento` e adicionado fallback de identificador nos relatórios resumo.\n')

print("History log appended successfully.")
