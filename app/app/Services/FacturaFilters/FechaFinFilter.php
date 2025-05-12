<?php

namespace App\Services\FacturaFilters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FechaFinFilter implements FacturaFilterInterface
{
    public function apply(Builder $query, Request $request): Builder
    {
        if ($request->filled('fecha_fin')) {
            $query->whereDate('fecha', '<=', $request->fecha_fin);
        }
        return $query;
    }
}
