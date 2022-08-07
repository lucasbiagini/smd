<?php

namespace App\Repositories\Dado;

use App\Http\Requests\Dado\StoreDadoRequest;
use App\Http\Requests\Dado\UpdateDadoRequest;
use App\Models\BaseSGD;
use App\Models\Dado;
use App\Models\FonteSGD;

class DadoRepository implements IDado
{
    public function getCategorias()
    {
        return [
            'grouped_categorias' => collect(\App\Models\Dado::CATEGORIAS)->groupBy('classe')->toArray(),
            'categorias' => \App\Models\Dado::CATEGORIAS
        ];
    }

    public function getBasesSGD()
    {
        return BaseSGD::BASES;
    }

    public function getFontesSGD()
    {
        return FonteSGD::FONTES;
    }

    public function store(StoreDadoRequest $request)
    {
        return Dado::create($request->only(['processo_id', 'categoria', 'desc', 'tempo', 'fonte', 'base_dados']));
    }

    public function delete(Dado $dado)
    {
        $dado->delete();
    }

    public function update(Dado $dado, UpdateDadoRequest $request)
    {
        $dado->update($request->only(['categoria', 'desc', 'tempo', 'fonte', 'base']));
    }
}
