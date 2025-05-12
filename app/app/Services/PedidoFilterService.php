<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class PedidoFilterService
{
    public function apply(Request $request, Builder $query): Builder
    {
        if ($request->filled('factura_id')) {
            $query->where('FacturaId', $request->factura_id);
        }

        if ($request->filled('articulo_id')) {
            $query->where('ArticuloId', $request->articulo_id);
        }


        return $query;
    }
}
