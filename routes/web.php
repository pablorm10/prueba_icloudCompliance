<?php

use App\Http\Controllers\Web\DocumentController;
use App\Http\Controllers\Web\LoginController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middleware\RoleMiddleware;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return view('home');
})->name('home');

//----------LOGIN------------------------------------------------------------------------
Route::middleware('guest')->group(function () {
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
});
Route::middleware('auth')->post('/logout', [LoginController::class, 'logout'])->name('logout');
//--------------------------------------------------------------------------------------


//--------GRAFICOS DOCUMENTOS--------------------------------------------------------------------------------
Route::middleware('auth')->get('/documents/chart', [DocumentController::class, 'showChart'])->name('documents.chart');
Route::middleware('auth')->get('/documents/approved-chart', [DocumentController::class, 'showChartDocumentsApprovedPerMonth'])->name('documents.approved.chart');


//--------------------------------------------------------------------------------------------------

//--------CRUD DOCUMENTOS--------------------------------------------------------------------------------
Route::middleware(['auth'])->group(function () {
Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
Route::get('/documents/{id}', [DocumentController::class, 'show'])->name('documents.show');
Route::get('/documents/{id}/edit', [DocumentController::class, 'edit'])->name('documents.edit')->middleware([RoleMiddleware::class . ':Responsable|Administrador']);
Route::put('/documents/{id}', [DocumentController::class, 'update'])->name('documents.update')->middleware([RoleMiddleware::class . ':Responsable|Administrador']);
Route::delete('/documents/{id}', [DocumentController::class, 'destroy'])->name('documents.destroy')->middleware([RoleMiddleware::class . ':Administrador']);
Route::get('/document/create', [DocumentController::class, 'create'])->name('document.create')->middleware([RoleMiddleware::class . ':Responsable|Administrador']);
Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store')->middleware([RoleMiddleware::class . ':Responsable|Administrador']);
Route::put('/documents/{id}/approve', [DocumentController::class, 'approveDocument'])->name('document.approve')->middleware([RoleMiddleware::class . ':Administrador']);
});
//--------------------------------------------------------------------------------------------------


//--------GRAFICOS DOCUMENTOS--------------------------------------------------------------------------------
Route::middleware('auth')->get('/documents/chart', [DocumentController::class, 'showChart'])->name('documents.chart');
Route::middleware('auth')->get('/documents/approved-chart', [DocumentController::class, 'showChartDocumentsApprovedPerMonth'])->name('documents.approved.chart');
//--------------------------------------------------------------------------------------------------




