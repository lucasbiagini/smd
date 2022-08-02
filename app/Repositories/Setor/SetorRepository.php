<?php

namespace App\Repositories\Setor;

use App\Models\Setor;

class SetorRepository implements ISetor
{
    public function paginateSetores ($sortBy, $sortDirection, $perPage)
    {
        return Setor::ofSetor()->orderBy($sortBy, $sortDirection)->paginate($perPage);
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
        return Setor::ofSetor()->where('name', 'like', "%$query%")->take(5)->get();
    }

    public function updateSetor (Setor $user, $name, $status)
    {
        $user->update([
            'name' => $name,
            'status' => $status
        ]);

        return $user->save();
    }

    public function all ()
    {
        return Setor::ofSetor()->all();
    }
}
