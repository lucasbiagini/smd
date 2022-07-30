<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetorUser extends Model
{
    use HasFactory;

    protected $table = 'setor_user';

    protected $fillable = [
        'setor_id',
        'user_id'
    ];
}
