<?php

namespace App\Http\Controllers;

use App\Domain\User\Actions\CreateUserAction;
use App\Domain\User\Actions\ListUsersAction;
use App\Domain\User\Requests\ListUserRequest;
use App\Domain\User\Requests\StoreUserRequest;
use App\Domain\User\Resources\UserResource;

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
