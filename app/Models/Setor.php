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
        'status'
    ];

    public function users ()
    {
        return $this->belongsToMany(User::class, 'setor_user', 'setor_id', 'user_id');
    }
}
