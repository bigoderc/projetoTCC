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
use App\Http\Controllers\DashboardProfessorController;
use App\Http\Controllers\EspecialidadeController;
use App\Http\Controllers\GrauController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjetoPreTccController;
use App\Http\Controllers\TurmaController;
use App\Models\Professor;

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'home'])->name('home.inicio');
Route::group(['middleware' => 'auth:web'], function () {
    // Sitema de teste
   
    Route::resources([
        'temas' => TemaController::class,
        'area' => AreaController::class,
        'professor' =>ProfessorController::class,
        'users' =>UserController::class,
        'discente' =>AlunoController::class,
        'projetos'=>ProjetoController::class,
        'projetos-pre-tcc'=>ProjetoPreTccController::class,
        'configuracoes'=>ConfiguracaoController::class,
        'curso'=>CursoController::class,
        'turma'=>TurmaController::class,
        'especialidade'=>EspecialidadeController::class,
        'grau'=>GrauController::class,
    ]);
    Route::post('/area/update', [AreaController::class, 'update'])->name('area.update1');
    Route::post('/curso/update', [CursoController::class, 'update'])->name('curso.update1');
    Route::post('/turma/update', [TurmaController::class, 'update'])->name('turma.update1');
    Route::post('/especialidade/update', [EspecialidadeController::class, 'update'])->name('especialidade.update1');
    Route::post('/grau/update', [GrauController::class, 'update'])->name('grau.update1');
    Route::post('/area/upload', [AreaController::class, 'upload'])->name('area.upload');
    Route::get('area/toView/{id}',[AreaController::class,'toView'])->name('area.toView');
    Route::put('/discente/update/{id}', [AlunoController::class, 'update'])->name('discente.update');
    Route::get('/discente/findById/{id}', [AlunoController::class, 'findById'])->name('discente.findById');
    Route::get('/professor/findById/{id}', [ProfessorController::class, 'findById'])->name('professor.findById');
    Route::put('/professor/update/{id}', [ProfessorController::class, 'update'])->name('professor.update');
    Route::get('/temas/findById/{id}', [TemaController::class, 'findById'])->name('temas.findById');
    Route::post('/temas/update/{id}', [TemaController::class, 'update'])->name('temas.update');
    Route::get('/temas/toView/{id}',[TemaController::class,'toView'])->name('temas.toView');
    Route::post('/temas/upload', [TemaController::class, 'upload'])->name('temas.upload');
    Route::get('/projetos/findById/{id}', [ProjetoController::class, 'findById'])->name('projetos.findById');
    Route::get('/projetos/findByProfessor/{id}', [ProjetoController::class, 'findByProfessor'])->name('projetos.findByProfessor');
    Route::post('/projetos/update/{id}', [ProjetoController::class, 'update'])->name('projetos.update');
    Route::get('/projetos-pretcc/findById/{id}', [ProjetoPreTccController::class, 'findById'])->name('projetos-pre-tcc.findById');
    Route::get('/projetos-pretcc/findByProfessor/{id}', [ProjetoPreTccController::class, 'findByProfessor'])->name('projetos-pre-tcc.findByProfessor');
    Route::post('/projetos-pretcc/update/{id}', [ProjetoPreTccController::class, 'update'])->name('projetos-pre-tcc.update');
    
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
        Route::post('/confirmed', [DashboardAlunoController::class, 'confirmed'])->name('dashboardAluno.confirmed');
        Route::post('/setTema', [DashboardAlunoController::class, 'setTema'])->name('dashboardAluno.setTema');
        Route::post('/search', [DashboardAlunoController::class, 'search'])->name('dashboardAluno.search');
        Route::post('/linkTheme', [AlunoController::class, 'linkTheme'])->name('dashboardAluno.linkTheme');
        Route::get('/linkThemeCheck', [DashboardAlunoController::class, 'linkThemeCheck'])->name('dashboardAluno.linkThemeCheck');
    
    });
    Route::prefix('dashboardProfessor')->group(function () {
        Route::get('/index', [DashboardProfessorController::class, 'index'])->name('dashboardProfessor.index');
        Route::get('/findById/{id}', [DashboardProfessorController::class, 'findById'])->name('dashboardProfessor.findById');
        Route::post('/store', [DashboardProfessorController::class, 'store'])->name('dashboardProfessor.store');
        Route::post('/deferir', [DashboardProfessorController::class, 'deferir'])->name('dashboardProfessor.deferir');
        Route::post('/search', [DashboardProfessorController::class, 'search'])->name('dashboardProfessor.search');
        Route::get('/linkThemeCheck', [DashboardProfessorController::class, 'linkThemeCheck'])->name('dashboardProfessor.linkThemeCheck');
    
    });
    Route::prefix('profile')->group(function () {
        Route::get('/indes', [ProfileController::class, 'index'])->name('profile.index');
        Route::get('/show', [ProfileController::class, 'show'])->name('profile.show');
        Route::put('/passwordRequest/{id}', [ProfileController::class, 'passwordRequest'])->name('profile.passwordRequest');
        Route::get('/resetPassword/{id}', [ProfileController::class, 'resetPassword'])->name('profile.resetPassword');
        Route::put('/update/{id}', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('/delete/{id}', [ProfileController::class, 'destroy'])->name('profile.delete');
    });
});
