<?php

namespace App\Providers;

use App\Repositories\Role\IRole;
use App\Repositories\Role\RoleRepository;
use App\Repositories\Setor\ISetor;
use App\Repositories\Setor\SetorRepository;
use App\Repositories\User\IUser;
use App\Repositories\User\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IUser::class, UserRepository::class);
        $this->app->bind(ISetor::class, SetorRepository::class);
        $this->app->bind(IRole::class, RoleRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
