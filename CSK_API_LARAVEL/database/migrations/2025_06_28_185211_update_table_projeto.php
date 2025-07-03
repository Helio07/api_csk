<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('projetos', function (Blueprint $table) {
            $table->string('descricao', 1500)->nullable();
            $table->date('data_inicio')->nullable();
            $table->date('data_final')->nullable();
        });
    }
    public function down(): void
    {
                Schema::table('projetos', function (Blueprint $table) {
            $table->dropColumn(['descricao', 'data_inicio', 'data_final']);
        });
    }
};
