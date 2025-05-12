<?php

namespace App\Services;

use App\Models\Usuario;
use App\Services\UsuarioStrategies\UsuarioStrategyInterface;

class UsuarioService
{
    protected $strategy;

    public function __construct(UsuarioStrategyInterface $strategy)
    {
        $this->strategy = $strategy;
    }

    public function listar($perPage = 10)
    {
        return Usuario::paginate($perPage);
    }

    public function obtener($id)
    {
        return Usuario::find($id);
    }

    public function crear(array $data)
    {
        return $this->strategy->crear($data);
    }

    public function actualizar($id, array $data)
    {
        return $this->strategy->actualizar($id, $data);
    }

    public function eliminar($id)
    {
        return $this->strategy->eliminar($id);
    }
}
