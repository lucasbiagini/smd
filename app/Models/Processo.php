<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Processo extends Model
{
    use HasFactory;

    const PENDENTE = 'PENDENTE';

    protected $table = 'processos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'ref',
        'setor_id',
        'status',
        'status_agentes',
        'status_fluxo',
        'status_escopo',
        'status_finalidade',
        'status_categoria_dados',
        'status_frequencia',
        'status_titulares',
        'status_compartilhamentos',
        'status_medidas',
        'status_transferencias',
        'controlador_id',
        'encarregado_id',
        'imagem',
        'desc',
        'fonte',
        'hipotese',
        'finalidade',
        'previsao_legal',
        'resultados',
        'beneficios',
        'frequencia',
        'quantidade',
        'criancas',
        'vulneraveis'
    ];

    public function setor ()
    {
        return $this->belongsTo(Setor::class);
    }

    public function scopeOfSetor($query)
    {
        if (!auth()->user()->hasRole('admin') && session()->has('setor_id')) {
            $query->where('setor_id', session('setor_id'));
        }
    }

    public function controlador ()
    {
        return $this->belongsTo(Agente::class, 'controlador_id');
    }

    public function encarregado ()
    {
        return $this->belongsTo(Agente::class, 'encarregado_id', 'id');
    }

    public function operadores ()
    {
        return $this->hasMany(Operador::class);
    }

    public function getAgentesAttribute ()
    {
        return [
          'controlador' => $this->controlador,
          'encarregado' => $this->encarregado,
          'operadores' => $this->operadores()->with('agente')->get()
        ];
    }
}
