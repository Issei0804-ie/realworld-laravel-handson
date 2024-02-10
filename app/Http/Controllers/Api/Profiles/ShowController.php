<?php

namespace App\Http\Controllers\Api\Profiles;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Models\User;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    public function __invoke(User $user, Request $request)
    {
        $userAccessedThatAPI = $request->user();

        return response()->json(
            new ProfileResource($user, $userAccessedThatAPI)
        );
    }
}
