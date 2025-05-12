<?php

namespace App\Services\UsuarioStrategies;

use App\Models\Usuario;

class DefaultUsuarioStrategy implements UsuarioStrategyInterface
{
    public function crear(array $data)
    {
        return Usuario::create($data);
    }

    public function actualizar($id, array $data)
    {
        $usuario = Usuario::find($id);
        if (!$usuario) {
            return null;
        }
        if (empty($data['password'])) {
            unset($data['password']);
        }
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $usuario->update($data);
        return $usuario;
    }

    public function eliminar($id)
    {
        $usuario = Usuario::find($id);
        if (!$usuario) {
            return false;
        }
        $usuario->delete();
        return true;
    }
}
