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
    /* return ['pong' => true]; */
    $faker = \Faker\Factory::create('pt_BR');
    echo $faker->name;
});

//ROTAS DO AUTH
Route::get('/401', [AuthController::class, 'unauthorized'])->name('login');
Route::post('/auth/login', [AuthController::class, 'login']);
//Obrigatorios: email, password
Route::post('/auth/register', [AuthController::class, 'register']);
//Obrigatorios: name, email, description, password, password_confirm
//Opcionais: image

//ESTATISTICAS
Route::get('/stats', [StatController::class, 'getAll']);

//ARTIGOS
Route::get('/articles', [ArticleController::class, 'getList']);
//Opcionais: category, title
Route::get('/article/{id}', [ArticleController::class, 'get']);

//CATEGORIAS
Route::get('/categories', [CategoryController::class, 'getAll']);


Route::middleware('auth:api')->group(function() {
    Route::post('/auth/validate', [AuthController::class, 'validateToken']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
});

Route::middleware(['auth:api', 'check.approved'])->group(function() {
    Route::post('/article', [ArticleController::class, 'addArticle']); //TODO
    Route::put('/article/{id}', [ArticleController::class, 'setArticle']); //TODO
    
    Route::post('/categories', [CategoryController::class, 'addCategory']); //TODO
    Route::put('/category/{id}', [CategoryController::class, 'setCategory']); //TODO
});

Route::middleware(['auth:api', 'check.adm'])->group(function() {
    Route::post('/approve/{id}', [UserController::class, 'approveUser']); //TODO
    //Obrigatorios: approved: (0,1), adm (0,1)
});