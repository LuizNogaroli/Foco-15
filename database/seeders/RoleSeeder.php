<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
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

        foreach ($roles as $role) {
            \Spatie\Permission\Models\Role::firstOrCreate(['name' => $role]);
        }
    }
}
