<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\MessageController;
use App\Http\Controllers\NegotiationController;

use App\Http\Controllers\Company\ProjectController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('/user/me', [UserController::class, 'me'])->name('users.me');
    Route::get('/users/getusers', [UserController::class, 'getUsers'])->name('users.getusers');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');

    Route::post('/messages/{user}', [MessageController::class, 'listMessages'])->name('message.listMessages');
    Route::post('/messages/store', [MessageController::class, 'store'])->name('message.store');

    Route::post('/negotiations/store', [NegotiationController::class,'store']);
    Route::post('/negotiations/negotiate', [NegotiationController::class,'negotiate']);
    Route::post('/negotiations/confirm', [NegotiationController::class,'confirmNegotiation']);
});

Route::fallback(function(){
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact joshbarrosweb@gmail.com'], 404);
});
