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

Route::get('/', function () {
    return view('home.index');
})->name('Dashboard');

Route::name('Operational')->group( function () {
    Route::get('/contract-po', function () {
        return view('contract-po.index');
    })->name('contract-po');
    Route::get('/contract-po/create', function () {
        return view('contract-po.create');
    })->name('create.contract');
    Route::post('/contract-po/create', function () {
        return view('contract-po.create');
    })->name('create.contract');



    Route::get('/operational-cost', function () {
        return view('operational-cost.index');
    })->name('operational-cost');
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

