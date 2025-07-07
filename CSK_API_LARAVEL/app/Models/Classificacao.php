<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classificacao extends Model
{
    use HasFactory;

    /**
     * Relação com o modelo Stakeholder.
     */
    public function stakeholders()
    {
        return $this->hasMany(Stakeholder::class, 'classificacao_id');
    }
}
