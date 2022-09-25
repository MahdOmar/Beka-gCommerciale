<?php

use App\Http\Controllers\BankController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\BlController;
use App\Http\Controllers\CaisseController;

use App\Http\Controllers\ClientController;
use App\Http\Controllers\FactureController;


use App\Http\Controllers\BlDetailsController;
use App\Http\Controllers\FDetailsController;
use App\Http\Controllers\DashboardController;


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
    return view('auth/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/dashboard/BL', [BlController::class, 'index']);
Route::post('/dashboard/BL', [BlController::class, 'store']);
Route::post('/dashboard/BL/update',[BlController::class, 'update']);
Route::delete('/dashboard/Bl/delete',[BlController::class, 'destroy']);
Route::get('/dashboard/Bl/show',[BlController::class, 'showData']  );
Route::get('/dashboard/Bl/filter',[BlController::class, 'filter']);
Route::post('/dashboard/Bl/transform',[BlController::class, 'transform']);


Route::get('/dashboard/Clients', [ClientController::class, 'index']);
Route::get('/dashboard/Clients/{id}/Etat_details', [ClientController::class, 'details']);

Route::post('/dashboard/Clients', [ClientController::class, 'store']);
Route::post('/dashboard/Client/update',[ClientController::class, 'update']);
Route::get('/dashboard/Client/show',[ClientController::class, 'showData']  );
Route::delete('/dashboard/Client/delete',[ClientController::class, 'destroy']);



Route::get('/dashboard/Factures', [FactureController::class, 'index']);
Route::post('/dashboard/Facture', [FactureController::class, 'store']);
Route::get('/dashboard/Facture/show',[FactureController::class, 'showData']  );
Route::post('/dashboard/Facture/update',[FactureController::class, 'update']);
Route::get('/dashboard/Facture/filter',[FactureController::class, 'filter']);
Route::get('/dashboard/Facture/bls',[FactureController::class, 'bls']);

Route::delete('/dashboard/Facture/delete',[FactureController::class, 'destroy']);


Route::get('/dashboard/Factures/{id}/details', [FDetailsController::class, 'Fac_details']);
Route::post('/dashboard/Facture/{id}/details', [FDetailsController::class, 'store']);
Route::get('/dashboard/Facture/details/get', [FDetailsController::class, 'getDetails']);
Route::post('/dashboard/Facture/details/update', [FDetailsController::class, 'update']);
Route::get('/dashboard/Facture/view/{id}',[FDetailsController::class, 'showView']);


Route::delete('/dashboard/Facture/details/delete',[FDetailsController::class, 'destroy']);







Route::get('/dashboard/BL/{id}/details', [BlDetailsController::class, 'bl_details']);
Route::post('/dashboard/BL/{id}/details', [BlDetailsController::class, 'store']);
Route::post('/dashboard/BL/details/update', [BlDetailsController::class, 'update']);

Route::get('/dashboard/BL/view/{id}',[BlDetailsController::class, 'showView']);
Route::get('/dashboard/BL/details/get', [BlDetailsController::class, 'getDetails']);
Route::delete('/dashboard/Bl/details/delete',[BlDetailsController::class, 'destroy']);






Route::get('/dashboard/Caisse', [CaisseController::class, 'index']);
Route::get('/dashboard/Caisse/{id}/details', [CaisseController::class, 'details']);


Route::post('/dashboard/Caisse/depense', [CaisseController::class, 'store']);
Route::get('/dashboard/Caisse/show',[CaisseController::class, 'showData']  );
Route::get('/dashboard/Caisse/showD',[CaisseController::class, 'showData2']  );

Route::post('/dashboard/Caisse/update',[CaisseController::class, 'update']);
Route::post('/dashboard/Caisse/update2',[CaisseController::class, 'update2']);

Route::delete('/dashboard/Caisse/delete',[CaisseController::class, 'destroy']);
Route::delete('/dashboard/Caissedetails/delete',[CaisseController::class, 'destroyDetails']);

Route::get('/dashboard/Caisse/filter',[CaisseController::class, 'filter']);
Route::get('/dashboard/Caisse/bls',[CaisseController::class, 'bls']);
Route::get('/dashboard/Caisse/clients',[CaisseController::class, 'CredisClients']);
Route::get('/dashboard/Caissedetails/{id}/print',[CaisseController::class, 'print']);
Route::get('/dashboard/Caisse/{id}/print',[CaisseController::class, 'remob']);

// Bank Routes



Route::get('/dashboard/Bank', [BankController::class, 'index']);
Route::get('/dashboard/Bank/facture', [BankController::class, 'factures']);




Route::get('/dashboard/stats', [DashboardController::class, 'index']);







