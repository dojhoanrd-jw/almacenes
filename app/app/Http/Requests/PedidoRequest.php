<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PedidoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'FacturaId'  => 'required|exists:tblfactura,FacturaId',
            'ArticuloId' => 'required|exists:tblarticulo,ArticuloId',
            'colocacion' => 'required|string|max:100',
            'precio'     => 'required|numeric|min:0',
            'cantidad'   => 'required|integer|min:1',
        ];

        if ($this->isMethod('patch') || $this->isMethod('put')) {
            foreach ($rules as $key => $rule) {
                $rules[$key] = 'sometimes|' . $rule;
            }
        }

        return $rules;
    }
}
