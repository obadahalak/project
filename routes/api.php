<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\ProviderControler;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\ReservationsController;
use App\Models\order;
use App\Models\partyPlace;
use App\Models\provider;
use Faker\Factory;
use Illuminate\Support\Facades\Route;




////////////////////////////////// Users ////////////////////////

//login User
Route::post('loginUser', [UserController::class, 'AuthUser']);

//Sigin User
Route::post('signUser', [UserController::class, 'signUser']);
//Logout User
Route::post('logoutUser', [UserController::class, 'logoutUser'])->middleware('auth:sanctum');

Route::get('getListPlacees', [UserController::class, 'getPlacees'])->middleware('auth:sanctum');

//getMyReservation
Route::get('Reservation', [ReservationsController::class, 'getMyReservation'])->middleware('auth:sanctum');

Route::post('CreateOrder', [UserController::class, 'CreateOrder'])->middleware('auth:sanctum');

Route::post('sendEvaluation/{place_id}',[UserController::class,'sendEvaluation']);



////////////////////  Providers   ////////////////////////////////////


//Sigin Provider
Route::post('/siginProvider', [ProviderControler::class, 'signProvider']);

//login Provider
Route::post('/loginProvider', [ProviderControler::class, 'AuthProvider']);

//logout Provider
Route::post('/logoutProvider', [ProviderControler::class, 'logoutProvider'])->middleware('auth:sanctum');

Route::post('CreatePlace', [ProviderControler::class, 'createPlace'])->middleware('auth:sanctum');


Route::get('getMyOrders', [ProviderControler::class, 'getMyOrders' ])->middleware('auth:sanctum');

Route::post('acceptOrRejectOrder/{id}', [ProviderControler::class, 'acceptOrRejectOrder'])->middleware('auth:sanctum');


////////////////////////admin/////////////////////


Route::get('GetAllPlaces', [AdminController::class, 'GetAllPlaces']);
Route::get('getAllProviders', [AdminController::class, 'getAllProviders']);


Route::post('acceptOrRject', [AdminController::class, 'acceptOrRject']);


