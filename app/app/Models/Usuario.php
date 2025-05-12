<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\AutenticacionTrait;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory, AutenticacionTrait;

    protected $table = 'tblPY1';
    protected $primaryKey = 'UserId';

    protected $fillable = ['nombre', 'email', 'password', 'cedula', 'telefono', 'tipo_sangre', 'rol'];

    protected $hidden = ['password'];

    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    public function isAdmin()
    {
        return $this->rol === 'Admin';
    }
}
