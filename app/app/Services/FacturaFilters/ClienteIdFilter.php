<?php

namespace App\Services\FacturaFilters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ClienteIdFilter implements FacturaFilterInterface
{
    public function apply(Builder $query, Request $request): Builder
    {
        if ($request->filled('cliente_id')) {
            $query->where('ClienteId', $request->cliente_id);
        }
        return $query;
    }
}
