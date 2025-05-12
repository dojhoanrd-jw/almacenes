<?php

namespace App\Services;

use App\Models\Cliente;

class ClienteService
{
    public function crearCliente(array $validated): Cliente
    {
        return Cliente::create($validated);
    }

    public function findCliente(int $id): ?Cliente
    {
        return Cliente::with('facturas')->find($id);
    }

    public function obtenerCliente(int $id): ?Cliente
    {
        return $this->findCliente($id);
    }

    public function actualizarCliente(array $validated, int $id): ?Cliente
    {
        $cliente = $this->findCliente($id);
        if ($cliente) {
            $cliente->update($validated);
            $cliente->load('facturas');
        }
        return $cliente;
    }

    public function eliminarCliente(int $id): bool
    {
        $cliente = $this->findCliente($id);
        if ($cliente) {
            $cliente->delete();
            return true;
        }
        return false;
    }
}
