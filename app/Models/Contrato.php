<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    use HasFactory;

    protected $table = 'contratos';

    protected $fillable = [
        'processo_id',
        'numero',
        'objeto',
        'email'
    ];

    public function processo()
    {
        return $this->belongsTo(Processo::class);
    }
}
