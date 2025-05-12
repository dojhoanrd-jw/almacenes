<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticuloRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return $this->rulesArray();
    }

    
    protected function rulesArray($id = null)
    {
        return [
            'codigo_barra'     => 'required|string|max:100|unique:tblarticulo,codigo_barra',
            'descripcion'      => 'required|string',
            'fabricante'       => 'required|string|max:100',
            'nombre_articulo'  => 'required|string|max:100',
            'precio'           => 'required|numeric|min:0',
            'stock'            => 'required|integer|min:0',
        ];
    }
}
