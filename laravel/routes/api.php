<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\ChatbotProxyController;

Route::middleware('api')->group(function () {
    // Auth routes
    Route::post('/signup', [AuthController::class, 'signup']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/send-otp', [AuthController::class, 'sendOtp']);
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
    Route::post('/check-email', [AuthController::class, 'checkEmail']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
    Route::post('/check-availability', [AuthController::class, 'checkAvailability']);


    // User routes
    Route::get('/user', [UserController::class, 'getUserProfile']);
    Route::post('/user/update', [UserController::class, 'update']);

    // Public recipe routes
    Route::get('/recipes/all', [RecipeController::class, 'allRecipes']);
    Route::get('/recipes/top', [RecipeController::class, 'topRecipes']);
    Route::get('/recipes/random', [RecipeController::class, 'randomRecipes']);
    Route::get('/recipes/category', [RecipeController::class, 'catRecipes']);
    Route::get('/recipes/budget', [RecipeController::class, 'budRecipes']);
    Route::get('/recipes/filter-combined', [RecipeController::class, 'filterCombined']);
    // Route for searching recipes
    Route::get('/recipes/search', [RecipeController::class, 'searchRecipes']);

    // Public comment routes
    Route::get('/recipes/{id}/comments', [RecipeController::class, 'getComments']);

    // Authenticated routes
    Route::middleware('auth:sanctum')->group(function () {
        // User route pakai token
        Route::get('/user', [UserController::class, 'getUserProfile']);
        Route::post('/user/update', [UserController::class, 'update']);

        // Recipe CRUD operations
        Route::post('/recipes', [RecipeController::class, 'store']);
        Route::put('/recipes/{id}', [RecipeController::class, 'update']);
        Route::delete('/recipes/{id}', [RecipeController::class, 'destroy']);
        
        // User-specific recipe routes
        Route::get('/user/recipes', [RecipeController::class, 'userRecipes']);
        Route::get('/user/recipes/liked', [RecipeController::class, 'likedRecipes']);

        // Comment routes
        Route::post('/recipes/{id}/comments', [RecipeController::class, 'addComment']);
        
        // Like/unlike routes
        Route::post('/recipes/{id}/like', [RecipeController::class, 'like']);
        Route::delete('/recipes/{id}/unlike', [RecipeController::class, 'unlike']);
        Route::get('/recipes/{id}/check-like', [RecipeController::class, 'checkLike']);
        Route::get('/recipes/liked', [RecipeController::class, 'likedRecipes']);
    });

    Route::post('/chatbot', [ChatbotProxyController::class, 'handle']);
    Route::get('/recipes/{id}', [RecipeController::class, 'show']);

});
