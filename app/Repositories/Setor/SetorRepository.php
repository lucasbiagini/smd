<?php

namespace App\Repositories\Setor;

use App\Models\Setor;

class SetorRepository implements ISetor
{
    public function paginateSetores ($sortBy, $sortDirection, $perPage)
    {
        return Setor::orderBy($sortBy, $sortDirection)->paginate($perPage);
    }

    public function store ($name, $desc)
    {
        return Setor::create([
            'name' => $name,
            'desc' => $desc
        ]);
    }

    public function searchSetor ($query)
    {
        return Setor::where('name', 'like', "%$query%")->take(5)->get();
    }
}
