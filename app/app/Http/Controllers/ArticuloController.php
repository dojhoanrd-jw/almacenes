<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreArticuloRequest;
use App\Http\Requests\UpdateArticuloRequest;
use App\Services\ArticuloService;

class ArticuloController extends Controller
{
    protected $articuloService;

    public function __construct(ArticuloService $articuloService)
    {
        $this->articuloService = $articuloService;
    }

    public function index(Request $request): JsonResponse
    {
        $query = $this->applyFilters(Articulo::query(), $request);

        if ($request->boolean('with_pedidos')) {
            $query->with('pedidos');
        }

        $articulos = $query->paginate($request->get('per_page', 10));

        return response()->json($articulos);
    }

    public function store(StoreArticuloRequest $request): JsonResponse
    {
        $articulo = $this->articuloService->create($request->validated());

        return response()->json([
            'message' => 'Artículo creado correctamente.',
            'data'    => $articulo
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $query = Articulo::query();

        if (request()->boolean('with_pedidos')) {
            $query->with('pedidos');
        }

        $articulo = $query->findOrFail($id);

        return response()->json($articulo);
    }

    public function update(UpdateArticuloRequest $request, int $id): JsonResponse
    {
        $articulo = $this->articuloService->update($id, $request->validated());
        return response()->json([
            'message' => 'Artículo actualizado correctamente.',
            'data'    => $articulo
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->articuloService->delete($id);
        return response()->json(['message' => 'Artículo eliminado correctamente.'], 200);
    }

    private function applyFilters($query, Request $request)
    {
        if ($request->filled('nombre')) {
            $query->where('nombre_articulo', 'like', '%' . $request->nombre . '%');
        }
        if ($request->filled('precio_min')) {
            $query->where('precio', '>=', $request->precio_min);
        }
        if ($request->filled('precio_max')) {
            $query->where('precio', '<=', $request->precio_max);
        }
        if ($request->filled('stock_min')) {
            $query->where('stock', '>=', $request->stock_min);
        }
        return $query;
    }
}
