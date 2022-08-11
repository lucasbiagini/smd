<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/logout', function () {
   return redirect('/login');
});

Route::middleware(['auth', 'verified'])->group(function () {

    /**
     * Home
     */
    Route::get('/', function () {
        return view('home');
    })->name('home');

    Route::group(['namespace' => 'App\Http\Controllers'], function () {
        Route::middleware(['user_is_active', 'user_has_active_setores'])->group(function() {
            /**
             * User Routes
             */
            Route::group([
                'namespace' => 'User',
                'prefix' => 'users'
            ], function () {
                Route::middleware(['permission'])->group(function () {
                    Route::get('/', 'UserController@index')->name('users.index');
                    Route::post('/', 'PaginateUserController')->name('users.list');
                    Route::patch('/{user}', 'UpdateUserController')->name('users.update');
                    Route::get('/{user}/roles', 'GetUserRolesController')->name('users.roles');
                });
                Route::get('/{user}/setores', 'GetUserSetoresController')->name('user.setores');
            });

            /**
             * Setor Routes
             */
            Route::group([
                'namespace' => 'Setor',
                'prefix' => 'setores'
            ], function () {
                Route::middleware(['permission'])->group(function () {
                    Route::get('/', 'SetorController@index')->name('setores.index');
                    Route::post('/', 'PaginateSetorController')->name('setores.list');
                    Route::post('/create', 'StoreSetorController')->name('setores.store');
                    Route::patch('/{setor}', 'UpdateSetorController')->name('setores.update');
                });
                Route::post('/search', 'SearchSetorController')
                    ->name('setores.search')
                    ->middleware('permission:users.roles');
                Route::post('/-1/select', 'SelectTodosSetoresController')->name('setores.select');
                Route::post('/{setor}/select', 'SelectSetorController')->name('setores.select');
            });

            /**
             * Role Routes
             */
            Route::group([
               'namespace' => 'Role',
               'prefix' => 'roles'
            ], function () {
                Route::middleware(['permission'])->group(function () {
                    Route::get('/', 'RoleController@index')->name('roles.index');
                    Route::post('/', 'PaginateRoleController')->name('roles.list');
                    Route::post('/create', 'StoreRoleController')->name('roles.store');
                    Route::get('/{role}/permissions', 'ListRolePermissionsController')->name('role.permissions.list');
                    Route::post('/{role}/permissions', 'SyncRolePermissionsController')->name('roles.permissions.sync');
                    Route::patch('/{role}', 'UpdateRoleController')->name('roles.update');
                });
                Route::post('/search', 'SearchRoleController')
                    ->name('roles.search')
                    ->middleware('permission:users.roles');
            });

            /**
             * SetorUser Routes
             */
            Route::group([
                'namespace' => 'SetorUser',
                'prefix' => 'setor-user'
            ], function () {
                Route::middleware(['permission'])->group(function () {
                    Route::post('/create', 'StoreSetorUserController')->name('setor-user.store');
                    Route::post('/{setor_user}/role', 'RemoveRoleController')->name('setor-user.remove-role');
                });
            });

            /**
             * Permission Routes
             */
            Route::group([
                'namespace' => 'Permission',
                'prefix' => 'permissions'
            ], function () {
                Route::get('/all', 'AllPermissionsController')->name('permissions.all');
            });

            /**
             * Processo Routes
             */
            Route::group([
                'namespace' => 'Processo',
                'prefix' => 'processos'
            ], function () {
                Route::middleware(['permission:processos.dados'])->group(function () {
                    Route::get('/hipoteses', 'GetHipotesesController');
                });

                Route::middleware(['permission'])->group(function () {
                    Route::post('/', 'PaginateProcessoController')->name('processos.list');
                    Route::post('/create', 'StoreProcessoController')->name('processos.store');
                    Route::post('/{processo}', 'UpdateProcessoController')->name('processos.update');
                    Route::post('/{processo}/image', 'UploadImageController')
                        ->middleware('permission:processos.update');
                    Route::delete('/{processo}/image', 'DeleteImageController')
                        ->middleware('permission:processos.update');
                    Route::get('/{processo}', 'ProcessoController@show')->name('processos.show');
                });
                Route::post('/{processo}', 'GetProcessoController')
                    ->middleware('permission:processos.show');
                Route::get('/{processo}/pdf', 'GetProcessoPDFController')
                    ->middleware('permission:processos.show');

                /**
                 * Dados dos Processo Routes
                 */
                Route::group([
                    'prefix' => '{processo}'
                ], function () {
                    Route::middleware(['permission:processos.dados'])->group(function () {
                        Route::patch('/prop', 'UpdateProcessoPropController');
                        Route::get('/agentes', 'GetAgentesController');
                        Route::post('/operador', 'AddOperadorController');
                        Route::post('/file', 'UploadFileController');
                        Route::get('/files', 'GetFilesController');
                        Route::post('/dados', 'PaginateDadosController');
                        Route::post('/titulares', 'PaginateTitularesController');
                        Route::post('/compartilhamentos', 'PaginateCompartilhamentosController');
                        Route::post('/medidas', 'PaginateMedidasController');
                        Route::post('/transferencias', 'PaginateTransferenciasController');
                        Route::post('/contratos', 'PaginateContratosController');
                        Route::get('/dados/all', 'GetAllDadosController');
                    });

                    Route::middleware(['permission'])->group(function () {
                        Route::post('/analyse', 'AnalyseProcessoController')->name('processos.analyse');
                        Route::post('/approve', 'ApproveProcessoController')->name('processos.approve');
                        Route::post('/reject', 'RejectProcessoController')->name('processos.reject');
                        Route::post('/archive', 'ArchiveProcessoController')->name('processos.archive');
                        Route::post('/unarchive', 'UnarchiveProcessoController')->name('processos.unarchive');
                    });
                });
            });

            Route::middleware(['permission:processos.dados'])->group(function () {
                /**
                 * Agente Routes
                 */
                Route::group([
                    'prefix' => 'agentes',
                    'namespace' =>'Agente'
                ], function () {
                    Route::patch('/{agente}', 'UpdateAgenteController');
                });

                /**
                 * Operador Routes
                 */
                Route::group([
                    'prefix' => 'operadores',
                    'namespace' => 'Operador'
                ], function () {
                    Route::delete('/{operador}', 'DeleteOperadorController');
                    Route::patch('/{operador}', 'UpdateOperadorController');
                });

                /**
                 * File Routes
                 */
                Route::group([
                    'prefix' => 'files',
                    'namespace' => 'File'
                ], function () {
                    Route::get('/{file}', 'DownloadFileController');
                    Route::delete('/{file}', 'DeleteFileController');
                });

                /**
                 * Dado Routes
                 */
                Route::group([
                    'prefix' => 'dados',
                    'namespace' => 'Dado'
                ], function () {
                    Route::get('/categorias', 'GetCategoriasController');
                    Route::get('/bases', 'GetBasesSGDController');
                    Route::get('/fontes', 'GetFontesSGDController');
                    Route::post('/', 'StoreDadoController');
                    Route::patch('/{dado}', 'UpdateDadoController');
                    Route::delete('/{dado}', 'DeleteDadoController');
                });

                /**
                 * Titular Routes
                 */
                Route::group([
                    'prefix' => 'titulares',
                    'namespace' => 'Titular'
                ], function () {
                    Route::get('/tipos', 'GetTiposSGDController');
                    Route::post('/', 'StoreTitularController');
                    Route::patch('/{titular}', 'UpdateTitularController');
                    Route::delete('/{titular}', 'DeleteTitularController');
                });

                /**
                 * Compartilhamento Routes
                 */
                Route::group([
                    'prefix' => 'compartilhamentos',
                    'namespace' => 'Compartilhamento'
                ], function () {
                    Route::post('/', 'StoreCompartilhamentoController');
                    Route::patch('/{compartilhamento}', 'UpdateCompartilhamentoController');
                    Route::delete('/{compartilhamento}', 'DeleteCompartilhamentoController');
                });

                /**
                 * Medida Routes
                 */
                Route::group([
                    'prefix' => 'medidas',
                    'namespace' => 'Medida'
                ], function () {
                    Route::get('/tipos', 'GetTiposMedidaSGDController');
                    Route::post('/', 'StoreMedidaController');
                    Route::patch('/{medida}', 'UpdateMedidaController');
                    Route::delete('/{medida}', 'DeleteMedidaController');
                });

                /**
                 * Transferencia Routes
                 */
                Route::group([
                    'prefix' => 'transferencias',
                    'namespace' => 'Transferencia'
                ], function () {
                    Route::get('/garantias', 'GetGarantiasController');
                    Route::post('/', 'StoreTransferenciaController');
                    Route::patch('/{transferencia}', 'UpdateTransferenciaController');
                    Route::delete('/{transferencia}', 'DeleteTransferenciaController');
                });

                /**
                 * Contrato Routes
                 */
                Route::group([
                    'prefix' => 'contratos',
                    'namespace' => 'Contrato'
                ], function () {
                    Route::post('/', 'StoreContratoController');
                    Route::patch('/{contrato}', 'UpdateContratoController');
                    Route::delete('/{contrato}', 'DeleteContratoController');
                });

                /**
                 * Checklist Routes
                 */
                Route::group([
                    'prefix' => 'checklists',
                    'namespace' => 'Checklist'
                ], function () {
                    Route::post('/{checklist}/message', 'UpdateMessageController');
                    Route::post('/{checklist}/approve', 'ApproveChecklistController');
                    Route::post('/{checklist}/reject', 'RejectChecklistController');
                });
            });
        });
    });
});

require __DIR__.'/auth.php';
