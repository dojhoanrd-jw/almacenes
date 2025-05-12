<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClienteResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'ClienteId' => $this->ClienteId,
            'nombre' => $this->nombre,
            'telefono' => $this->telefono,
            'tipo_cliente' => $this->tipo_cliente,
            'facturas' => FacturaResource::collection($this->whenLoaded('facturas')),
        ];
    }
}
