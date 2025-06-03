<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjetoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome' => $this->faker->sentence(3),
            'endereco' => $this->faker->address,
            'area_atuacao' => $this->faker->word,
            'favorito' => $this->faker->boolean,
            'user_id' => User::factory(),
        ];
    }
}
