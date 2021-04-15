<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    AuthController,
    ArticleController,
    StatController,
    UserController,
    CategoryController,
};

Route::get('/ping', function() {
    return ['pong' => true];
});

Route::get('/401', [AuthController::class, 'unauthorized'])->name('login');

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);


//ESTATISTICAS
Route::get('/stats', [StatController::class, 'getAll']);


//ARTIGOS
Route::post('/article', [ArticleController::class, 'add'])->middleware('auth:api'); //TODO
Route::put('/article/{id}', [ArticleController::class, 'update'])->middleware('auth:api'); //TODO

Route::get('/articles', [ArticleController::class, 'getList']); //TODO
Route::get('/article/{id}', [ArticleController::class, 'get']); //TODO


//CATEGORIAS
Route::get('/categories', [CategoryController::class, 'getAll']); //TODO


Route::middleware('auth:api')->group(function() {
    Route::post('/auth/validate', [AuthController::class, 'validateToken']); //TODO
    Route::post('/auth/logout', [AuthController::class, 'logout']); //TODO    
});
