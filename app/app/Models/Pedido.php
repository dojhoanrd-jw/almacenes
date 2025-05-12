<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'tblpedido';
    protected $primaryKey = 'PedidoId';

    protected $fillable = ['FacturaId', 'ArticuloId', 'colocacion', 'precio', 'cantidad'];

    public function factura()
    {
        return $this->belongsTo(Factura::class, 'FacturaId');
    }

    public function articulo()
    {
        return $this->belongsTo(Articulo::class, 'ArticuloId');
    }
}
