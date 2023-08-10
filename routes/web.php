<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\InsertController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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


Route::get('/',[PostController::class,'index']);
Route::post('post/add',[PostController::class,'create']);

Route::get('like/add',[LikeController::class,'create']);
Route::get('like/show',[LikeController::class,'show']);

Route::get('comment/add',[CommentController::class,'create']);
Route::get('comment/show',[CommentController::class,'show']);

Route::get('search/page',[SearchController::class,'index']);

Route::get('insert/page',[InsertController::class,'index']);

Route::get('follow',[FollowerController::class,'create']);
Route::get('unfollow',[FollowerController::class,'delete']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
