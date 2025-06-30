<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Actions\User\CreateUserAction;

class UserController extends Controller
{
    public function store(StoreUserRequest $request, CreateUserAction $createUserAction)
    {
        $data = $request->validated();
        $user = $createUserAction->execute($data);
        return new UserResource($user);
    }
}
