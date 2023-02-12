<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\TemaController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\ProjetoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ConfiguracaoController;
// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
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
    Route::post('/areas/upload', [AreaController::class, 'upload'])->name('areas.upload');
    Route::get('areas/toView/{id}',[AreaController::class,'toView'])->name('areas.toView');
    Route::post('/alunos/update', [AlunoController::class, 'update'])->name('alunos.update1');
    Route::post('/configuracoes/permission', [ConfiguracaoController::class, 'permission'])->name('configuracoes.permission');
    Route::post('/configuracoes/update', [ConfiguracaoController::class, 'update'])->name('configuracoes.update1');
    
});
