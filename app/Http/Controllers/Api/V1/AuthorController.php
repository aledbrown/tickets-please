<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\AuthorFilter;
use App\Http\Requests\Api\V1\StoreUserRequest;
use App\Http\Requests\Api\V1\UpdateUserRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\User;

class AuthorController extends ApiController
{
    public function index(AuthorFilter $filters)
    {
        return UserResource::collection(
            User::select('users.*')
            ->join('tickets', 'users.id', '=', 'tickets.user_id')
            ->filter($filters)
            ->distinct()
            ->paginate()
        );
    }

    public function show(User $author)
    {
        if ($this->include('tickets')) {
            return new UserResource($author->load('tickets'));
        }
        return new UserResource($author);
    }

}
