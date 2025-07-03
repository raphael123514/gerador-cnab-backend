<?php

namespace App\Http\Controllers;

use App\Domain\Auth\Actions\LoginAction;
use App\Domain\Auth\Requests\LoginRequest;
use App\Domain\Auth\Resources\AuthResource;

class AuthController extends Controller
{
    public function __construct(private LoginAction $loginAction) {}

    public function login(LoginRequest $request)
    {
        $result = $this->loginAction->execute($request->email, $request->password);

        if (! $result) {
            return response()->json(['message' => 'Credenciais inválidas'], 401);
        }

        return new AuthResource($result);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Desconectado com sucesso']);
    }
}
