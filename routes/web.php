<?php

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//All jobs listing
Route::get('/', [ListingController::class, 'index']);

//show liisting create form
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');

//Store data from the create form
Route::post('/listings/store', [ListingController::class, 'store'])->middleware('auth');

//Show Edit form
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

//Update listing
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

//Delete listing
Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->middleware('auth');

//Manage Listing
Route::get('/manage', [ListingController::class, 'manage'])->middleware('auth');

//Single Job List
Route::get('/listings/{listing}', [ListingController::class, 'show']);

//show register/create form
Route::get('/register', [UserController::class, 'create'])->middleware('guest');


//Store new user
Route::post('/users', [UserController::class, 'store']);

//logout User
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

//Show login User Form
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

//Authenticate and login User
Route::post('/users/authenticate', [UserController::class, 'authenticate']);





