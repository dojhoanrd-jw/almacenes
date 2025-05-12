<?php

namespace App\Services;

use App\Models\Articulo;
use Illuminate\Database\Eloquent\Collection;
use App\Exceptions\ArticuloNotFoundException;

class ArticuloService
{
    public function create(array $data): Articulo
    {
        return Articulo::create($data);
    }

    public function find(int $id): ?Articulo
    {
        return Articulo::find($id);
    }

    public function findOrFail(int $id): Articulo
    {
        $articulo = Articulo::find($id);
        if (!$articulo) {
            throw new ArticuloNotFoundException("Artículo no encontrado.");
        }
        return $articulo;
    }

    public function getAll(): Collection
    {
        return Articulo::all();
    }

    public function update(int $id, array $data): ?Articulo
    {
        $articulo = Articulo::find($id);
        if (!$articulo) {
            throw new ArticuloNotFoundException("Artículo no encontrado.");
        }
        $articulo->update($data);
        return $articulo;
    }

    public function delete(int $id): bool
    {
        $articulo = Articulo::find($id);
        if (!$articulo) {
            throw new ArticuloNotFoundException("Artículo no encontrado.");
        }
        $articulo->delete();
        return true;
    }
}
