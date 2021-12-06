<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Web\PageController;
use App\Http\Controllers\NegotiationController;

/*Descomentar quando for criar o site principal!!!*/

//Route::get('/', [PageController::class, 'welcome'])->name('welcome');

Route::group(['middleware' => ['auth:sanctum', 'verified']], function(){
    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');
    Route::get('/chat', [PageController::class, 'chat'])->name('chat');
});

Route::group(['middleware' => 'auth'], function () {
  Route::group(['middleware' => 'role:admin', 'prefix' => 'admin', 'as' => 'admin.'], function() {
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    });
  Route::group(['middleware' => 'role:company', 'prefix' => 'company', 'as' => 'company.'], function() {
       Route::resource('projects', \App\Http\Controllers\Company\ProjectController::class);
       Route::get('/cn', [NegotiationController::class, 'company'])->name('cn');
   });
  Route::group(['middleware' => 'role:freelancer', 'prefix' => 'freelancer', 'as' => 'freelancer.'], function() {
        Route::resource('projects', \App\Http\Controllers\Freelancer\ProjectController::class);
        Route::get('/fn', [NegotiationController::class, 'freelancer'])->name('fn');
    });
});

/*Desenvolver pagina de Error 404 na Sprint 2 do projeto*/
Route::fallback(function() {
   abort(404);
});
