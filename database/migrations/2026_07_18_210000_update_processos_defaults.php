<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Atualizar default do status
        DB::table('processos')->where('status_atual', 'Em Análise')->update(['status_atual' => 'Aguardando Análise']);
        Schema::table('processos', function (Blueprint $table) {
            $table->string('status_atual')->default('Aguardando Análise')->change();
        });

        // Garantir que tramitacao exista com default correto
        $hasCol = Schema::hasColumn('processos', 'tramitacao');
        if (!$hasCol) {
            Schema::table('processos', function (Blueprint $table) {
                $table->string('tramitacao')->default('Normal')->after('uf');
            });
        }
    }

    public function down(): void
    {
        Schema::table('processos', function (Blueprint $table) {
            $table->string('status_atual')->default('Em Análise')->change();
        });
    }
};
