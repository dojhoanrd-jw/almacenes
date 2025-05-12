<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Factura extends Model
{
    use HasFactory;

    protected $table = 'tblfactura';
    protected $primaryKey = 'FacturaId';

    protected $fillable = ['ClienteId', 'fecha', 'total'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'ClienteId');
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'FacturaId');
    }
}
