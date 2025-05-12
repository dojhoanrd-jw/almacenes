<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'tblcliente';
    protected $primaryKey = 'ClienteId';

    protected $fillable = ['nombre', 'telefono', 'tipo_cliente'];

    public function facturas()
    {
        return $this->hasMany(Factura::class, 'ClienteId');
    }
}
