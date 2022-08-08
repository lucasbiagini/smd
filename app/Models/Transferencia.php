<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transferencia extends Model
{
    use HasFactory;

    protected $table = 'transferencias';

    protected $fillable = [
        'processo_id',
        'organizacao',
        'pais',
        'garantia'
    ];

    public function processo()
    {
        return $this->belongsTo(Processo::class);
    }

    public function dados()
    {
        return $this->hasManyThrough(
            Dado::class,
            TransferenciaDado::class,
            'transferencia_id',
            'id',
            'id',
            'dado_id'
        );
    }

    public function getGarantiaAttribute($garantia)
    {
        return [
            'value' => $garantia,
            'text' => Garantia::GARANTIAS[$garantia]
        ];
    }
}
