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
use App\Http\Controllers\CargoController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\ProjetoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ConfiguracaoController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\EspecialidadeController;
use App\Http\Controllers\GrauController;
use App\Http\Controllers\TurmaController;
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
        'configuracoes'=>ConfiguracaoController::class,
        'cursos'=>CursoController::class,
        'turmas'=>TurmaController::class,
        'especialidades'=>EspecialidadeController::class,
        'graus'=>GrauController::class,
        'cargos'=>CargoController::class
    ]);
    Route::post('/areas/update', [AreaController::class, 'update'])->name('areas.update1');
    Route::post('/cursos/update', [CursoController::class, 'update'])->name('cursos.update1');
    Route::post('/turmas/update', [TurmaController::class, 'update'])->name('turmas.update1');
    Route::post('/especialidades/update', [EspecialidadeController::class, 'update'])->name('especialidades.update1');
    Route::post('/graus/update', [GrauController::class, 'update'])->name('graus.update1');
    Route::post('/cargos/update', [CargoController::class, 'update'])->name('cargos.update1');
    Route::post('/areas/upload', [AreaController::class, 'upload'])->name('areas.upload');
    Route::get('areas/toView/{id}',[AreaController::class,'toView'])->name('areas.toView');
    Route::put('/alunos/update/{id}', [AlunoController::class, 'update'])->name('alunos.update');
    Route::get('/alunos/findById/{id}', [AlunoController::class, 'findById'])->name('alunos.findById');
    Route::post('/configuracoes/permission', [ConfiguracaoController::class, 'permission'])->name('configuracoes.permission');
    Route::post('/configuracoes/update', [ConfiguracaoController::class, 'update'])->name('configuracoes.update1');
    
});
