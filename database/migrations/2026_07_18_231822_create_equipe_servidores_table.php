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
        Schema::create('equipe_servidores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('perfil');           // Equipe Destinação, Chefia, etc.
            $table->string('uf', 2);            // SP, RJ, etc. OU 'NAC' para nacional (C.G., CDE)
            $table->boolean('ativo')->default(true);
            $table->timestamps();

            $table->unique(['user_id', 'perfil', 'uf']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipe_servidores');
    }
};
