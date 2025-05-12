<?php

namespace App\Services;

use App\Models\Pedido;

class PedidoService
{
    public function crearPedido(array $data)
    {
        $pedidoExistente = Pedido::where('FacturaId', $data['FacturaId'])
            ->where('ArticuloId', $data['ArticuloId'])
            ->first();

        if ($pedidoExistente) {
            $pedidoExistente->cantidad += $data['cantidad'];
            $pedidoExistente->save();
            return [
                'pedido' => $pedidoExistente,
                'actualizado' => true
            ];
        }

        $pedido = Pedido::create($data);
        return [
            'pedido' => $pedido,
            'actualizado' => false
        ];
    }

    public function actualizarPedido(Pedido $pedido, array $data)
    {
        $pedido->update($data);
        return $pedido;
    }

    public function eliminarPedido(Pedido $pedido)
    {
        $pedido->delete();
    }
}
