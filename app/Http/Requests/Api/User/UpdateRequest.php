<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\Api\APIFormRequest;

class UpdateRequest extends APIFormRequest
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
            'user.username' => ['string', 'max:255'],
            'user.email' => ['email'],
            'user.password' => ['string'],
            'user.image' => ['url'],
            'user.bio' => ['string'],
        ];
    }
}
