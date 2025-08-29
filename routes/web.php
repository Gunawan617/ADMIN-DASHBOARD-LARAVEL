<?php

use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\TryoutProgramController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Homepage (public)
Route::get('/', function () {
    return view('welcome');
});

// Group Admin (wajib login)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AnalyticsController::class, 'dashboard'])->name('dashboard');

    // CRUD Bimbel Programs (Blade Dashboard)
    Route::resource('bimbel-programs', \App\Http\Controllers\Admin\BimbelProgramController::class);

    // CRUD Team Members
    Route::resource('team-members', TeamMemberController::class);

    // CRUD Posts, Users, Books
    Route::resource('posts', PostController::class)->names('posts');
    Route::resource('users', App\Http\Controllers\Admin\UserController::class)
        ->except(['create', 'store', 'destroy', 'show'])
        ->names('users');
    
    // CRUD Books (Web Interface)
    Route::prefix('books')->name('books.')->group(function () {
        Route::get('/', [BookController::class, 'indexWeb'])->name('index');
        Route::get('/create', [BookController::class, 'create'])->name('create');
        Route::post('/', [BookController::class, 'storeWeb'])->name('store');
        Route::get('/{id}', [BookController::class, 'showWeb'])->name('show');
        Route::get('/{id}/edit', [BookController::class, 'edit'])->name('edit');
        Route::put('/{id}', [BookController::class, 'updateWeb'])->name('update');
        Route::delete('/{id}', [BookController::class, 'destroyWeb'])->name('destroy');
    });

    // CRUD Tryout Programs (Blade Dashboard)
    Route::prefix('tryout-programs')->name('tryout-programs.')->group(function () {
        Route::get('/', [TryoutProgramController::class, 'indexWeb'])->name('index');
        Route::get('/create', [TryoutProgramController::class, 'create'])->name('create');
        Route::post('/', [TryoutProgramController::class, 'storeWeb'])->name('store');
        Route::get('/{id}', [TryoutProgramController::class, 'showWeb'])->name('show');
        Route::get('/{id}/edit', [TryoutProgramController::class, 'edit'])->name('edit');
        Route::put('/{id}', [TryoutProgramController::class, 'updateWeb'])->name('update');
        Route::delete('/{id}', [TryoutProgramController::class, 'destroyWeb'])->name('destroy');
    });
});

// Dashboard user biasa (setelah login)
Route::middleware(['auth'])->get('/dashboard', [AnalyticsController::class, 'dashboard'])->name('dashboard');

// Profile user
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth routes (login, register, logout)
Auth::routes();
