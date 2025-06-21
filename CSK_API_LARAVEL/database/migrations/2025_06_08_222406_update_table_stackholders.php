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
        Schema::table('stakeholders', function (Blueprint $table) {
            // Remove o campo existente
            $table->dropColumn('classificacao');

            // Adiciona o novo campo como chave estrangeira
            $table->unsignedBigInteger('classificacao_id')->nullable();
            $table->foreign('classificacao_id')->references('id')->on('classificacoes')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stakeholders', function (Blueprint $table) {
            // Remove a chave estrangeira e o campo
            $table->dropForeign(['classificacao_id']);
            $table->dropColumn('classificacao_id');

            // Restaura o campo original
            $table->string('classificacao')->nullable();
        });
    }
};
