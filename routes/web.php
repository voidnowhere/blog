<?php

use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
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

Route::get('/', [PostController::class, 'index'])->name('home');

Route::get('/posts/{post:slug}', [PostController::class, 'show'])->name('post');
Route::post('/posts/{post:slug}', [CommentController::class, 'store']);

Route::get('/register', [RegisterController::class, 'create'])->name('register')->middleware('guest');
Route::post('/register', [RegisterController::class, 'store'])->middleware('guest');

Route::get('/login', [LoginController::class, 'create'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'store'])->middleware('guest');

Route::post('/logout', [LoginController::class, 'destroy'])->name('logout')->middleware('auth');

Route::post('/newsletter', NewsletterController::class)->name('newsletter');

Route::middleware('can:admin')->group(function () {
    Route::get('/admin/posts', [AdminPostController::class, 'index'])->name('admin.posts');

    Route::get('/admin/posts/create', [AdminPostController::class, 'create'])->name('admin.posts.create');
    Route::post('/admin/posts/create', [AdminPostController::class, 'store']);

    Route::get('/admin/posts/{post:slug}/edit', [AdminPostController::class, 'edit'])->name('admin.posts.edit');
    Route::patch('/admin/posts/{post:slug}/edit', [AdminPostController::class, 'update']);
    Route::delete('/admin/posts/{post:slug}/edit', [AdminPostController::class, 'destroy']);
});
