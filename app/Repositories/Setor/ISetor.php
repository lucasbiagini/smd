<?php

namespace App\Repositories\Setor;

interface ISetor
{
    public function paginateSetores($sortBy, $sortDirection, $perPage);
    public function store($name, $desc);
}
