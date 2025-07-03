<?php

namespace App\Domain\User\Actions;

use App\Domain\User\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListUsersAction
{
    public function execute(array $data): LengthAwarePaginator
    {
        $perPage = $data['per_page'] ?? 15;
        $page = $data['page'] ?? null;

        return User::with('roles')->latest()->paginate(
                perPage: $perPage,
                page: $page
        );
    }
}