<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ServidorSeeder extends Seeder
{
    private array $ufs = [
        'AC','AL','AP','AM','BA','CE','DF','ES','GO',
        'MA','MT','MS','MG','PA','PB','PR','PE','PI',
        'RJ','RN','RS','RO','RR','SC','SP','SE','TO','UC',
    ];

    private array $cargos = [
        'Analista de Infraestrutura',
        'Técnico em Edificações',
        'Engenheiro Civil',
        'Engenheiro Florestal',
        'Arquiteto Urbanista',
        'Técnico em Meio Ambiente',
        'Analista Administrativo',
        'Técnico em Topografia',
        'Geógrafo',
        'Biólogo',
        'Advogado',
        'Analista de Planejamento',
        'Técnico em Agronomia',
        'Engenheiro de Agrimensura',
        'Assessor Jurídico',
        'Analista de Orçamento',
        'Técnico em Contabilidade',
        'Auditor Fiscal',
        'Analista de Sistemas',
        'Secretário Executivo',
    ];

    public function run(): void
    {
        $now = now()->toDateTimeString();
        $rows = [];
        $cpfBase = 10000000000;
        $senhaHash = Hash::make('password');

        foreach ($this->ufs as $ufIdx => $uf) {
            $ufLower = strtolower($uf);
            for ($i = 0; $i < 26; $i++) {
                $letra = chr(65 + $i);
                $cpf = (string) ($cpfBase + ($i * 28 + $ufIdx) * 7 + 1);
                $cpf = substr($cpf, 0, 11);

                $rows[] = [
                    'name'       => "{$uf}-Servidor-{$letra}",
                    'email'      => "{$ufLower}.servidor." . strtolower($letra) . "@spu.gov.br",
                    'cpf'        => $cpf,
                    'cargo'      => $this->cargos[$i % count($this->cargos)],
                    'telefone'   => sprintf('61-99%d%d%d-%d%d%d%d', $i % 10, $i % 7, $i % 3, $i % 5, $i % 9, $i % 4, $i % 6),
                    'uf'         => $uf,
                    'password'   => $senhaHash,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        foreach (array_chunk($rows, 100) as $chunk) {
            DB::table('users')->insert($chunk);
        }

        $this->command->info(count($rows) . ' servidores criados.');
    }
}
