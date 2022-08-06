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
//                    Route::get('/all', 'AllSetoresController')->name('setores.all'); //deprecated
                });
                Route::post('/search', 'SearchSetorController')
                    ->name('setores.search')
                    ->middleware('permission:users.roles');
                Route::post('/{setor}/select', 'SelectSetorController')->name('setores.select');
            });

            /**
             * Roles Routes
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
             * Permissions Routes
             */
            Route::group([
                'namespace' => 'Permission',
                'prefix' => 'permissions'
            ], function () {
                Route::get('/all', 'AllPermissionsController')->name('permissions.all');
            });

            /**
             * Processos Routes
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
                    Route::patch('/{processo}', 'UpdateProcessoController')->name('processos.update');
                    Route::get('/{processo}', 'ProcessoController@show')->name('processos.show');
                });
                Route::post('/{processo}', 'GetProcessoController')
                    ->middleware('permission:processos.show');

                /**
                 * Dados dos Processos Routes
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
                    });
                });
            });

            Route::middleware(['permission:processos.dados'])->group(function () {
                /**
                 * Agentes Routes
                 */
                Route::group([
                    'prefix' => 'agentes',
                    'namespace' =>'Agente'
                ], function () {
//                Route::get('/tipos', 'GetTiposController'); // deprecated
                    Route::patch('/{agente}', 'UpdateAgenteController');
                });

                /**
                 * Operadores Routes
                 */
                Route::group([
                    'prefix' => 'operadores',
                    'namespace' => 'Operador'
                ], function () {
                    Route::delete('/{operador}', 'DeleteOperadorController');
                    Route::patch('/{operador}', 'UpdateOperadorController');
                });

                /**
                 * Files Routes
                 */
                Route::group([
                    'prefix' => 'files',
                    'namespace' => 'File'
                ], function () {
                    Route::get('/{file}', 'DownloadFileController');
                    Route::delete('/{file}', 'DeleteFileController');
                });

                /**
                 * Dados Routes
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
            });
        });
    });
});

require __DIR__.'/auth.php';
