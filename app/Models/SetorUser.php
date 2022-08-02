<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class SetorUser extends Model
{
    use HasFactory, HasRoles;

    protected $table = 'setor_user';

    protected $fillable = [
        'setor_id',
        'user_id'
    ];

    protected $guard_name = 'web';

    public function scopeOfSetor($query)
    {
        if (!auth()->user()->hasRole('admin') && session()->has('setor_id')) {
            $query->where('setor_id', session('setor_id'));
        }
    }

    public function user ()
    {
        return $this->belongsTo(User::class);
    }

    public function setor ()
    {
        return $this->belongsTo(Setor::class);
    }
}
