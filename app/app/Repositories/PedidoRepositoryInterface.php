<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PedidoRepositoryInterface
{
    public function findWithRelations(int $id);
    public function paginateWithRelations(int $perPage): LengthAwarePaginator;
}
