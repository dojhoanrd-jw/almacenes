<?php

namespace App\Services\FacturaFilters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

interface FacturaFilterInterface
{
    public function apply(Builder $query, Request $request): Builder;
}
