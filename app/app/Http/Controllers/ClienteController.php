<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\ClienteService;
use App\Models\Cliente;
use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Http\Resources\ClienteResource;
use App\Exceptions\ClienteNotFoundException;

class ClienteController extends Controller
{
    protected $clienteService;

    public function __construct(ClienteService $clienteService)
    {
        $this->clienteService = $clienteService;
    }

    private function apiResponse($body, $status = 200): JsonResponse
    {
        return response()->json($body, $status);
    }

    public function index(Request $request): JsonResponse
    {
        $clientes = Cliente::paginate($request->get('per_page', 10));
        return response()->json($clientes);
    }

    public function store(StoreClienteRequest $request): JsonResponse
    {
        $cliente = $this->clienteService->crearCliente($request->validated());
        return response()->json([
            'message' => 'Cliente creado exitosamente.',
            'data' => new ClienteResource($cliente)
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $cliente = $this->clienteService->obtenerCliente($id);
        if (!$cliente) {
            throw new ClienteNotFoundException('Cliente no encontrado.');
        }
        return response()->json(new ClienteResource($cliente), 200);
    }

    public function update(UpdateClienteRequest $request, int $id): JsonResponse
    {
        $cliente = $this->clienteService->actualizarCliente($request->validated(), $id);
        if (!$cliente) {
            throw new ClienteNotFoundException('Cliente no encontrado.');
        }
        return response()->json([
            'message' => 'Cliente actualizado exitosamente.',
            'data' => new ClienteResource($cliente)
        ], 200);
    }

    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->clienteService->eliminarCliente($id);
        if (!$deleted) {
            throw new ClienteNotFoundException('Cliente no encontrado.');
        }
        return response()->json(['message' => 'Cliente eliminado correctamente.'], 200);
    }
}
