<?php

namespace App\Repositories\Processo;

use App\Models\Agente;
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
        $processo = Processo::create([
            'name' => $name,
            'ref' => $ref,
            'setor_id' => $setor_id
        ]);

        $controlador = Agente::create();
        $processo->associate($controlador)->save();

        $encarregado = Agente::create();
        $processo->associate($encarregado)->save();

        $agente_operador = Agente::create();
        $processo->operadores()->create([
            'agente_id' => $agente_operador->id
        ]);

        return $processo;
    }

    public function updateProcesso (Processo $processo, $name, $ref)
    {
        $processo->update([
            'name' => $name,
            'ref' => $ref
        ]);

        return $processo->save();
    }

    public function addOperador (Processo $processo)
    {
        $agente_operador = Agente::create();
        $processo->operadores()->create([
            'agente_id' => $agente_operador->id
        ]);
    }

    public function getOperadores (Processo $processo)
    {
        return $processo->operadores()->with('agente')->get();
    }
}
