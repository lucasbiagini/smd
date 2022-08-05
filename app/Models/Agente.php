<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agente extends Model
{
    use HasFactory;

    protected $table = 'agentes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'processo_id',
        'nome',
        'endereco',
        'cep',
        'telefone',
        'email'
    ];

    public function processo ()
    {
        return $this->hasOne(Processo::class);
    }
}
