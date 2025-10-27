<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');

Route::get('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/register', [AuthController::class, 'store'])->name('auth.store');
Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/login', [AuthController::class, 'postLogin'])->name('auth.postLogin');

Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/dashboard/posts', [DashboardController::class, 'ownPost'])->name('dashboard.posts.own');

    Route::get('/dashboard/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/dashboard/posts/create', [PostController::class, 'store'])->name('posts.store');
    Route::get('/dashboard/posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::patch('/dashboard/posts/{id}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/dashboard/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');

    Route::post('/posts/{id}/comments', [CommentController::class, 'store'])->name('comments.store');


    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::patch('/profile/picture', [UserController::class, 'profilePicture'])->name('profile.picture');
    Route::get('/profile/update', [UserController::class, 'editBio'])->name('profile.editBio');
    Route::patch('/profile/update', [UserController::class, 'bioUpdate'])->name('profile.bioUpdate');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard/categories', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('/admin/dashboard/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/admin/dashboard/categories/create', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/admin/dashboard/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::patch('/admin/dashboard/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/admin/dashboard/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/admin/users', [UserController::class, 'users'])->name('admin.users');

});

// Socialite Routes

// Socialite Routes (Generic)
// Ei route-gulo {provider} parameter accept korbe (e.g., 'google', 'facebook')
Route::get('auth/{provider}', [AuthController::class, 'redirectToProvider'])->name('auth.provider');
Route::get('auth/{provider}/callback', [AuthController::class, 'handleProviderCallback'])->name('auth.provider.callback');





