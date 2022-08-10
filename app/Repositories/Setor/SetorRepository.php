<?php

namespace App\Repositories\Setor;

use App\Models\Setor;

class SetorRepository implements ISetor
{
    public function paginateSetores ($sortBy, $sortDirection, $perPage, $status)
    {
        return Setor::ofSetor()->where(function ($query) use ($status){
            if (isset($status)) $query->where('status', $status);
        })->orderBy($sortBy, $sortDirection)->paginate($perPage);
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
        return Setor::ofSetor()
            ->where('name', 'like', "%$query%")
            ->where('status', 1)
            ->take(5)
            ->get();
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
