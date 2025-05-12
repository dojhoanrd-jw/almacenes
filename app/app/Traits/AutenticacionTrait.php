<?php

namespace App\Traits;

use App\Services\AutenticacionService;

trait AutenticacionTrait
{

    public function hasRole($role)
    {
        return app(AutenticacionService::class)->verificarRol($this, $role);
    }

    public function validatePassword($password)
    {
        return app(AutenticacionService::class)->validarPassword($this, $password);
    }

}
