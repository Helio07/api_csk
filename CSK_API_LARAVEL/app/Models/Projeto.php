<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projeto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'endereco',
        'area_atuacao',
        'favorito',
        'user_id',
        'descricao',      
        'data_inicio',   
        'data_final', 
    ];

    protected $casts = [
        'favorito' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
