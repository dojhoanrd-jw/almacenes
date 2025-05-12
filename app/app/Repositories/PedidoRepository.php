<?php

namespace App\Repositories;

use App\Models\Pedido;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PedidoRepository implements PedidoRepositoryInterface
{
    public function findWithRelations(int $id)
    {
        return Pedido::with('factura', 'articulo')->find($id);
    }

    public function paginateWithRelations(int $perPage): LengthAwarePaginator
    {
        return Pedido::with('factura', 'articulo')->paginate($perPage);
    }
}
