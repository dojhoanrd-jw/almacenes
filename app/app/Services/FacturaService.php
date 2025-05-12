<?php

namespace App\Services;

use App\Models\Factura;
use Illuminate\Http\Request;
use App\Services\FacturaFilters\FacturaFilterInterface;
use App\Services\FacturaFilters\ClienteIdFilter;
use App\Services\FacturaFilters\FechaInicioFilter;
use App\Services\FacturaFilters\FechaFinFilter;

class FacturaService implements FacturaServiceInterface
{
    protected $filters = [
        ClienteIdFilter::class,
        FechaInicioFilter::class,
        FechaFinFilter::class,
    ];

    public function list(Request $request)
    {
        $query = Factura::with('cliente', 'pedidos');

        foreach ($this->filters as $filterClass) {
            /** @var FacturaFilterInterface $filter */
            $filter = app($filterClass);
            $query = $filter->apply($query, $request);
        }

        return $query->paginate($request->get('per_page', 10));
    }

    public function create(array $data)
    {
        return Factura::create($data);
    }

    public function findWithRelations(int $id)
    {
        return Factura::with('cliente', 'pedidos')->find($id);
    }

    public function update(int $id, array $data)
    {
        $factura = Factura::find($id);
        if (!$factura) {
            return null;
        }
        $factura->update($data);
        return $factura;
    }

    public function delete(int $id)
    {
        $factura = Factura::find($id);
        if (!$factura) {
            return false;
        }
        $factura->delete();
        return true;
    }
}
