<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CriarFilaRequest extends FormRequest
{
    public function rules()
    {
        return [
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'ativo' => ['required', 'boolean'],
        ];
    }
}
