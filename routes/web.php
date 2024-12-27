<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Auth\SocialAuthController;
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





Route::get('/home',[HomeController::class,'index'])->name('home');



Route::get('/addBlog', [AdminController::class,'addBlog']);
Route::post('/addPost', [AdminController::class,'addPost']);
Route::get('/showBlog', [AdminController::class,'showBlog']);
Route::get('/deleteBlog/{id}', [AdminController::class,'deleteBlog']);
Route::get('/editBlog/{id}', [AdminController::class,'editBlog']);
Route::post('/updateBLog/{id}', [AdminController::class,'updateBLog']);

Route::get('/blogContent/{id}', [HomeController::class,'blogContent']);

Route::post('/add-comment', [CommentController::class,'store'])->name('add-comment');
Route::post('/like', [CommentController::class,'like'])->name('like');

Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/filter', [HomeController::class, 'filter'])->name('filter');



Route::get('auth/google', [SocialAuthController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);

Route::get('auth/facebook', [SocialAuthController::class, 'redirectToFacebook']);
Route::get('auth/facebook/callback', [SocialAuthController::class, 'handleFacebookCallback']);;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');



