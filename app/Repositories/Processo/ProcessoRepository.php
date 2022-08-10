<?php

namespace App\Repositories\Processo;

use App\Models\Agente;
use App\Models\Checklist;
use App\Models\Processo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ProcessoRepository implements IProcesso
{
    public function findById ($id)
    {
        $processo = Processo::ofSetor()->find($id);
        $processo->checklist = $processo->checklists->groupBy('section')->map(function ($section) {
            return $section[0];
        })->toArray();
        return $processo;
    }

    public function paginateProcessos($sortBy, $sortDirection, $perPage, $status)
    {
        return Processo::ofSetor()
            ->where(function($query) use ($status) {
                if ($status === 'ARQUIVADO') $query->whereNotNull('archived_at');
                else if ($status === 'HOMOLOGADO') $query->whereNotNull('approved_at')->whereNull('archived_at');
                else if ($status === 'ANALISE') $query->whereNotNull('ready_at')->whereNull(['approved_at', 'archived_at']);
                else if ($status === 'PENDENTE') $query->whereNull(['archived_at', 'approved_at', 'ready_at']);
                else $query->whereNull('archived_at');
            })
            ->orderBy($sortBy, $sortDirection)
            ->paginate($perPage);
    }

    public function store ($name, $ref, $description, $setor_id)
    {
        $processo = Processo::create([
            'name' => $name,
            'ref' => $ref,
            'setor_id' => $setor_id,
            'description' => $description
        ]);

        $controlador = Agente::create();
        $processo->controlador_id = $controlador->id;

        $encarregado = Agente::create();
        $processo->encarregado_id = $encarregado->id;

        $processo->save();

        $agente_operador = Agente::create();
        $processo->operadores()->create([
            'agente_id' => $agente_operador->id
        ]);

        return $processo;
    }

    public function updateProcesso (Processo $processo, $name, $ref, $description)
    {
        $processo->update([
            'name' => $name,
            'ref' => $ref,
            'description' => $description
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

    public function updateProcessoProp (Processo $processo, $prop, $value)
    {
        $processo->$prop = $value;
        $processo->save();
    }

    public function getFiles (Processo $processo)
    {
        return $processo->files;
    }

    public function paginateDados (Processo $processo, $sortBy, $sortDirection, $perPage)
    {
        return $processo->dados()->orderBy($sortBy, $sortDirection)->paginate($perPage);
    }

    public function paginateTitulares (Processo $processo, $sortBy, $sortDirection, $perPage)
    {
        return $processo->titulares()->orderBy($sortBy, $sortDirection)->paginate($perPage);
    }

    public function paginateCompartilhamentos (Processo $processo, $sortBy, $sortDirection, $perPage)
    {
        return $processo->compartilhamentos()->with('dados')->orderBy($sortBy, $sortDirection)->paginate($perPage);
    }

    public function paginateMedidas (Processo $processo, $sortBy, $sortDirection, $perPage)
    {
        return $processo->medidas()->orderBy($sortBy, $sortDirection)->paginate($perPage);
    }

    public function paginateTransferencias (Processo $processo, $sortBy, $sortDirection, $perPage)
    {
        return $processo->transferencias()->with('dados')->orderBy($sortBy, $sortDirection)->paginate($perPage);
    }

    public function paginateContratos (Processo $processo, $sortBy, $sortDirection, $perPage)
    {
        return $processo->contratos()->orderBy($sortBy, $sortDirection)->paginate($perPage);
    }

    public function getAllDados(Processo $processo)
    {
        return $processo->dados;
    }

    public function analyse(Processo $processo)
    {
        if ($processo->archived_at === null) {
            $processo->approved_at = null;
            $processo->ready_at = Carbon::now();
            $processo->save();

            if (sizeof($processo->checklists) === 0) {
                $insert_data = collect([]);
                foreach (Processo::sections as $section) {
                    $insert_data->push([
                        'processo_id' => $processo->id,
                        'section' => $section,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                }
                Checklist::insert($insert_data->toArray());
            }
        }
    }

    public function approve(Processo $processo)
    {
        if ($processo->ready_at !== null && $processo->approved_at === null && $processo->archived_at === null) {
            $processo->approved_at = Carbon::now();
            $processo->save();
        }
    }

    public function reject(Processo $processo)
    {
        if ($processo->ready_at !== null && $processo->approved_at === null && $processo->archived_at === null) {
            $processo->ready_at = null;
            $processo->save();
        }
    }

    public function archive(Processo $processo)
    {
        if ($processo->archived_at === null) {
            $processo->archived_at = Carbon::now();
            $processo->save();
        }
    }

    public function unarchive(Processo $processo)
    {
        if ($processo->archived_at !== null) {
            $processo->archived_at = null;
            $processo->save();
        }
    }

    public function uploadImage(Processo $processo, $path, $filename, $type)
    {
        $processo->image_path = $path;
        $processo->image_filename = $filename;
        $processo->image_type = $type;
        $processo->save();
    }

    public function deleteImage(Processo $processo)
    {
        Storage::delete($processo->image_path);
        $processo->image_path = null;
        $processo->image_filename = null;
        $processo->image_type = null;
        $processo->save();
    }
}
