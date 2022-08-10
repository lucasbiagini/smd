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
        if (session()->has('setor_id') && session('setor_id') !== -1) {
            $query->where('id', session('setor_id'));
        }
    }

    public function users ()
    {
        return $this->belongsToMany(User::class, 'setor_user', 'setor_id', 'user_id');
    }
}
