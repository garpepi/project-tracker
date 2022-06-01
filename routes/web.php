<?php

use App\Http\Controllers\AccessMenuController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlanketController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\ContractsController;
use App\Http\Controllers\EmailConfigController;
use App\Http\Controllers\EmailsController;
//use App\Http\Controllers\Contract_docController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\OperationalsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Progress_statusController;
use App\Http\Controllers\Projects_statusController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\ContractprojectsController;
use App\Http\Controllers\PayableController;
use App\Http\Controllers\ProjectCardController;
use App\Http\Controllers\SuplierController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\TaxProjectCostController;
use App\Http\Controllers\TaxProofController;
use App\Http\Controllers\UseblanketController;
use App\Models\Email;

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
Route::post('/login/api/ui', [AuthController::class, 'callapiusinglaravelui'])->name('loginui');
Route::get('/logout',[AuthController::class, 'logout'])->name('logout');

Route::middleware(['authapi','menu'])->group(function () {
    Route::get('/', function () {
        return redirect()->intended('/client');
    })->name('Dashboard');
    //user
    Route::get('/user-profile',[AuthController::class, 'userProfile'])->middleware('authapi')->name('profile');

    // Route:: view('/operationals','v_operational')->middleware('authapi');
    Route::resource('/client',ClientsController::class)->middleware('authapi');

    Route::resource('/contractProjects',ContractprojectsController::class)->middleware('authapi');
        //Route::get('/contractProjects/{contract}/ammend', [ContractprojectsController::class, 'ammend'])->middleware('authapi');
        //Route::put('/contractProjects/{contract}', [ContractprojectsController::class, 'upammend'])->middleware('authapi');
        //Route::post('/contractProjects_doc/{contract_doc}', [ContractprojectsController::class, 'destroyDoc'])->middleware('authapi');

    Route::resource('/contracts',ContractsController::class)->middleware('authapi');
    Route::get('/contracts/{contract}/ammend', [ContractsController::class, 'ammend'])->middleware('authapi');
    Route::put('/contracts/{contract}', [ContractsController::class, 'upammend'])->middleware('authapi');
    Route::post('/contract_doc/{contract_doc}', [ContractsController::class, 'destroyDoc'])->middleware('authapi');
    Route::get('/contracts/history_show/{id}', [ContractsController::class, 'history_show'])->middleware('authapi');

    Route::resource('/projects', ProjectsController::class)->middleware('authapi');
    Route::get('/projects/{project}/ammend', [ProjectsController::class, 'ammend'])->middleware('authapi');
    Route::put('/projects/{project}', [ProjectsController::class, 'upammend'])->middleware('authapi');
    Route::post('/progress_item/{progress_item}', [ProjectsController::class, 'destroyItem'])->middleware('authapi');
    Route::post('/project_cost/{project_cost}', [ProjectsController::class, 'destroyCost'])->middleware('authapi');
    Route::get('/projects/history_show/{id}', [ProjectsController::class, 'history_show'])->middleware('authapi');

    Route::resource('/operationals', OperationalsController::class)->middleware('authapi');
    Route::post('/progress_doc', [OperationalsController::class, 'uploadProgress'])->middleware('authapi');
    Route::get('/changestatus/{changestatus}', [OperationalsController::class, 'changeStatus'])->middleware('authapi');
    Route::get('/progress_doc/{progress_doc}', [OperationalsController::class, 'destroyDoc'])->middleware('authapi');

    Route::resource('/projects_status', Projects_statusController::class)->middleware('authapi');

    Route::resource('/payments', PaymentController::class)->middleware('authapi');
    Route::resource('/blanket', BlanketController::class)->middleware('authapi');
    Route::resource('/useblanket', UseblanketController::class)->middleware('authapi');

    Route::resource('/taxproof', TaxProofController::class)->middleware('authapi');
    Route::get('/applytax/{id}', [TaxProofController::class, 'applytax'])->middleware('authapi');

    Route::resource('/taxprojectcost', TaxProjectCostController::class)->middleware('authapi');

    Route::resource('/suplier', SuplierController::class)->middleware('authapi');

    Route::resource('/projectcard', ProjectCardController::class)->middleware('authapi');
    Route::get('/projectcard/export/excel/{id}', [ProjectCardController::class, 'export'])->middleware('authapi');

    Route::resource('/payable', PayableController::class)->middleware('authapi');
    Route::get('/payable/{id}/bill', [PayableController::class,'pay'])->middleware('authapi');
});

//config
Route::middleware(['authapi','admin'])->group(function () {
    Route::resource('/progress_status', Progress_statusController::class)->middleware('authapi');
    Route::resource('/access_menu', AccessMenuController::class)->middleware('authapi');
    Route::resource('/email', EmailsController::class)->middleware('authapi');
    Route::resource('/email_configuration', EmailConfigController::class)->middleware('authapi');
    Route::resource('/types', TypeController::class)->middleware('authapi');
    Route::get('/send-mail',[EmailsController::class,'sendMail']);
});
