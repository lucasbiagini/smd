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

Route::middleware(['auth', 'verified'])->group(function () {

    /**
     * Home
     */
    Route::get('/', function () {
        return view('home');
    })->name('home');

    Route::group(['namespace' => 'App\Http\Controllers'], function () {
        /**
         * User Routes
         */
        Route::group([
            'namespace' => 'User',
            'prefix' => 'users'
        ], function () {
            Route::get('/', 'UserController@index')->name('users.index');
            Route::post('/', 'PaginateUserController')->name('users.list');
            Route::patch('/{user}', 'UpdateUserController')->name('users.update');
        });

        /**
         * Setor Routes
         */
        Route::group([
            'namespace' => 'Setor',
            'prefix' => 'setores'
        ], function () {
            Route::get('/', 'SetorController@index')->name('setores.index');
            Route::post('/', 'PaginateSetorController')->name('setores.list');
            Route::post('/create', 'StoreSetorController')->name('setores.store');
            Route::get('/{post}', 'SetorController@show')->name('setores.show');
            Route::patch('/{post}', 'SetorController@update')->name('setores.update');
            Route::delete('/{post}', 'SetorController@destroy')->name('setores.destroy');
        });
    });
});

require __DIR__.'/auth.php';
