<?php

namespace App\Repositories\Setor;

use App\Models\Setor;

interface ISetor
{
    public function paginateSetores($sortBy, $sortDirection, $perPage);
    public function store($name, $desc);
    public function searchSetor($query);
    public function updateSetor(Setor $setor, $name, $status);
    public function all();
}
