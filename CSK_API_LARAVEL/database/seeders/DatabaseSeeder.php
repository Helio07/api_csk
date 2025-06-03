<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Projeto;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Projeto::factory()->create([
            'nome' => 'Projeto Exemplo',
            'endereco' => 'Rua Exemplo, 123',
            'area_atuacao' => 'Educação',
            'favorito' => true,
            'user_id' => 1, // Certifique-se de que o usuário com ID 1 existe
        ]);
    }
}
