import sys

path = r'c:\Users\luizn\Documents\1-PROGRAMAS\Foco-15\docs\historico\nova_aba_administrar_status_20260721_1419.md'
with open(path, 'a', encoding='utf-8') as f:
    f.write('\n## Correção nos Caminhos do Estilo de Relatórios (report.css) (20260721_1614)\n')
    f.write('Identificado o motivo do relatório ser renderizado sem formatação CSS dentro dos seções/accordions: as páginas de resumo (como `foco-01-resumo.html`) apontavam para o caminho relativo `report.css`, porém o arquivo CSS estava localizado em `public/css/report.css`. O arquivo foi duplicado para a raiz pública `public/report.css` e as tags de estilo de todos os arquivos HTML em `public/` foram atualizadas para carregar tanto `css/report.css` quanto `report.css`, garantindo a aplicação dos estilos visuais.\n')

print("History log appended successfully.")
