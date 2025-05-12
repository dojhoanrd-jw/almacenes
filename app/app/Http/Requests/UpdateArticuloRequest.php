<?php

namespace App\Http\Requests;

class UpdateArticuloRequest extends StoreArticuloRequest
{
    public function rules()
    {
        $id = $this->route('id');
        $rules = $this->rulesArray();
        $rules['codigo_barra'] = 'sometimes|required|string|max:100|unique:tblarticulo,codigo_barra,' . $id . ',ArticuloId';
        foreach ($rules as $field => &$rule) {
            if ($field !== 'codigo_barra') {
                $rule = 'sometimes|' . ltrim($rule, '|');
            }
        }
        return $rules;
    }
}
