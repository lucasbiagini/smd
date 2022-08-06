<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Processo extends Model
{
    use HasFactory;

    const PENDENTE = 'PENDENTE';

    /**
     * Hipóteses
     */
    const HIPOTESES = [
        'Cumprimento de obrigação legal ou regulatória pelo controlador.',
        'Execução de políticas públicas.',
        'Alguma espécie de estudo realizado por órgão de pesquisa.',
        'Execução de contrato ou de procedimentos preliminares relacionados a contrato do qual seja parte o titular, a pedido do titular dos dados.',
        'Exercício regular de direitos em processo judicial, administrativo ou arbitral.',
        'Proteção da vida ou da incolumidade física do titular ou de terceiro.',
        'Tutela da saúde.',
        'Atender aos interesses legítimos do controlador ou de terceiro.',
        'Proteção do crédito.',
        'Garantia da prevenção à fraude e à segurança do titular.'
    ];

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
        'abrangencia',
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

    public function files ()
    {
        return $this->hasMany(File::class);
    }

    public function getAgentesAttribute ()
    {
        return [
          'controlador' => $this->controlador,
          'encarregado' => $this->encarregado,
          'operadores' => $this->operadores()->with('agente')->get()
        ];
    }

    public function dados ()
    {
        return $this->hasMany(Dado::class);
    }
}
