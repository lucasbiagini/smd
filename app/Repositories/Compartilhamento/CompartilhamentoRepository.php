<?php

namespace App\Repositories\Compartilhamento;

use App\Http\Requests\Compartilhamento\StoreCompartilhamentoRequest;
use App\Http\Requests\Compartilhamento\UpdateCompartilhamentoRequest;
use App\Models\Compartilhamento;
use App\Models\CompartilhamentoDado;
use Carbon\Carbon;

class CompartilhamentoRepository implements ICompartilhamento
{
    public function store(StoreCompartilhamentoRequest $request)
    {
        $compartilhamento = Compartilhamento::create($request->only(['processo_id', 'nome_instituicao', 'finalidade']));
        $dados = collect($request->dados_compartilhados)->map(function ($dado) use ($compartilhamento) {
            return [
                'dado_id' => $dado,
                'compartilhamento_id' => $compartilhamento->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        })->toArray();
        CompartilhamentoDado::insert($dados);
    }

    public function delete(Compartilhamento $compartilhamento)
    {
        $compartilhamento->delete();
    }

    public function update(Compartilhamento $compartilhamento, UpdateCompartilhamentoRequest $request)
    {
        $compartilhamento->update($request->only(['nome_instituicao', 'finalidade']));
        CompartilhamentoDado::where('compartilhamento_id', $compartilhamento->id)
            ->whereNotIn('dado_id', $request->dados_compartilhados)
            ->delete();
        $dados_to_keep = CompartilhamentoDado::where('compartilhamento_id', $compartilhamento->id)
            ->get()
            ->pluck('dado_id');
        $dados = collect($request->dados_compartilhados)->diff($dados_to_keep)->map(function ($dado) use ($compartilhamento) {
            return [
                'dado_id' => $dado,
                'compartilhamento_id' => $compartilhamento->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        })->toArray();
        if (sizeof($dados) > 0) CompartilhamentoDado::insert($dados);
    }
}
