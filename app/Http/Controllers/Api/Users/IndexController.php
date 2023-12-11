<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class IndexController extends Controller
{
    public function __invoke()
    {
        $user = auth()->user();
        return response()->json(UserResource::make($user));
    }
}
