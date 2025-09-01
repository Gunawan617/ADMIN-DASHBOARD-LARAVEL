
<?php
use App\Http\Controllers\AnalyticsController;
// Analytics tracking endpoint

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\BimbelProgramController;
use App\Http\Controllers\TeamMemberController;
use App\Http\Controllers\TryoutProgramController;

Route::get('public/posts/slug/{slug}', [PostController::class, 'showBySlug']);
Route::post('analytics/track', [AnalyticsController::class, 'store']);
// Public
Route::get('public/bimbel-programs', [BimbelProgramController::class, 'index']);
Route::get('public/bimbel-programs/{id}', [BimbelProgramController::class, 'show']);
Route::get('public/team-members', [TeamMemberController::class, 'index']);
Route::get('public/team-members/{id}', [TeamMemberController::class, 'show']);
Route::get('public/books', [BookController::class, 'index']);
Route::get('public/books/{id}', [BookController::class, 'show']);
Route::get('public/tryout-programs', [TryoutProgramController::class, 'index']);
Route::get('public/tryout-programs/{id}', [TryoutProgramController::class, 'show']);

// Protected (admin)
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('admin/bimbel-programs', BimbelProgramController::class);
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
    Route::post('logout', [AuthenticatedSessionController::class, 'apiLogout']);

    // Books CRUD API
    Route::apiResource('admin/books', App\Http\Controllers\Admin\BookController::class);
    
    // Team Members CRUD API
    Route::apiResource('admin/team-members', TeamMemberController::class);
    
    // Tryout Programs CRUD API
    Route::apiResource('admin/tryout-programs', TryoutProgramController::class);
});

