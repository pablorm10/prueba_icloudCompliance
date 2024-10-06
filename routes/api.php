<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DocumentControllerApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PruebaController;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Models\Role;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/prueba', [PruebaController::class, 'store']);

Route::post('/login', [AuthController::class, 'login']);

//DOCUMENTS
 Route::post('/getDocuments', [DocumentControllerApi::class, 'index'])->middleware(['auth:sanctum', RoleMiddleware::class . ':Responsable|Administrador']);

