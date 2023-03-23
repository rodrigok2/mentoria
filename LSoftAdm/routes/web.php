<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Suporte\OrdemServicoController;
use App\Http\Controllers\Cliente\ClienteController;

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

Route::name('home')
        ->middleware('auth')
        ->group(function(){
            Route::get('/', function (){return view('home');});
            Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);
        });

Route::prefix('suporte')
        ->name('suporte.')
        ->controller(OrdemServicoController::class)
        ->middleware('auth')
        ->group(function(){
            Route::get('/index', 'index')->name('index');
            Route::post('/index', 'filtrar')->name('filtrar');
            Route::get('/clientes', 'clientes')->name('clientes');
            Route::post('/buscarCliente', 'buscarCliente')->name('buscarCliente');
            Route::post('/ClienteId', 'ClienteId')->name('ClienteId');
            Route::get('/detalhes', 'detalhes')->name('detalhes');
        });

Auth::routes();
