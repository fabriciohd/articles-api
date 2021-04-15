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

//ROTAS DO AUTH
Route::get('/401', [AuthController::class, 'unauthorized'])->name('login');

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);

Route::middleware('auth:api')->group(function() {
    Route::post('/auth/validate', [AuthController::class, 'validateToken']);
    Route::post('/auth/logout', [AuthController::class, 'logout']); 
});


//ESTATISTICAS
Route::get('/stats', [StatController::class, 'getAll']);


//ARTIGOS
Route::post('/article', [ArticleController::class, 'add'])->middleware('auth:api'); //TODO
Route::put('/article/{id}', [ArticleController::class, 'update'])->middleware('auth:api'); //TODO

Route::get('/articles', [ArticleController::class, 'getList']);
Route::get('/article/{id}', [ArticleController::class, 'get']);


//CATEGORIAS
Route::get('/categories', [CategoryController::class, 'getAll']);