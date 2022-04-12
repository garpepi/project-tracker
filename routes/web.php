<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ContractPo;
use App\Http\Controllers\ContractsController;
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

Route::get('/login',[AuthController::class, 'index'])->name('login');
Route::post('/login',[AuthController::class, 'callapiusinglaravelui'])->name('loged-in');
Route::get('/logout',[AuthController::class, 'logout'])->name('logout');


Route::middleware(['authapi','menu'])->group(function () {

    Route::get('/', function () { return view('home.index'); })->name('Dashboard');

    Route::group(['prefix'=>'operational'], function()
    {
        Route::get('/contract-po', [ContractPo::class, 'index'])->name('contract-po');

        Route::resource('/contracts',ContractsController::class);
        Route::get('/contracts/{contract}/ammend', [ContractsController::class, 'ammend'])->name('contracts.ammend');
        Route::put('/contracts/{contract}/ammend', [ContractsController::class, 'upammend'])->name('contracts.upammend');
        Route::post('/contract_doc/{contract_doc}', [ContractsController::class, 'destroyDoc'])->name('contracts.destroyDoc');
        Route::get('/contracts/history_show/{id}', [ContractsController::class, 'history_show'])->name('contracts.history');

        Route::post('/contract-po/create', function () {
            return view('contract-po.create');
        })->name('create.contract');

        Route::get('/operational-cost', function () {
                return view('operational-cost.index');
        })->name('operational-cost');
    });
});


Route::name('Monitoring')->group( function () {
    Route::get('/project-card', function () {
        return view('project-card.index');
    })->name('project-card');
});

Route::name('Settings')->group( function () {
    Route::get('/master-clients', function () {
        return view('master-clients.index');
    })->name('master-clients');
});

