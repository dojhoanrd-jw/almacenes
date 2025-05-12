<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FacturaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'FacturaId' => $this->FacturaId,
            'ClienteId' => $this->ClienteId,
            'fecha'     => $this->fecha,
            'total'     => $this->total,
        ];
    }
}
