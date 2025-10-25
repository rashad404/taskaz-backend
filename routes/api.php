<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\Api\ContractController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\StatsController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\DistrictController;
use App\Http\Controllers\Api\ProfessionalApplicationController;
use App\Http\Controllers\Api\StartupController;

// Authentication Routes
Route::prefix('auth')->group(function () {
    // Email/Password Auth
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    // Phone OTP Auth
    Route::post('/otp/send', [AuthController::class, 'sendOTP']);
    Route::post('/otp/verify', [AuthController::class, 'verifyOTP']);

    // Email Verification
    Route::post('/email/send', [AuthController::class, 'sendEmailVerification']);
    Route::post('/email/verify', [AuthController::class, 'verifyEmailCode']);

    // Resend Verification Code (for both SMS and Email)
    Route::post('/resend-code', [AuthController::class, 'resendCode']);

    // Social OAuth
    Route::get('/{provider}', [AuthController::class, 'redirectToProvider'])
        ->where('provider', 'google|facebook');
    Route::get('/{provider}/callback', [AuthController::class, 'handleProviderCallback'])
        ->where('provider', 'google|facebook');
});

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    // User Profile
    Route::get('/user', [AuthController::class, 'me']);
    Route::put('/user', [AuthController::class, 'updateProfile']);
    Route::post('/user/change-password', [AuthController::class, 'changePassword']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // Tasks
    Route::post('/tasks', [TaskController::class, 'store']);
    Route::put('/tasks/{id}', [TaskController::class, 'update']);
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);
    Route::get('/my-tasks', [TaskController::class, 'myTasks']);

    // Applications
    Route::post('/applications', [ApplicationController::class, 'store']);
    Route::get('/my-applications', [ApplicationController::class, 'myApplications']);
    Route::post('/applications/{id}/accept', [ApplicationController::class, 'accept']);
    Route::post('/applications/{id}/reject', [ApplicationController::class, 'reject']);

    // Contracts
    Route::get('/contracts', [ContractController::class, 'index']);
    Route::get('/contracts/{id}', [ContractController::class, 'show']);
    Route::post('/contracts/{id}/complete', [ContractController::class, 'complete']);
    Route::post('/contracts/{id}/cancel', [ContractController::class, 'cancel']);

    // Payments
    Route::get('/payments', [PaymentController::class, 'index']);
    Route::post('/payments', [PaymentController::class, 'store']);
    Route::get('/payments/{id}', [PaymentController::class, 'show']);
    Route::post('/payments/{id}/confirm-client', [PaymentController::class, 'confirmByClient']);
    Route::post('/payments/{id}/confirm-professional', [PaymentController::class, 'confirmByprofessional']);

    // Reviews
    Route::post('/reviews', [ReviewController::class, 'store']);

    // Messages
    Route::get('/tasks/{taskId}/messages', [MessageController::class, 'index']);
    Route::post('/messages', [MessageController::class, 'store']);
    Route::get('/messages/unread-count', [MessageController::class, 'unreadCount']);
    Route::get('/conversations', [MessageController::class, 'conversations']);

    // Professional Applications
    Route::post('/professional/apply', [ProfessionalApplicationController::class, 'apply']);
    Route::get('/professional/status', [ProfessionalApplicationController::class, 'status']);
    Route::put('/professional/update', [ProfessionalApplicationController::class, 'update']);
    Route::post('/professional/reapply', [ProfessionalApplicationController::class, 'reapply']);
});

// Languages (public)
Route::get('/languages', [LanguageController::class, 'index']);

// Cities, Districts, Settlements, and Metro Stations (public)
Route::get('/cities', [CityController::class, 'index']);
Route::get('/cities/{id}/districts', [CityController::class, 'districts']);
Route::get('/cities/{id}/metro-stations', [CityController::class, 'metroStations']);
Route::get('/districts/{id}/settlements', [DistrictController::class, 'settlements']);

// Public Marketplace Routes
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);
Route::get('/tasks', [TaskController::class, 'index']);
Route::get('/tasks/{id}', [TaskController::class, 'show']);
Route::get('/professionals', [UserController::class, 'index']);
Route::get('/professionals/{identifier}', [UserController::class, 'show']);
Route::get('/clients', [UserController::class, 'indexClients']);
Route::get('/clients/{identifier}', [UserController::class, 'showClient']);
Route::get('/users/{userId}/reviews', [ReviewController::class, 'userReviews']);
Route::get('/top-professionals', [UserController::class, 'topprofessionals']);
Route::get('/search', [SearchController::class, 'search']);
Route::get('/stats', [StatsController::class, 'index']);

// Simple hello world endpoint
Route::get('/hello', function () {
    return response()->json([
        'message' => 'Hello from Task.az API!',
        'status' => 'success',
        'timestamp' => now()->toDateTimeString()
    ]);
});

// Health check endpoint
Route::get('/health', function () {
    return response()->json([
        'status' => 'healthy',
        'app' => config('app.name'),
        'version' => '1.0.0'
    ]);
});

// Language-specific hello endpoint
Route::get('/{locale}/hello', function ($locale) {
    $messages = [
        'az' => 'Salam Task.az!',
        'en' => 'Hello Task.az!',
        'ru' => 'Привет Task.az!'
    ];

    return response()->json([
        'message' => $messages[$locale] ?? $messages['en'],
        'locale' => $locale,
        'status' => 'success'
    ]);
})->where('locale', 'az|en|ru');

// Startups Cross-Promotion (Public)
Route::get('/startups', [StartupController::class, 'index']);
Route::get('/startups/limited/{limit}', [StartupController::class, 'limited']);
Route::post('/startups/clear-cache', [StartupController::class, 'clearCache'])->middleware('auth:sanctum');
