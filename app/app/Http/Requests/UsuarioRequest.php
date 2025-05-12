<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UsuarioRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('id');
        $uniqueEmail = 'unique:tblPY1,email';
        $uniqueCedula = 'unique:tblPY1,cedula';

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $uniqueEmail .= ',' . $id . ',UserId';
            $uniqueCedula .= ',' . $id . ',UserId';
        }

        return [
            'nombre'      => 'sometimes|required|string|max:100',
            'email'       => ['sometimes','required','email',$uniqueEmail],
            'password'    => ['nullable', 'confirmed', Password::min(8)->letters()->numbers()->symbols()],
            'cedula'      => ['sometimes','required','string','max:15',$uniqueCedula],
            'telefono'    => 'sometimes|required|string|max:20',
            'tipo_sangre' => 'sometimes|required|string|max:5',
            'rol'         => 'nullable|string|in:Admin,User',
        ];
    }
}
