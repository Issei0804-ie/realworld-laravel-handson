<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class APIFormRequest extends FormRequest
{
    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator): void
    {
        $response = response()->json([
            'errors' => $validator->errors(),
        ], 422);
        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
