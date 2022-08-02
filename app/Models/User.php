<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setores ()
    {
        return $this->belongsToMany(Setor::class, 'setor_user', 'user_id', 'setor_id');
    }

    public function setor_user ()
    {
        return $this->hasMany(SetorUser::class);
    }

    public function hasPermissionTo ($permission): bool
    {
        if ($this->hasRole('admin')) return true;

        if (!session()->has('setor_id')) return false; // returns false if session variable setor_id isn't set

        $setor = $this->setor_user()
            ->where('setor_id', session('setor_id'))
            ->first();

        if (!isset($setor)) return false; // or if couldn't find setor

        if (!$setor->status) return false; // or if setor is not active

        return $setor->hasPermissionTo($permission);
    }

    public function hasSetor(Setor $setor)
    {
        return $this->setor_user->map(function ($su) { return $su->setor_id; })->contains($setor->id);
    }
}
