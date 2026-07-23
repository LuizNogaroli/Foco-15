<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = [
            ['name' => 'Luiz Admin',           'email' => 'admin@spu.gov.br',       'cpf' => '12345678901', 'role' => 'Direção',            'uf' => 'UC', 'cargo' => 'Diretor', 'telefone' => '61-99999-0001'],
            ['name' => 'Técnico Destinação',   'email' => 'destinacao@spu.gov.br',   'cpf' => '23456789012', 'role' => 'Equipe Destinação',   'uf' => 'SP', 'cargo' => 'Analista', 'telefone' => '61-99999-0002'],
            ['name' => 'Técnico Caracterização','email' => 'caracterizacao@spu.gov.br','cpf' => '34567890123', 'role' => 'Equipe Caracterização','uf' => 'SP', 'cargo' => 'Analista', 'telefone' => '61-99999-0003'],
            ['name' => 'Chefia SPU/SP',        'email' => 'chefia@spu.gov.br',       'cpf' => '45678901234', 'role' => 'Chefia',              'uf' => 'SP', 'cargo' => 'Chefe', 'telefone' => '61-99999-0004'],
            ['name' => 'Coordenação SPU/SP',   'email' => 'coordenacao@spu.gov.br',  'cpf' => '56789012345', 'role' => 'Coordenação',         'uf' => 'SP', 'cargo' => 'Coordenador', 'telefone' => '61-99999-0005'],
            ['name' => 'Superintendente SP',   'email' => 'superintendencia@spu.gov.br','cpf' => '67890123456','role' => 'Superintendência',   'uf' => 'SP', 'cargo' => 'Superintendente', 'telefone' => '61-99999-0006'],
            ['name' => 'Equipe C.G.',          'email' => 'cg@spu.gov.br',           'cpf' => '78901234567', 'role' => 'Equipe C.G.',         'uf' => 'UC', 'cargo' => 'Analista', 'telefone' => '61-99999-0007'],
            ['name' => 'Coordenação-Geral',    'email' => 'coordgeral@spu.gov.br',   'cpf' => '89012345678', 'role' => 'Coordenação-Geral',   'uf' => 'UC', 'cargo' => 'Coordenador-Geral', 'telefone' => '61-99999-0008'],
            ['name' => 'Diretor SPU',          'email' => 'direcao@spu.gov.br',      'cpf' => '90123456789', 'role' => 'Direção',             'uf' => 'UC', 'cargo' => 'Diretor', 'telefone' => '61-99999-0009'],
            ['name' => 'CDE',                  'email' => 'cde@spu.gov.br',          'cpf' => '01234567890', 'role' => 'CDE',                 'uf' => 'UC', 'cargo' => 'Membro CDE', 'telefone' => '61-99999-0010'],
        ];

        $senhaHash = bcrypt('password');

        foreach ($usuarios as $u) {
            $user = \App\Models\User::create([
                'name' => $u['name'],
                'email' => $u['email'],
                'cpf' => $u['cpf'],
                'cargo' => $u['cargo'] ?? null,
                'telefone' => $u['telefone'] ?? null,
                'password' => $senhaHash,
                'uf' => $u['uf'],
            ]);
            $user->assignRole($u['role']);
        }
    }
}
