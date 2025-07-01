<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListUsersAction
{
    public function execute(array $data): LengthAwarePaginator
    {
        $perPage = $data['per_page'] ?? 15;
        $page = $data['page'] ?? null;

        return User::with('roles')->paginate($perPage, ['*'], 'page', $page);
    }
}