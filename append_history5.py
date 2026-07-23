import sys

path = r'c:\Users\luizn\Documents\1-PROGRAMAS\Foco-15\docs\historico\nova_aba_administrar_status_20260721_1419.md'
with open(path, 'a', encoding='utf-8') as f:
    f.write('\n## Regra de Negócio Confirmada: Competência de Edição da Aba 3 (20260721_1620)\n')
    f.write('Confirmada e garantida a regra de negócio estrita de que na Aba 3 (Análise de Viabilidade e Proposta de Destinação), SOMENTE o perfil "Técnico — Destinação" (`DESTINACAO` / `Equipe Destinação`) e Administrador possuem competência para editar os campos do formulário. Perfis hierárquicos superiores (Chefia, Coordenação, Superintendência, etc.) não editam a Aba 3 (atuando posteriormente na Aba 7 de deliberação/manifestação).\n')

print("History log updated with business rule confirmation.")
