<?php

namespace App\Services\FacturaFilters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FechaInicioFilter implements FacturaFilterInterface
{
    public function apply(Builder $query, Request $request): Builder
    {
        if ($request->filled('fecha_inicio')) {
            $query->whereDate('fecha', '>=', $request->fecha_inicio);
        }
        return $query;
    }
}
