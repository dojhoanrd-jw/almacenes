<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClienteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nombre' => 'sometimes|required|string|max:100',
            'telefono' => 'sometimes|required|string|max:20',
            'tipo_cliente' => 'sometimes|required|string|max:50',
        ];
    }
}
