<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Users\StoreRequest;
use App\Models\User;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $validatedValue = $request->validated();
        $user = User::create([
            'username' => $validatedValue['user']['username'],
            'email' => $validatedValue['user']['email'],
            'password' => bcrypt($validatedValue['user']['password']),
            'bio' => '',
            'image_s3_path' => '',
        ]);

        return response()->json([
            'user' => [
                'email' => $user->email,
                'token' => $user->createToken('token')->plainTextToken,
                'username' => $user->username,
                'bio' => $user->bio,
                'image' => $user->image_s3_path,
            ],
        ]);

    }
}
