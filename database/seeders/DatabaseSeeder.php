<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        \Illuminate\Support\Facades\DB::table('requerimentos')->truncate();
        \Illuminate\Support\Facades\DB::table('processos')->truncate();
        \Illuminate\Support\Facades\DB::table('equipe_servidores')->truncate();
        \Illuminate\Support\Facades\DB::table('users')->truncate();

        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            ServidorSeeder::class,
            EquipeServidorSeeder::class,
            ProcessoSeeder::class,
        ]);
    }
}
