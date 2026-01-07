<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class GerenciamentoDeFila extends Model
{
    protected $table = 'gerenciamento_filas';
    
    protected $fillable = [
        'user_id',
        'position',
        'ativo'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
