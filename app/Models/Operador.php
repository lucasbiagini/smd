<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operador extends Model
{
    use HasFactory;

    protected $table = 'operadores';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'agente_id',
        'processo_id',
        'coleta',
        'retencao',
        'processamento',
        'compartilhamento',
        'eliminacao'
    ];

    protected $casts = [
        'coleta' => 'boolean',
        'retencao' => 'boolean',
        'processamento' => 'boolean',
        'compartilhamento' => 'boolean',
        'eliminacao' => 'boolean'
    ];

    public function processo ()
    {
        return $this->belongsTo(Processo::class);
    }

    public function agente ()
    {
        return $this->belongsTo(Agente::class);
    }
}
