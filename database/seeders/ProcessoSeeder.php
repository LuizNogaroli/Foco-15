<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Processo;
use App\Models\Requerimento;

class ProcessoSeeder extends Seeder
{
    public function run(): void
    {
        $tiposRequerimento = [
            'Alterar Regime ou Contrato de Utilização de Imóvel da União',
            'Autorização de passagem em imóveis da União',
            'Entrega para Aquicultura',
            'Obter Autorização de Obras em Imóvel da União',
            'Obter Cessão de Uso de Espaço Físico em Águas Públicas',
            'Obter Permissão de Uso para Eventos em Imóvel da União',
            'Regularizar Utilização de Imóvel da União',
            'Obter a Gestão Municipal de Praias Marítimas',
            'Solicitar imóvel para uso da Administração Pública e Entidades sem Fins Lucrativos',
            'Adquirir Imóvel Aforado da União por Remição',
        ];

        $municipiosPorUf = [
            'AC' => ['Rio Branco', 'Cruzeiro do Sul', 'Sena Madureira', 'Tarauacá', 'Feijó'],
            'AL' => ['Maceió', 'Arapiraca', 'Palmeira dos Índios', 'Rio Largo', 'Penedo'],
            'AP' => ['Macapá', 'Santana', 'Laranjal do Jari', 'Oiapoque', 'Mazagão'],
            'AM' => ['Manaus', 'Parintins', 'Itacoatiara', 'Manacapuru', 'Coari'],
            'BA' => ['Salvador', 'Feira de Santana', 'Vitória da Conquista', 'Camaçari', 'Ilhéus'],
            'CE' => ['Fortaleza', 'Caucaia', 'Juazeiro do Norte', 'Maracanaú', 'Sobral'],
            'DF' => ['Brasília', 'Ceilândia', 'Taguatinga', 'Samambaia', 'Plano Piloto'],
            'ES' => ['Vitória', 'Vila Velha', 'Serra', 'Cariacica', 'Linhares'],
            'GO' => ['Goiânia', 'Aparecida de Goiânia', 'Anápolis', 'Rio Verde', 'Luziânia'],
            'MA' => ['São Luís', 'Imperatriz', 'São José de Ribamar', 'Timon', 'Caxias'],
            'MT' => ['Cuiabá', 'Várzea Grande', 'Rondonópolis', 'Sinop', 'Tangará da Serra'],
            'MS' => ['Campo Grande', 'Dourados', 'Três Lagoas', 'Corumbá', 'Ponta Porã'],
            'MG' => ['Belo Horizonte', 'Uberlândia', 'Contagem', 'Juiz de Fora', 'Betim'],
            'PA' => ['Belém', 'Ananindeua', 'Santarém', 'Marabá', 'Castanhal'],
            'PB' => ['João Pessoa', 'Campina Grande', 'Santa Rita', 'Patos', 'Bayeux'],
            'PR' => ['Curitiba', 'Londrina', 'Maringá', 'Ponta Grossa', 'Cascavel'],
            'PE' => ['Recife', 'Jaboatão dos Guararapes', 'Olinda', 'Caruaru', 'Petrolina'],
            'PI' => ['Teresina', 'Parnaíba', 'Picos', 'Piripiri', 'Floriano'],
            'RJ' => ['Rio de Janeiro', 'São Gonçalo', 'Duque de Caxias', 'Nova Iguaçu', 'Niterói'],
            'RN' => ['Natal', 'Mossoró', 'Parnamirim', 'São Gonçalo do Amarante', 'Macaíba'],
            'RS' => ['Porto Alegre', 'Caxias do Sul', 'Pelotas', 'Canoas', 'Santa Maria'],
            'RO' => ['Porto Velho', 'Ji-Paraná', 'Ariquemes', 'Vilhena', 'Cacoal'],
            'RR' => ['Boa Vista', 'Rorainópolis', 'Caracaraí', 'Pacaraima', 'Alto Alegre'],
            'SC' => ['Florianópolis', 'Joinville', 'Blumenau', 'São José', 'Chapecó'],
            'SP' => ['São Paulo', 'Guarulhos', 'Campinas', 'São Bernardo do Campo', 'Santo André'],
            'SE' => ['Aracaju', 'Nossa Senhora do Socorro', 'Lagarto', 'Itabaiana', 'São Cristóvão'],
            'TO' => ['Palmas', 'Araguaína', 'Gurupi', 'Porto Nacional', 'Paraíso do Tocantins'],
        ];

        $interessados = [
            ['nome' => 'Prefeitura Municipal de São Paulo', 'doc' => '46.373.700/0001-39'],
            ['nome' => 'Prefeitura Municipal do Rio de Janeiro', 'doc' => '42.104.700/0001-00'],
            ['nome' => 'Prefeitura Municipal de Belo Horizonte', 'doc' => '18.709.700/0001-04'],
            ['nome' => 'Prefeitura Municipal de Curitiba', 'doc' => '76.535.764/0001-13'],
            ['nome' => 'Prefeitura Municipal de Salvador', 'doc' => '14.442.403/0001-01'],
            ['nome' => 'Prefeitura Municipal de Fortaleza', 'doc' => '07.127.731/0001-30'],
            ['nome' => 'Prefeitura Municipal de Brasília', 'doc' => '00.039.701/0001-26'],
            ['nome' => 'Prefeitura Municipal de Porto Alegre', 'doc' => '12.509.736/0001-02'],
            ['nome' => 'Prefeitura Municipal de Manaus', 'doc' => '25.738.404/0001-38'],
            ['nome' => 'Prefeitura Municipal de Goiânia', 'doc' => '01.257.541/0001-91'],
            ['nome' => 'Empresa Brasileira de Correios e Telégrafos', 'doc' => '34.931.806/0001-76'],
            ['nome' => 'Petrobras Distribuidora S.A.', 'doc' => '42.260.739/0001-30'],
            ['nome' => 'Companhia de Água e Esgoto do Ceará', 'doc' => '07.532.369/0001-06'],
            ['nome' => 'Fundação Oswaldo Cruz', 'doc' => '33.453.598/0001-92'],
            ['nome' => 'Universidade Federal do Rio de Janeiro', 'doc' => '29.979.036/0001-40'],
            ['nome' => 'Instituto do Patrimônio Histórico e Artístico Nacional', 'doc' => '00.376.800/0001-04'],
            ['nome' => 'Carlos Eduardo Silva de Oliveira', 'doc' => '123.456.789-00'],
            ['nome' => 'Maria Fernanda Costa Santos', 'doc' => '987.654.321-00'],
            ['nome' => 'João Pedro Almeida Lima', 'doc' => '456.789.123-00'],
            ['nome' => 'Ana Beatriz Rodrigues Souza', 'doc' => '321.654.987-00'],
            ['nome' => 'Lucas Henrique Martins Ferreira', 'doc' => '789.123.456-00'],
            ['nome' => 'Gabriela Araújo Nascimento', 'doc' => '654.321.987-00'],
            ['nome' => 'Ricardo Augusto Pereira', 'doc' => '147.258.369-00'],
            ['nome' => 'Juliana Batista dos Reis', 'doc' => '963.852.741-00'],
            ['nome' => 'Marina Consultoria Imobiliária Ltda', 'doc' => '11.222.333/0001-44'],
            ['nome' => 'Construtora Horizonte Ltda', 'doc' => '22.333.444/0001-55'],
            ['nome' => 'Associação Comercial do Pará', 'doc' => '33.444.555/0001-66'],
            ['nome' => 'Sociedade Civil de Pesquisa e Desenvolvimento', 'doc' => '44.555.666/0001-77'],
            ['nome' => 'Igreja Evangélica Comunidade Cristã', 'doc' => '55.666.777/0001-88'],
            ['nome' => 'Clube Atlântico de Natação', 'doc' => '66.777.888/0001-99'],
        ];

        $telefones = [
            '(11) 98765-4321', '(21) 99876-5432', '(31) 98876-5432',
            '(41) 99765-4321', '(71) 98654-3210', '(85) 99543-2109',
            '(61) 99432-1098', '(51) 99321-0987', '(92) 99210-9876',
            '(62) 99109-8765', '(86) 98098-7654', '(98) 97987-6543',
            '(91) 96876-5432', '(82) 95765-4321', '(83) 94654-3210',
            '(99) 93543-2109', '(96) 92432-1098', '(69) 91321-0987',
            '(65) 90210-9876', '(84) 99109-8765', '(67) 98098-7654',
            '(75) 97987-6543', '(79) 96876-5432', '(48) 95765-4321',
            '(88) 94654-3210', '(81) 93543-2109', '(74) 92432-1098',
        ];

        $prioridades = ['Não se aplica', 'Não se aplica', 'Não se aplica', 'Não se aplica', 'Moradia', 'Utilidade Pública'];

        $prefixos = [];

        for ($i = 0; $i < 60; $i++) {
            $uf = array_rand($municipiosPorUf);

            if (!isset($prefixos[$uf])) {
                $prefixos[$uf] = 0;
            }
            $prefixos[$uf]++;
            $numero = $uf . '2026' . str_pad($prefixos[$uf], 3, '0', STR_PAD_LEFT);

            $municipio = $municipiosPorUf[$uf][array_rand($municipiosPorUf[$uf])];
            $interessado = $interessados[array_rand($interessados)];
            $telefone = $telefones[array_rand($telefones)];
            $tipo = $tiposRequerimento[array_rand($tiposRequerimento)];
            $prioridade = $prioridades[array_rand($prioridades)];

            $mes = rand(1, 6);
            $dia = rand(1, 28);
            $hora = rand(8, 17);
            $minuto = rand(0, 59);
            $dataRecebimento = sprintf('%02d/%02d/2026 %02d:%02d', $dia, $mes, $hora, $minuto);
            $sei = sprintf('%05d.%06d/2026-%02d', rand(10000, 99999), rand(100000, 999999), rand(10, 99));

            $docRep = '';
            $nomeRep = '';
            $contatoRep = '';
            if (rand(0, 3) === 0) {
                $rep = $interessados[array_rand($interessados)];
                $docRep = $rep['doc'];
                $nomeRep = $rep['nome'];
                $contatoRep = $telefones[array_rand($telefones)];
            }

            Processo::create([
                'numero_requerimento' => $numero,
                'status_atual' => 'Aguardando Análise',
                'tipo_requerimento' => $tipo,
                'uf' => $uf,
                'municipio' => $municipio,
                'tramitacao' => 'Normal',
            ]);

            Requerimento::create([
                'numero_requerimento' => $numero,
                'tipo_requerimento' => $tipo,
                'data_hora_recebimento' => $dataRecebimento,
                'nup_sei' => $sei,
                'cpf_cnpj_requerente' => $interessado['doc'],
                'nome_requerente' => $interessado['nome'],
                'contato_requerente' => $telefone,
                'cpf_cnpj_representante' => $docRep,
                'nome_representante' => $nomeRep,
                'contato_representante' => $contatoRep,
                'projeto_prioritario' => 'Não',
                'prioridade_legal' => $prioridade,
                'documentos_anexados' => [
                    ['url' => "PDF_1_Requerimento_{$numero}.pdf", 'nome' => 'Requerimento inicial'],
                    ['url' => "PDF_2_Documento_{$numero}.pdf", 'nome' => 'Documento de identificação'],
                ],
            ]);
        }

        $this->command->info('60 processos e requerimentos criados com sucesso.');
    }
}
