
<?php
use App\Http\Controllers\AnalyticsController;
// Analytics tracking endpoint

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\AlumniController;
use App\Http\Controllers\BimbelProgramController;
use App\Http\Controllers\TeamMemberController;
use App\Http\Controllers\TryoutProgramController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\FormulirController;

Route::get('public/posts/slug/{slug}', [PostController::class, 'showBySlug']);
Route::post('analytics/track', [AnalyticsController::class, 'store']);
// Public - DEPRECATED, use program-details instead
// Route::get('public/bimbel-programs', [BimbelProgramController::class, 'index']);
// Route::get('public/bimbel-programs/{id}', [BimbelProgramController::class, 'show']);
Route::get('public/team-members', [TeamMemberController::class, 'index']);
Route::get('public/team-members/{id}', [TeamMemberController::class, 'show']);
Route::get('public/books', [BookController::class, 'index']);
Route::get('public/books/{id}', [BookController::class, 'show']);
// DEPRECATED, use program-details instead
// Route::get('public/tryout-programs', [TryoutProgramController::class, 'index']);
// Route::get('public/tryout-programs/{id}', [TryoutProgramController::class, 'show']);
Route::get('public/alumni', [AlumniController::class, 'index']);
Route::get('public/alumni/{id}', [AlumniController::class, 'show']);

// User submit alumni photo (authenticated)
Route::middleware('auth:sanctum')->post('user/alumni/submit', [AlumniController::class, 'userSubmit']);
Route::get('public/testimonials', [TestimonialController::class, 'index']);
Route::get('public/program-details', [App\Http\Controllers\Admin\ProgramDetailController::class, 'apiIndex']);
Route::get('public/program-details/{slug}', [App\Http\Controllers\Admin\ProgramDetailController::class, 'apiShow']);

// Formulir Pendaftaran
Route::post('public/formulir', [FormulirController::class, 'store']);

// Contact Form
Route::post('public/contact', [App\Http\Controllers\ContactController::class, 'store']);

// FAQ
Route::get('public/faqs', function () {
    return response()->json(App\Models\Faq::active()->ordered()->get());
});

// Hero Section
Route::get('public/hero-section', [App\Http\Controllers\Api\HeroSectionController::class, 'index']);

// Video Section
Route::get('public/video-section', [App\Http\Controllers\Api\VideoSectionController::class, 'index']);

// Protected (admin)
Route::middleware('auth:sanctum')->group(function () {
    // DEPRECATED, use program-details instead
    // Route::apiResource('admin/bimbel-programs', BimbelProgramController::class);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('admin/team-members', TeamMemberController::class);
});



Route::get('public/posts', [PostController::class, 'indexApi']);
Route::get('public/posts/{id}', [PostController::class, 'showApi']);


// Public routes
Route::post('register', [RegisteredUserController::class, 'storeApi']);
Route::post('login', [AuthenticatedSessionController::class, 'apiLogin']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('admin/posts', [PostController::class, 'indexApi']);
    Route::get('admin/posts/{id}', [PostController::class, 'showApi']);
    Route::post('admin/posts', [PostController::class, 'storeApi']);
    Route::put('admin/posts/{id}', [PostController::class, 'updateApi']);
    Route::delete('admin/posts/{id}', [PostController::class, 'destroyApi']);

    Route::get('user/profile', [AuthenticatedSessionController::class, 'profile']);
    Route::post('user/profile', [AuthenticatedSessionController::class, 'updateProfile']);
    Route::post('logout', [AuthenticatedSessionController::class, 'apiLogout']);

    // Books CRUD API
    Route::apiResource('admin/books', App\Http\Controllers\Admin\BookController::class);
    
    // Team Members CRUD API
    Route::apiResource('admin/team-members', TeamMemberController::class);
    
    // Tryout Programs CRUD API - DEPRECATED, use program-details instead
    // Route::apiResource('admin/tryout-programs', TryoutProgramController::class);

    // Alumni CRUD API
    Route::apiResource('admin/alumni', AlumniController::class);

    // User Testimonials
    Route::get('user/testimonials', [TestimonialController::class, 'myTestimonials']);
    Route::post('user/testimonials', [TestimonialController::class, 'store']);
    Route::put('user/testimonials/{id}', [TestimonialController::class, 'update']);
    Route::delete('user/testimonials/{id}', [TestimonialController::class, 'destroy']);

    // Admin Testimonials
    Route::get('admin/testimonials', [TestimonialController::class, 'adminIndex']);
    Route::post('admin/testimonials/{id}/approve', [TestimonialController::class, 'approve']);
    Route::post('admin/testimonials/{id}/reject', [TestimonialController::class, 'reject']);
    Route::delete('admin/testimonials/{id}', [TestimonialController::class, 'adminDestroy']);

    // Admin Formulir
    Route::get('admin/formulir', [FormulirController::class, 'index']);
    Route::get('admin/formulir/{id}', [FormulirController::class, 'show']);
    Route::put('admin/formulir/{id}/status', [FormulirController::class, 'updateStatus']);
    Route::delete('admin/formulir/{id}', [FormulirController::class, 'destroy']);
});

