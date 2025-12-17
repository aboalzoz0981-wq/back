<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RenterController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::prefix('tenant')->controller(TenantController::class)->group(function(){

    Route::post('/add','store');
    Route::get('/getApartments','ShowApartments');
    Route::post('/Login','loginForTenant');
    Route::middleware('auth:sanctum')->group(function(){
    Route::post('/Logout','sign_upForTenant');

    Route::post('/Favorite/{ID}','AddToFavorite');
    Route::delete('/Favorite/{ID}','RemoveFromFavorite');
    Route::get('/Favorites','getApartmentsFavorite');

    Route::post('/reservation/{Id}','reserve');
    Route::get('/reservation','showAllReservation');
    Route::put('/updateDate/{Id}','updateDateOfReservation');
    Route::put('/updateStatus/{Id}','updateStatusOfReservation');


    Route::get('/showByAdd/{Address}','showByAddress');
    Route::get('/showByPri/{Price}','showByPrice');
    Route::get('/showByDes/{Description}','showByDescription');
    
    });
    

});

Route::prefix('renter')->controller(RenterController::class)->group(function(){

    Route::post('/add','store');
    Route::get('/getApartments','ShowApartments');
    Route::post('/Login','loginForRenter');
    Route::post('/Logout','sign_upForRenter')->middleware('auth:sanctum');
    
});









Route::get('getName',[UserController::class,'getNames']);
Route::get('getUser',[UserController::class,'show']);

Route::post('register',[UserController::class,'Register']);
Route::post('login',[UserController::class,'Login'])->middleware('throttle:log');
Route::middleware('auth:sanctum')->group(function(){

    Route::post('logout',[UserController::class,'Logout']);

    Route::get('users',[UserController::class,'index']);
    Route::get('users/trashed',[UserController::class,'trashed']);
    Route::get('users/{id}/restore',[UserController::class,'restore']);
    Route::get('users/All',[UserController::class,'getAll']);
    Route::delete('users/{id}',[UserController::class,'destroy']);
    Route::delete('users/{id}/forceDelete',[UserController::class,'forceDelete']);

    Route::post('post',[PostController::class,'store']);
});
Route::post('profile',[ProfileController::class,'store']);
Route::post('image',[ImageController::class,'store']);
