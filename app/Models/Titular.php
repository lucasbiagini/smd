<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Titular extends Model
{
    use HasFactory;

    protected $table = 'titulares';

    protected $fillable = [
        'processo_id',
        'tipo',
        'desc'
    ];

    public function processo()
    {
        return $this->belongsTo(Processo::class);
    }

    public function getTipoAttribute($tipo)
    {
        return [
            'value' => $tipo,
            'text' => TipoSGD::TIPOS[$tipo]
        ];
    }
}
