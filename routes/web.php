<?php

use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\TryoutProgramController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Homepage (public) - React Website Clone
Route::get('/', function () {
    return view('website');
});

// Registration page
Route::get('/daftar', function () {
    return view('website');
});

// Old welcome page (if needed)
Route::get('/welcome', function () {
    return view('welcome');
});

// Group Admin (wajib login)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AnalyticsController::class, 'dashboard'])->name('dashboard');

    // CRUD Bimbel Programs (Blade Dashboard) - DEPRECATED, use program-details instead
    // Route::resource('bimbel-programs', \App\Http\Controllers\Admin\BimbelProgramController::class);

    // CRUD Team Members
    Route::resource('team-members', TeamMemberController::class);

    // CRUD Posts, Users, Books
    Route::resource('posts', PostController::class)->names('posts');
    Route::resource('users', App\Http\Controllers\Admin\UserController::class)
        ->except(['create', 'store', 'show'])
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

    // CRUD Tryout Programs (Blade Dashboard) - DEPRECATED, use program-details instead
    // Route::prefix('tryout-programs')->name('tryout-programs.')->group(function () {
    //     Route::get('/', [TryoutProgramController::class, 'indexWeb'])->name('index');
    //     Route::get('/create', [TryoutProgramController::class, 'create'])->name('create');
    //     Route::post('/', [TryoutProgramController::class, 'storeWeb'])->name('store');
    //     Route::get('/{id}', [TryoutProgramController::class, 'showWeb'])->name('show');
    //     Route::get('/{id}/edit', [TryoutProgramController::class, 'edit'])->name('edit');
    //     Route::put('/{id}', [TryoutProgramController::class, 'updateWeb'])->name('update');
    //     Route::delete('/{id}', [TryoutProgramController::class, 'destroyWeb'])->name('destroy');
    // });

    // CRUD Alumni (Blade Dashboard)
    Route::prefix('alumni')->name('alumni.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\AlumniController::class, 'indexWeb'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\AlumniController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Admin\AlumniController::class, 'storeWeb'])->name('store');
        Route::post('/{id}/approve', [App\Http\Controllers\Admin\AlumniController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [App\Http\Controllers\Admin\AlumniController::class, 'reject'])->name('reject');
        Route::get('/{id}', [App\Http\Controllers\Admin\AlumniController::class, 'showWeb'])->name('show');
        Route::get('/{id}/edit', [App\Http\Controllers\Admin\AlumniController::class, 'edit'])->name('edit');
        Route::put('/{id}', [App\Http\Controllers\Admin\AlumniController::class, 'updateWeb'])->name('update');
        Route::delete('/{id}', [App\Http\Controllers\Admin\AlumniController::class, 'destroyWeb'])->name('destroy');
    });

    // Testimonials Management
    Route::prefix('testimonials')->name('testimonials.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\TestimonialAdminController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\TestimonialAdminController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Admin\TestimonialAdminController::class, 'store'])->name('store');
        Route::get('/{testimonial}/edit', [App\Http\Controllers\Admin\TestimonialAdminController::class, 'edit'])->name('edit');
        Route::put('/{testimonial}', [App\Http\Controllers\Admin\TestimonialAdminController::class, 'update'])->name('update');
        Route::post('/{testimonial}/approve', [App\Http\Controllers\Admin\TestimonialAdminController::class, 'approve'])->name('approve');
        Route::post('/{testimonial}/reject', [App\Http\Controllers\Admin\TestimonialAdminController::class, 'reject'])->name('reject');
        Route::delete('/{testimonial}', [App\Http\Controllers\Admin\TestimonialAdminController::class, 'destroy'])->name('destroy');
    });

    // Program Details Management
    Route::resource('program-details', App\Http\Controllers\Admin\ProgramDetailController::class);

    // Formulir Pendaftaran Management
    Route::prefix('formulir')->name('formulir.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\FormulirAdminController::class, 'index'])->name('index');
        Route::post('bulk-delete', [App\Http\Controllers\Admin\FormulirAdminController::class, 'bulkDelete'])->name('bulk-delete');
        Route::get('{id}', [App\Http\Controllers\Admin\FormulirAdminController::class, 'show'])->name('show');
        Route::post('{id}/status', [App\Http\Controllers\Admin\FormulirAdminController::class, 'updateStatus'])->name('update-status');
        Route::delete('{id}', [App\Http\Controllers\Admin\FormulirAdminController::class, 'destroy'])->name('destroy');
    });

    // Contact Messages Management
    Route::prefix('contacts')->name('contacts.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\ContactAdminController::class, 'index'])->name('index');
        Route::get('{id}', [App\Http\Controllers\Admin\ContactAdminController::class, 'show'])->name('show');
        Route::post('{id}/status', [App\Http\Controllers\Admin\ContactAdminController::class, 'updateStatus'])->name('update-status');
        Route::delete('{id}', [App\Http\Controllers\Admin\ContactAdminController::class, 'destroy'])->name('destroy');
    });

    // FAQ Management
    Route::resource('faqs', App\Http\Controllers\Admin\FaqController::class);

    // Hero Sections Management
    Route::resource('hero-sections', App\Http\Controllers\Admin\HeroSectionController::class);
    Route::patch('hero-sections/{heroSection}/toggle-active', [App\Http\Controllers\Admin\HeroSectionController::class, 'toggleActive'])->name('hero-sections.toggle-active');

    // Video Sections Management
    Route::resource('video-sections', App\Http\Controllers\Admin\VideoSectionController::class);
    Route::patch('video-sections/{videoSection}/toggle-active', [App\Http\Controllers\Admin\VideoSectionController::class, 'toggleActive'])->name('video-sections.toggle-active');

    // Program News Management
    Route::resource('program-news', App\Http\Controllers\Admin\ProgramNewController::class);
});

// Dashboard user biasa (setelah login)
Route::middleware(['auth'])->get('/dashboard', [AnalyticsController::class, 'dashboard'])->name('dashboard');

// Profile user
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Auth routes (login, logout only)
Route::prefix('admin')->group(function () {
    // Login Routes
    Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
    Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
});

// SPA Fallback - Catch all routes and return React app
// This must be the LAST route
Route::get('/{any}', function () {
    return view('website');
})->where('any', '^(?!api|admin|storage).*$');
