<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\ListUserRequest;
use App\Http\Resources\UserResource;
use App\Actions\User\CreateUserAction;
use App\Actions\User\ListUsersAction;

class UserController extends Controller
{
    public function index(ListUserRequest $request, ListUsersAction $listUsersAction)
    {
        $users = $listUsersAction->execute($request->validated());

        return UserResource::collection($users);
    }

    public function store(StoreUserRequest $request, CreateUserAction $createUserAction)
    {
        $data = $request->validated();
        $user = $createUserAction->execute($data);
        return new UserResource($user);
    }
}
