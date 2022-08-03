<?php

namespace App\Repositories\Processo;

use App\Models\Processo;

class ProcessoRepository implements IProcesso
{
    public function findById ($id)
    {
        return Processo::ofSetor()->find($id);
    }

    public function paginateProcessos($sortBy, $sortDirection, $perPage)
    {
        return Processo::ofSetor()->orderBy($sortBy, $sortDirection)->paginate($perPage);
    }

    public function store ($name, $ref, $setor_id)
    {
        return Processo::create([
            'name' => $name,
            'ref' => $ref,
            'setor_id' => $setor_id
        ]);
    }

    public function updateProcesso (Processo $processo, $name, $ref)
    {
        $processo->update([
            'name' => $name,
            'ref' => $ref
        ]);

        return $processo->save();
    }
}
