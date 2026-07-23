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
        Schema::create('foco_drafts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('processo_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('aba', 10);
            $table->json('data');
            $table->timestamps();

            $table->unique(['processo_id', 'user_id', 'aba']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('foco_drafts');
    }
};
