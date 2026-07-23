<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabela principal (1:1 com processo)
        Schema::create('foco', function (Blueprint $table) {
            $table->id();
            $table->foreignId('processo_id')->constrained()->cascadeOnDelete()->unique();
            $table->tinyInteger('aba_salva')->default(1)->comment('Ultima aba salva: 1, 2 ou 3');
            $table->timestamps();
        });

        // 2. Aba 1 - Indicacao do Imovel (1:1 com foco)
        Schema::create('foco_aba1', function (Blueprint $table) {
            $table->foreignId('foco_id')->primary()->constrained('foco')->cascadeOnDelete();
            $table->string('conceituacao_imovel')->nullable();
            $table->text('resposta_devolucao')->nullable();
            $table->text('solicitacao_criacao_rip')->nullable();
        });

        // 3. RIPs vinculados (1:N com foco)
        Schema::create('foco_rips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('foco_id')->constrained('foco')->cascadeOnDelete();
            $table->string('numero_rip', 50);
        });

        // 4. Cadastros minimos para areas sem RIP (1:N com foco)
        Schema::create('foco_cadastros_minimos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('foco_id')->constrained('foco')->cascadeOnDelete();
            $table->string('cep', 10)->nullable();
            $table->string('logradouro')->nullable();
            $table->string('numero', 20)->nullable();
            $table->string('complemento')->nullable();
            $table->string('municipio')->nullable();
            $table->string('uf', 2)->nullable();
            $table->decimal('area', 12, 2)->nullable();
            $table->text('observacoes')->nullable();
        });

        // 5. Aba 2 - Diagnostico Preliminar (1:1 com foco)
        Schema::create('foco_aba2', function (Blueprint $table) {
            $table->foreignId('foco_id')->primary()->constrained('foco')->cascadeOnDelete();
            $table->string('situacao_ocupacional')->nullable();
            $table->string('tempo_desocupacao')->nullable();
            $table->string('data_conhecimento_ocupacao')->nullable();
            $table->string('tipo_uso_atual')->nullable();
            $table->string('tipo_uso_especifico_atual')->nullable();
            $table->json('ha_incidencia')->nullable();
            $table->json('incidencia_ambiental')->nullable();
            $table->json('ha_riscos')->nullable();
            $table->json('riscos')->nullable();
            $table->json('ha_restricoes')->nullable();
            $table->json('restricoes')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('geo_cep', 10)->nullable();
            $table->text('observacoes_aba2')->nullable();
        });

        // 6. Aba 3 - Analise de Viabilidade (1:1 com foco)
        Schema::create('foco_aba3', function (Blueprint $table) {
            $table->foreignId('foco_id')->primary()->constrained('foco')->cascadeOnDelete();
            $table->json('dados_analise')->nullable();
            $table->json('proposta_destinacao')->nullable();
            $table->text('justificativa_devolucao')->nullable();
            $table->string('devolucao_para')->nullable()->comment('Indicacao do Imovel ou Diagnostico Preliminar');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('foco_aba3');
        Schema::dropIfExists('foco_aba2');
        Schema::dropIfExists('foco_cadastros_minimos');
        Schema::dropIfExists('foco_rips');
        Schema::dropIfExists('foco_aba1');
        Schema::dropIfExists('foco');
    }
};
