<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventsController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::post('/register',[UserController::class,'register']);
Route::post('/login',[UserController::class, 'login']);
Route::post('/logout',[UserController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/event/index',[EventsController::class, 'index'])->middleware('auth:sanctum');
Route::post('/event/store',[EventsController::class, 'store'])->middleware('auth:sanctum');
Route::get('/event/show/{id}',[EventsController::class, 'show'])->middleware('auth:sanctum');
Route::post('/event/edit/{id}',[EventsController::class, 'edit'])->middleware('auth:sanctum');
Route::get('/event/delete/{id}',[EventsController::class, 'destroy'])->middleware('auth:sanctum');


Route::get('/dentistas',[UserController::class, 'index'])->middleware('auth:sanctum');
Route::get('/asistentes/{id}',[UserController::class, 'mostrarAsistentes'])->middleware('auth:sanctum');
Route::get('/dentistas/{id}',[UserController::class, 'mostrarDentistas'])->middleware('auth:sanctum');
Route::post('/apuntarse/{id}',[UserController::class, 'apuntarse'])->middleware('auth:sanctum');
