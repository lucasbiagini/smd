<?php

namespace App\Providers;

use App\Repositories\Agente\AgenteRepository;
use App\Repositories\Agente\IAgente;
use App\Repositories\Checklist\ChecklistRepository;
use App\Repositories\Checklist\IChecklist;
use App\Repositories\Compartilhamento\CompartilhamentoRepository;
use App\Repositories\Compartilhamento\ICompartilhamento;
use App\Repositories\Contrato\ContratoRepository;
use App\Repositories\Contrato\IContrato;
use App\Repositories\Dado\DadoRepository;
use App\Repositories\Dado\IDado;
use App\Repositories\File\FileRepository;
use App\Repositories\File\IFile;
use App\Repositories\Medida\IMedida;
use App\Repositories\Medida\MedidaRepository;
use App\Repositories\Operador\IOperador;
use App\Repositories\Operador\OperadorRepository;
use App\Repositories\Permission\IPermission;
use App\Repositories\Permission\PermissionRepository;
use App\Repositories\Processo\IProcesso;
use App\Repositories\Processo\ProcessoRepository;
use App\Repositories\Role\IRole;
use App\Repositories\Role\RoleRepository;
use App\Repositories\Setor\ISetor;
use App\Repositories\Setor\SetorRepository;
use App\Repositories\SetorUser\ISetorUser;
use App\Repositories\SetorUser\SetorUserRepository;
use App\Repositories\Titular\ITitular;
use App\Repositories\Titular\TitularRepository;
use App\Repositories\Transferencia\ITransferencia;
use App\Repositories\Transferencia\TransferenciaRepository;
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
        $this->app->bind(ISetorUser::class, SetorUserRepository::class);
        $this->app->bind(IPermission::class, PermissionRepository::class);
        $this->app->bind(IProcesso::class, ProcessoRepository::class);

        /**
         * Dados do Processo
         */
        $this->app->bind(IAgente::class, AgenteRepository::class);
        $this->app->bind(IOperador::class, OperadorRepository::class);
        $this->app->bind(IFile::class, FileRepository::class);
        $this->app->bind(IDado::class, DadoRepository::class);
        $this->app->bind(ITitular::class, TitularRepository::class);
        $this->app->bind(ICompartilhamento::class, CompartilhamentoRepository::class);
        $this->app->bind(IMedida::class, MedidaRepository::class);
        $this->app->bind(ITransferencia::class, TransferenciaRepository::class);
        $this->app->bind(IContrato::class, ContratoRepository::class);
        $this->app->bind(IChecklist::class, ChecklistRepository::class);
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
