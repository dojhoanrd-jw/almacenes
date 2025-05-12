<?php

namespace App\Exceptions;

use Exception;

class PedidoNotFoundException extends Exception
{
    public function __construct($message = "Pedido no encontrado.", $code = 404)
    {
        parent::__construct($message, $code);
    }
}
