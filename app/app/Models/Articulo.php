<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Articulo extends Model
{
    use HasFactory;

    protected $table = 'tblarticulo';
    protected $primaryKey = 'ArticuloId';

    protected $fillable = ['codigo_barra', 'descripcion', 'fabricante', 'nombre_articulo', 'precio', 'stock'];

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'ArticuloId');
    }
}
