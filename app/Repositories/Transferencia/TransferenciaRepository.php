<?php

namespace App\Repositories\Transferencia;

use App\Http\Requests\Transferencia\StoreTransferenciaRequest;
use App\Http\Requests\Transferencia\UpdateTransferenciaRequest;
use App\Models\Garantia;
use App\Models\Transferencia;
use App\Models\TransferenciaDado;
use Carbon\Carbon;

class TransferenciaRepository implements ITransferencia
{
    public function getGarantias()
    {
        return Garantia::GARANTIAS;
    }

    public function store(StoreTransferenciaRequest $request)
    {
        $transferencia = Transferencia::create($request->only(['processo_id', 'organizacao', 'pais', 'garantia']));
        $dados = collect($request->dados_compartilhados)->map(function ($dado) use ($transferencia) {
            return [
                'dado_id' => $dado,
                'transferencia_id' => $transferencia->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        })->toArray();
        TransferenciaDado::insert($dados);
    }

    public function delete(Transferencia $transferencia)
    {
        $transferencia->delete();
    }

    public function update(Transferencia $transferencia, UpdateTransferenciaRequest $request)
    {
        $transferencia->update($request->only(['organizacao', 'pais', 'garantia']));
        TransferenciaDado::where('transferencia_id', $transferencia->id)
            ->whereNotIn('dado_id', $request->dados_compartilhados)
            ->delete();
        $dados_to_keep = TransferenciaDado::where('transferencia_id', $transferencia->id)
            ->get()
            ->pluck('dado_id');
        $dados = collect($request->dados_compartilhados)->diff($dados_to_keep)->map(function ($dado) use ($transferencia) {
            return [
                'dado_id' => $dado,
                'transferencia_id' => $transferencia->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        })->toArray();
        if (sizeof($dados) > 0) TransferenciaDado::insert($dados);
    }
}
