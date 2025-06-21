<?php

namespace Database\Factories;

use App\Models\Projeto;
use Illuminate\Database\Eloquent\Factories\Factory;

class StakeholderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome' => $this->faker->name,
            'cargo' => $this->faker->jobTitle,
            'descricao' => $this->faker->sentence,
            'classificacao' => $this->faker->word,
            'projeto_id' => Projeto::factory(),
        ];
    }
}
