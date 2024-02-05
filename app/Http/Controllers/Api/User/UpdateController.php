<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\UpdateRequest;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request)
    {
        $user = auth()->user();
        $user->fill($this->transformParams($request));
        $user->save();
        return response()->json(['user' => $user]);
    }

    private function transformParams(UpdateRequest $request)
    {
        $params = $request->validated()['user'];
        if (isset($params['image'])) {
            $params['image_s3_path'] = $params['image'];
            unset($params['image']);
        }
        return $params;
    }
}
