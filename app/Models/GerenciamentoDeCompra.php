<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GerenciamentoDeCompra extends Model
{
    // use HasFactory;
    
    protected $table = 'gerenciamento_de_compras'; 
    
    protected $fillable = [
        'user_id',
        'produto',
        'quantidade',
        'preco',
    ];
}
