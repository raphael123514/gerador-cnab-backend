<?php

namespace App\Domain\Cnab\Actions;

use App\Domain\Cnab\Models\CNABProcessing;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListCnabProcessingsAction
{
    /**
     * Lista os processamentos de CNAB com filtros e paginação.
     *
     * @param  array  $data  Dados validados da requisição.
     */
    public function execute(array $data): LengthAwarePaginator
    {
        $filters = $data['filters'] ?? [];

        $query = CNABProcessing::query()
            ->with('user:id,name');

        $query->when($filters['status'] ?? null, function ($q, $status) {
            $q->where('status', $status);
        });

        $query->when($filters['date_from'] ?? null, function ($q, $dateFrom) {
            $q->whereDate('created_at', '>=', $dateFrom);
        });

        $query->when($filters['date_to'] ?? null, function ($q, $dateTo) {
            $q->whereDate('created_at', '<=', $dateTo);
        });

        $perPage = $data['per_page'] ?? 15;
        $page = $data['page'] ?? null;

        return $query->latest()->paginate(
            perPage: $perPage,
            page: $page
        );
    }
}
