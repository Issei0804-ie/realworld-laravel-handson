<?php

namespace App\Http\Controllers\Api\Users\Login;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Users\Login\StoreRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $validatedValue = $request->validated();
        if (Auth::attempt(['email' => $validatedValue['user']['email'], 'password' => $validatedValue['user']['password']])) {
            $user = Auth::user();

            return response()->json(UserResource::make($user));
        }

        return response()->json([
            'errors' => [
                'message' => ['メールアドレスまたはパスワードが正しくありません。'],
            ],
        ], 422);
    }
}
