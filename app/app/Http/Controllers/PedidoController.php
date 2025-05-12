<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\PedidoService;
use App\Services\PedidoFilterService;
use App\Repositories\PedidoRepositoryInterface;
use App\Http\Requests\PedidoRequest;
use App\Exceptions\PedidoNotFoundException;
use App\Http\Resources\PedidoCollection;

class PedidoController extends Controller
{
    protected $pedidoService;
    protected $pedidoFilterService;
    protected $pedidoRepository;

    public function __construct(
        PedidoService $pedidoService,
        PedidoFilterService $pedidoFilterService,
        PedidoRepositoryInterface $pedidoRepository
    ) {
        $this->pedidoService = $pedidoService;
        $this->pedidoFilterService = $pedidoFilterService;
        $this->pedidoRepository = $pedidoRepository;
    }

    public function index(Request $request): JsonResponse
    {
        $query = Pedido::query();

        if ($request->filled('cantidad_min')) {
            $query->where('cantidad', '>=', $request->cantidad_min);
        }

        $pedidos = $query->paginate($request->get('per_page', 10));

        return response()->json(new PedidoCollection($pedidos));
    }

    public function store(PedidoRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $resultado = $this->pedidoService->crearPedido($validated);

        if ($resultado['actualizado']) {
            return response()->json([
                'message' => 'Pedido actualizado (cantidad acumulada).',
                'data'    => $resultado['pedido']
            ]);
        }

        return response()->json([
            'message' => 'Pedido creado correctamente.',
            'data'    => $resultado['pedido']
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $pedido = $this->pedidoRepository->findWithRelations($id);

        if (!$pedido) {
            throw new PedidoNotFoundException();
        }

        return response()->json($pedido);
    }

    public function update(PedidoRequest $request, int $id): JsonResponse
    {
        $pedido = $this->pedidoRepository->findWithRelations($id);

        if (!$pedido) {
            throw new PedidoNotFoundException();
        }

        $validated = $request->validated();

        $pedidoActualizado = $this->pedidoService->actualizarPedido($pedido, $validated);

        return response()->json([
            'message' => 'Pedido actualizado correctamente.',
            'data'    => $pedidoActualizado
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $pedido = $this->pedidoRepository->findWithRelations($id);

        if (!$pedido) {
            throw new PedidoNotFoundException();
        }

        $this->pedidoService->eliminarPedido($pedido);

        return response()->json(['message' => 'Pedido eliminado correctamente.'], 200);
    }
}
