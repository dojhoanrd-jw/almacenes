<?php

namespace App\Http\Controllers;

use App\Services\FacturaServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\FacturaResource;

class FacturaController extends Controller
{
    protected $facturaService;

    public function __construct(FacturaServiceInterface $facturaService)
    {
        $this->facturaService = $facturaService;
    }

    /**
     * Listar facturas con paginación y filtros opcionales.
     */
    public function index(Request $request): JsonResponse
    {
        $facturas = $this->facturaService->list($request);
        return response()->json([
            'data' => FacturaResource::collection($facturas),
            'meta' => [
                'current_page' => $facturas->currentPage(),
                'last_page' => $facturas->lastPage(),
                'per_page' => $facturas->perPage(),
                'total' => $facturas->total(),
            ]
        ]);
    }

    /**
     * Crear una nueva factura.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'ClienteId' => 'required|exists:tblcliente,ClienteId',
            'fecha'     => 'required|date',
            'total'     => 'required|numeric|min:0',
        ]);

        $factura = $this->facturaService->create($validated);

        return response()->json([
            'message' => 'Factura creada correctamente.',
            'data'    => new FacturaResource($factura)
        ], 201);
    }

    /**
     * Mostrar una factura específica.
     */
    public function show(int $id): JsonResponse
    {
        $factura = $this->facturaService->findWithRelations($id);

        if (!$factura) {
            return response()->json(['message' => 'Factura no encontrada.'], 404);
        }

        return response()->json(new FacturaResource($factura));
    }

    /**
     * Actualizar una factura existente.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'ClienteId' => 'sometimes|required|exists:tblcliente,ClienteId',
            'fecha'     => 'sometimes|required|date',
            'total'     => 'sometimes|required|numeric|min:0',
        ]);

        $factura = $this->facturaService->update($id, $validated);

        if (!$factura) {
            return response()->json(['message' => 'Factura no encontrada.'], 404);
        }

        return response()->json([
            'message' => 'Factura actualizada correctamente.',
            'data'    => new FacturaResource($factura)
        ]);
    }

    /**
     * Eliminar una factura.
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->facturaService->delete($id);

        if (!$deleted) {
            return response()->json(['message' => 'Factura no encontrada.'], 404);
        }

        return response()->json(['message' => 'Factura eliminada correctamente.'], 200);
    }
}
