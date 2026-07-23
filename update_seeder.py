with open('database/seeders/DatabaseSeeder.php', 'r', encoding='utf-8') as f:
    text = f.read()

seeder_code = r"""
        \DB::table('requerimentos')->truncate();
        \App\Models\Requerimento::create([
            'numero_requerimento' => 'PR2026001',
            'tipo_requerimento' => 'Regularizar Utilização de Imóvel da União',
            'data_hora_recebimento' => '01/01/2026 14:30',
            'nup_sei' => '10480.002401/2026-66',
            'cpf_cnpj_requerente' => '12.345.678/0001-11',
            'nome_requerente' => 'Prefeitura Municipal A',
            'contato_requerente' => '(11) 98765-4321',
            'cpf_cnpj_representante' => '',
            'nome_representante' => '',
            'contato_representante' => '',
            'projeto_prioritario' => 'Não',
            'prioridade_legal' => 'Não se aplica',
            'documentos_anexados' => [
                ['url' => 'PDF_1_Nononononononono.pdf', 'nome' => 'Requerimento inicial'],
                ['url' => 'PDF_2_Contrato_social.pdf', 'nome' => 'Contrato social e alterações']
            ]
        ]);
"""

import re
if 'requerimentos' not in text:
    text = re.sub(r'public function run\(\): void\n\s*\{', f"public function run(): void\n    {{\n{seeder_code}", text)
    with open('database/seeders/DatabaseSeeder.php', 'w', encoding='utf-8') as f:
        f.write(text)
    print("Seeder updated")
else:
    print("Seeder already contains requerimentos")
