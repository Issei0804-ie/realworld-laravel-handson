<?php

namespace App\Http\Requests\Api\Users;

use App\Http\Requests\Api\APIFormRequest;

class StoreRequest extends APIFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user' => ['array', 'required'],
            'user.username' => ['required', 'string', 'max:255'],
            'user.email' => ['required', 'email', 'unique:users,email'],
            'user.password' => ['required'],
        ];
    }
}
