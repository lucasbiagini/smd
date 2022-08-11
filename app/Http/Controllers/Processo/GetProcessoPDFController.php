<?php

namespace App\Http\Controllers\Processo;

use App\Http\Controllers\Controller;
use App\Models\Agente;
use App\Models\Compartilhamento;
use App\Models\Processo;
use App\Models\Transferencia;
use App\Repositories\Processo\IProcesso;
use Barryvdh\DomPDF\Facade\Pdf;

class GetProcessoPDFController extends Controller
{
    protected IProcesso $processo;

    public function __invoke(Processo $processo)
    {
        $processo = Processo::with([
                'setor',
                'controlador',
                'encarregado',
                'operadores',
                'dados',
                'titulares',
                'compartilhamentos',
                'medidas',
                'transferencias',
                'contratos',
                'checklists',
            ])->find($processo->id);
        foreach($processo->operadores as $key => $operador) {
            $processo->operadores[$key]['agente'] = Agente::find($operador->agente_id)->toArray();
        }
        foreach($processo->compartilhamentos as $key => $compartilhamento) {
            $processo->compartilhamentos[$key]['dados'] = Compartilhamento::find($compartilhamento->id)->dados->map(function($dado) {
                return $dado->categoria['text'];
            })->toArray();
        }
        foreach($processo->transferencias as $key => $transferencia) {
            $processo->transferencias[$key]['dados'] = Transferencia::find($transferencia->id)->dados->map(function($dado) {
                return $dado->categoria['text'];
            })->toArray();
        }
        $processo = $processo->toArray();
//        dd($processo['transferencias']);
        $pdf = PDF::loadView('processos.pdf', ['enable_remote' => true], $processo);
        return $pdf->stream($processo['name'].".pdf");
    }
}
