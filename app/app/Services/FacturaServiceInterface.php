<?php

namespace App\Services;

use Illuminate\Http\Request;

interface FacturaServiceInterface
{
    public function list(Request $request);
    public function create(array $data);
    public function findWithRelations(int $id);
    public function update(int $id, array $data);
    public function delete(int $id);
}
