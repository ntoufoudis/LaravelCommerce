<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

final class ProfileController extends Controller
{
    public function index(Request $request): User
    {
        return $request->user();
    }

    public function update(UpdateUserRequest $request): User
    {
        $user = $request->user();
        $user->update($request->validated());

        return $user;
    }
}
