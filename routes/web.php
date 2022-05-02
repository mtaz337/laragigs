<?php

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

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

Route::get('/', [ListingController::class,'index']);

Route::get('/listings/create',[ListingController::class,'create'])->middleware('auth');

Route::post('/listings',[ListingController::class,'store'])->middleware('auth');

Route::get('/listings/{listing}/edit',[ListingController::class,'edit'])->middleware('auth');

Route::put('/listings/{listing}',[ListingController::class,'update'])->middleware('auth');


Route::delete('/listings/{listing}',[ListingController::class,'destroy'])->middleware('auth');

//manage listings
Route::get('/listings/manage',[ListingController::class,'manage'])->middleware('auth');

Route::get('/listings/{id}',[ListingController::class,'show']);

//show register form
Route::get('/register',[UserController::class,'create'])->middleware('guest');

//craete new user
Route::post('/users',[UserController::class,'store']);

//logout
Route::post('/logout',[UserController::class,'logout'])->middleware('auth');

//show login form
Route::get('/login',[UserController::class,'login'])->name('login')->middleware('guest');

//log in
Route::post('/users/authenticate',[UserController::class,'authenticate']);


