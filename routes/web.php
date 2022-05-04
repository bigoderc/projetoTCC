<?php

use App\Http\Controllers\AlunoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TesteController;
use App\Http\Controllers\TemaController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\ProjetoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ConfiguracaoController;
Auth::routes();

Route::get('/', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index'])->name('painel');

Route::group(['middleware' => 'auth:web'], function () {
    // Sitema de teste
   
    Route::resources([
        'temas' => TemaController::class,
        'areas' => AreaController::class,
        'professores' =>ProfessorController::class,
        'users' =>UserController::class,
        'alunos' =>AlunoController::class,
        'projetos'=>ProjetoController::class,
        'configuracoes'=>ConfiguracaoController::class
    ]);
    Route::post('/areas/update', [AreaController::class, 'update'])->name('areas.update1');
    Route::post('/alunos/update', [AlunoController::class, 'update'])->name('alunos.update1');
    Route::post('/configuracoes/permission', [ConfiguracaoController::class, 'permission'])->name('configuracoes.permission');
    Route::post('/configuracoes/update', [ConfiguracaoController::class, 'update'])->name('configuracoes.update1');
    
});