<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioRequest;
use App\Services\UsuarioService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UsuarioController extends Controller
{
    protected $usuarioService;

    public function __construct(UsuarioService $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    public function index(Request $request): JsonResponse
    {
        $usuarios = $this->usuarioService->listar($request->get('per_page', 10));
        return response()->json($usuarios);
    }

    public function store(UsuarioRequest $request): JsonResponse
    {
        $usuario = $this->usuarioService->crear($request->validated());

        return response()->json([
            'message' => 'Usuario creado correctamente.',
            'data'    => $usuario->makeHidden('password')
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $usuario = $this->usuarioService->obtener($id);

        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }

        return response()->json($usuario->makeHidden('password'));
    }

    public function update(UsuarioRequest $request, int $id): JsonResponse
    {
        $usuario = $this->usuarioService->actualizar($id, $request->validated());

        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }

        return response()->json([
            'message' => 'Usuario actualizado correctamente.',
            'data'    => $usuario->makeHidden('password')
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $eliminado = $this->usuarioService->eliminar($id);

        if (!$eliminado) {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }

        return response()->json(['message' => 'Usuario eliminado correctamente.'], 200);
    }
}

