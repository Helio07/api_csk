<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stakeholder extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'cargo',
        'descricao',
        'classificacao',
        'projeto_id',
    ];

    public function projeto()
    {
        return $this->belongsTo(Projeto::class);
    }

    /**
     * Relação com o modelo Classificacao.
     */
    public function classificacao()
    {
        return $this->belongsTo(Classificacao::class, 'classificacao_id');
    }
}
