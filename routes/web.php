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
use App\Http\Controllers\DashboardAlunoController;
use App\Http\Controllers\EspecialidadeController;
use App\Http\Controllers\GrauController;
use App\Http\Controllers\TurmaController;
use App\Models\Professor;

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
    Route::get('/professores/findById/{id}', [ProfessorController::class, 'findById'])->name('professores.findById');
    Route::put('/professores/update/{id}', [ProfessorController::class, 'update'])->name('professores.update');
    Route::get('/temas/findById/{id}', [TemaController::class, 'findById'])->name('temas.findById');
    Route::post('/temas/update/{id}', [TemaController::class, 'update'])->name('temas.update');
    Route::get('/temas/toView/{id}',[TemaController::class,'toView'])->name('temas.toView');
    Route::post('/temas/upload', [TemaController::class, 'upload'])->name('temas.upload');
    Route::get('/projetos/findById/{id}', [ProjetoController::class, 'findById'])->name('projetos.findById');
    Route::post('/projetos/update/{id}', [ProjetoController::class, 'update'])->name('projetos.update');
    Route::get('/users/findById/{id}', [UserController::class, 'findById'])->name('users.findById');
    Route::put('/users/update/{id}', [UserController::class, 'update'])->name('users.update');
    
    //configuraçoes
    Route::get('/configuracao', [ConfiguracaoController::class, 'index'])->name('configuracao');
    Route::get('/configuracao/permission/{role}', [ConfiguracaoController::class, 'permission'])->name('configuracao.permission');
    Route::get('/configuracao/getPermission/{role}', [ConfiguracaoController::class, 'getPermission'])->name('configuracao.getPermission');
    Route::post('/configuracao/setPermission', [ConfiguracaoController::class, 'setPermission'])->name('configuracao.setPermission');
    Route::any('/configuracao/show', [ConfiguracaoController::class, 'show'])->name('configuracao.show');
    Route::post('/configuracao/store', [ConfiguracaoController::class, 'store'])->name('configuracao.store');
    Route::post('/configuracao/setRole', [ConfiguracaoController::class, 'setRole'])->name('configuracao.setRole');
    Route::post('/configuracao/update', [ConfiguracaoController::class, 'update'])->name('configuracao.update');
    Route::prefix('dashboardAluno')->group(function () {
        Route::get('/index', [DashboardAlunoController::class, 'index'])->name('dashboardAluno.index');
        Route::get('/findById/{id}', [DashboardAlunoController::class, 'findById'])->name('dashboardAluno.findById');
        Route::post('/store', [DashboardAlunoController::class, 'store'])->name('dashboardAluno.store');
        Route::post('/linkTheme', [AlunoController::class, 'linkTheme'])->name('dashboardAluno.linkTheme');
        Route::get('/linkThemeCheck', [DashboardAlunoController::class, 'linkThemeCheck'])->name('dashboardAluno.linkThemeCheck');
    
    });
});
