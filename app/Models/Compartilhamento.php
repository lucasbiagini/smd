<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compartilhamento extends Model
{
    use HasFactory;

    protected $table = 'compartilhamentos';

    protected $fillable = [
        'processo_id',
        'nome_instituicao',
        'finalidade'
    ];

    public function processo()
    {
        return $this->belongsTo(Processo::class);
    }

    public function dados()
    {
        return $this->hasManyThrough(
            Dado::class,
            CompartilhamentoDado::class,
            'compartilhamento_id',
            'id',
            'id',
            'dado_id'
        );
    }
}
