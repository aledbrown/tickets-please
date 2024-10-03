<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreUserRequest;
use App\Http\Requests\Api\V1\UpdateUserRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\User;

class UserController extends ApiController
{
    public function index()
    {
        if ($this->include('tickets')) {
            return UserResource::collection(User::with('tickets')->paginate());
        }
        return UserResource::collection(User::paginate());
    }

    public function store(StoreUserRequest $request)
    {
        //
    }

    public function show(User $user)
    {
        if ($this->include('tickets')) {
            return new UserResource($user->load('tickets'));
        }
        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        //
    }

    public function destroy(User $user)
    {
        //
    }
}
