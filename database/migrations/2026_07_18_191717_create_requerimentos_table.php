<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('requerimentos', function (Blueprint $table) {
            $table->string('numero_requerimento')->primary();
            $table->string('tipo_requerimento')->nullable();
            $table->string('data_hora_recebimento')->nullable();
            $table->string('nup_sei')->nullable();
            $table->string('cpf_cnpj_requerente')->nullable();
            $table->string('nome_requerente')->nullable();
            $table->string('contato_requerente')->nullable();
            $table->string('cpf_cnpj_representante')->nullable();
            $table->string('nome_representante')->nullable();
            $table->string('contato_representante')->nullable();
            $table->string('projeto_prioritario')->nullable();
            $table->string('prioridade_legal')->nullable();
            $table->json('documentos_anexados')->nullable(); // Para lista de PDFs do portal
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requerimentos');
    }
};
