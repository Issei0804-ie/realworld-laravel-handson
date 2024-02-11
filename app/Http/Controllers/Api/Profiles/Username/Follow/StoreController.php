<?php

namespace App\Http\Controllers\Api\Profiles\Username\Follow;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Models\User;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function __invoke(User $user, Request $request)
    {
        $userAccessedThatAPI = $request->user();
        if (!$userAccessedThatAPI->isFollowing($user)) {
            $this->follow($userAccessedThatAPI, $user);
        }


        return response()->json(ProfileResource::make($user, $userAccessedThatAPI));
    }

    private function follow(User $source, User $target): void
    {
        $source->followYou($target);
    }
}
