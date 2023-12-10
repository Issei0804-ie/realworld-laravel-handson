<?php

namespace App\Http\Controllers\Api\Users\Login;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Users\Login\StoreRequest;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $validatedValue = $request->validated();
        if (Auth::attempt(['email' => $validatedValue['user']['email'], 'password' => $validatedValue['user']['password']])) {
            $user = Auth::user();
            return response()->json([
                'user' => [
                    'email' => $user->email,
                    'token' => $user->createToken('token')->plainTextToken,
                    'username' => $user->username,
                    'bio' => $user->bio,
                    'image' => $user->image_s3_path,
                ]
            ]);
        }
        return response()->json([
            'errors' => [
                'message' => ['メールアドレスまたはパスワードが正しくありません。']
            ]
        ], 422);
    }
}
