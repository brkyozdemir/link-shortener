<?php

namespace App\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignupRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => [
                'required_without:phone',
                'unique:users,email',
            ],
            'password' => 'required|min:6|max:16',
            'name' => 'required|string',
            'username' => 'required|string',
        ];
    }
}
