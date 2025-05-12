<?php

namespace App\Services\UsuarioStrategies;

interface UsuarioStrategyInterface
{
    public function crear(array $data);
    public function actualizar($id, array $data);
    public function eliminar($id);
}
