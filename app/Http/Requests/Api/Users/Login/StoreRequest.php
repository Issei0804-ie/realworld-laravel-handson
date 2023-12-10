<?php

namespace App\Http\Requests\Api\Users\Login;

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
            'user.email' => ['required', 'email'],
            'user.password' => ['required'],
        ];
    }
}
