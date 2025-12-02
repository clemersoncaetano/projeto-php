<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AtualizarFilaRequest extends FormRequest
{
    public function rules()
    {
        return [
            'user_id' => ['sometimes', 'integer', 'exists:users,id'],
            'ativo' => ['sometimes', 'boolean'],
        ];
    }
}
