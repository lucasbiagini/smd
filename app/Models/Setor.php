<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setor extends Model
{
    use HasFactory;

    protected $table = 'setores';

    protected $fillable = [
        'name',
        'desc',
        'status'
    ];

    public function scopeOfSetor($query) {
        if (!auth()->user()->hasRole('admin') && session()->has('setor_id')) {
            $query->where('id', session('setor_id'));
        }
    }

    public function users ()
    {
        return $this->belongsToMany(User::class, 'setor_user', 'setor_id', 'user_id');
    }
}
