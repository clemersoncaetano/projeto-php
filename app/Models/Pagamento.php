<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    protected $fillable = [
        'user_id',
        'compra_id',
        'valor',
        'metodo',
        'status',
        'codigo_pix'
    ];
}
