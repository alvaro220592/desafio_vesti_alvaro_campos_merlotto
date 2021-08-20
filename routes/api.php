<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function(){
    
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // cadastro de categoria
    Route::post('/categoria', [CategoryController::class, 'store']);
    
    // Exibição das categorias:
    Route::get('/categorias', [CategoryController::class, 'index']);

    // Exibição de categoria específica:
    Route::get('/categoria/{id}', [CategoryController::class, 'show']);

    // Update de categoria:
    Route::put('/categoria/{id}', [CategoryController::class, 'update']);

    // Deletar categoria:
    Route::delete('/categoria/{id}', [CategoryController::class, 'destroy']);

    // cadastro de produto
    Route::post('/produto', [ProductController::class, 'store']);
    
    // Exibição das produtos:
    Route::get('/produtos', [ProductController::class, 'index']);

    // Exibição de produto específica:
    Route::get('/produto/{id}', [ProductController::class, 'show']);

    // Update de produto:
    Route::put('/produto/{id}', [ProductController::class, 'update']);

    // Deletar produto:
    Route::delete('/produto/{id}', [ProductController::class, 'destroy']);

    // TESTE UPLOAD
    Route::post('/produto/imagens', [ProductController::class, 'teste_upload']);

    // logout
    Route::post('/logout', [AuthController::class, 'logout']);
});
