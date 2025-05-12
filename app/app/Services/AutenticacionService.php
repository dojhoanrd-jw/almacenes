<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;

class AutenticacionService
{
    public function verificarRol($usuario, $role)
    {
        return $usuario->rol === $role;
    }

    public function validarPassword($usuario, $password)
    {
        return Hash::check($password, $usuario->password);
    }

    // Puedes agregar más métodos de autenticación aquí.
}
