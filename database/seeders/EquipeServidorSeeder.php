<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class EquipeServidorSeeder extends Seeder
{
    private array $perfis = [
        'Equipe Destinação',
        'Equipe Caracterização',
        'Chefia',
        'Coordenação',
        'Superintendência',
        'Equipe C.G.',
        'Coordenação-Geral',
        'Direção',
        'CDE',
    ];

    public function run(): void
    {
        $ufs = [
            'AC','AL','AP','AM','BA','CE','DF','ES','GO',
            'MA','MT','MS','MG','PA','PB','PR','PE','PI',
            'RJ','RN','RS','RO','RR','SC','SP','SE','TO',
        ];

        $servidoresPorUf = User::where('uf', '!=', 'UC')
            ->where('uf', '!=', '')
            ->get()
            ->groupBy('uf');

        $now = now()->toDateTimeString();
        $rows = [];

        foreach ($ufs as $uf) {
            $disponiveis = $servidoresPorUf->get($uf, collect());
            if ($disponiveis->isEmpty()) continue;

            $indices = range(0, $disponiveis->count() - 1);
            shuffle($indices);

            $pos = 0;
            foreach ($this->perfis as $perfil) {
                $qtd = match ($perfil) {
                    'Equipe Destinação'    => rand(2, 4),
                    'Equipe Caracterização'=> rand(2, 4),
                    'Chefia'               => 1,
                    'Coordenação'          => 1,
                    'Superintendência'     => 1,
                    'Equipe C.G.'          => rand(2, 3),
                    'Coordenação-Geral'    => 1,
                    'Direção'              => 1,
                    'CDE'                  => rand(2, 3),
                    default                => 1,
                };

                for ($j = 0; $j < $qtd && $pos < count($indices); $j++, $pos++) {
                    $rows[] = [
                        'user_id'    => $disponiveis[$indices[$pos]]->id,
                        'perfil'     => $perfil,
                        'uf'         => $uf,
                        'ativo'      => true,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            }
        }

        foreach (array_chunk($rows, 200) as $chunk) {
            DB::table('equipe_servidores')->insert($chunk);
        }

        $this->command->info(count($rows) . ' vínculos de equipe criados.');
    }
}
