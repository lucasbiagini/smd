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

    public function scopeOfSetor($query)
    {
        if (session()->has('setor_id') && session('setor_id') !== -1) {
            $query->whereHas('setor_user', function ($query) {
                $query->where('setor_id', session('setor_id'));
            });
        }
    }

    public function setores ()
    {
        return $this->belongsToMany(Setor::class, 'setor_user', 'user_id', 'setor_id');
    }

    public function setor_user ()
    {
        return $this->hasMany(SetorUser::class);
    }

    public function hasPermissionTo (...$permissions): bool
    {
        if ($this->hasRole('admin')) return true;

        if (!session()->has('setor_id')) return false; // returns false if session variable setor_id isn't set

        $setor_user = $this->setor_user()
            ->where('setor_id', session('setor_id'))
            ->first();

        if (!isset($setor_user)) return false; // or if couldn't find setor

        if (!$setor_user->setor->status) return false; // or if setor is not active

        foreach($permissions as $permission)
            if ($setor_user->hasPermissionTo($permission)) return true;

        return false;
    }

    public function hasSetor(Setor $setor)
    {
        return $this->setor_user->map(function ($su) { return $su->setor_id; })->contains($setor->id);
    }

    public function getAllPermissionsAttribute()
    {
        if ($this->hasRole('admin')) return Permission::all()->pluck('name');

        if (!session()->has('setor_id')) return collect([]);

        $setor_user = $this->setor_user()
            ->whereHas('setor', function($query) {
                $query->where('status', 1);
            })
            ->where('setor_id', '=', session('setor_id'))
            ->first();

        if (!isset($setor_user)) {
            session()->forget('setor_id');
            return redirect('/');
        }

        $allPermissions = collect([]);
        foreach ($setor_user->roles as $role) {
            if ($role->status === 1) {
                $permissions = $role->permissions->pluck('name');
                $allPermissions = $allPermissions->concat($permissions)->unique();
            }
        }

        return $allPermissions;
    }

    public function hasSetorUserRole ($role)
    {
        return $this->setor_user
            ->map(function ($su) use ($role){
                return $su->hasRole($role);
            })
            ->reduce(function ($acc, $value) {
                return $acc || $value;
            });
    }

    public function hasActiveRoles ()
    {
        if ($this->hasRole('admin')) return true;

        foreach ($this->setor_user as $su) {
            foreach($su->roles as $role) {
                if ($role->status === 1) return true;
            }
        }
        return false;
    }
}
