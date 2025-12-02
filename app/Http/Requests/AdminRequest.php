<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
{
   
    public function authorize(): bool
    {
        return true; 
    }
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:6|confirmed',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.unique' => 'Este e-mail já está em uso.',
            'password.confirmed' => 'As senhas não conferem.',
        ];
    }
}
