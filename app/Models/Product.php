<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Identificando que poderão vir mais de 1 imagem
    protected $casts = ['imagens' => 'array'];

    protected $fillable = [
        'nome',
        'preco',
        'composicao',
        'tamanho',
        'quantidade',
        'imagens',
        'category_id'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }    
}
