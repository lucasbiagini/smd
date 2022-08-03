<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Processo extends Model
{
    use HasFactory;

    protected $table = 'processos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'ref',
        'setor_id'
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
}
