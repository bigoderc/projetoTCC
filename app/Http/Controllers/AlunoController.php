<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\AlunoStoreRequest;
use App\Models\Aluno;
use App\Models\AlunoTema;
use App\Models\Curso;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\Tema;
use App\Models\User;
use App\Notifications\NotificarNovoUsuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class AlunoController extends Controller
{
    protected $model,$user,$aluno_tema;
    public function __construct(Aluno $aluno,User $user,AlunoTema $aluno_tema)
    {
        $this->model = $aluno;   
        $this->user = $user;   
        $this->aluno_tema = $aluno_tema;   
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Aluno $alunos)
    {
        //
        Gate::authorize('read-discente');
        return view('pages.alunos.index',['cursos'=>Curso::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AlunoStoreRequest $request)
    {
        //
        Gate::authorize('insert-discente');
        DB::beginTransaction();
        $senha_temporaria = Helper::gerarSenha();
        try {
            //code...
            if(isset($request->formado)){
                $request['formado']= true;
            }else{
                $request['formado']= false;
            }
            $user = $this->user->withTrashed()->where('email',$request->email)->whereNotNull('deleted_at')->first();
            
            if(!empty($user)){
                $user->restore();
                $user->update(
                    [
                        "name" =>$request->nome,
                        "password" => Hash::make($senha_temporaria)
                    ] 
                );
            }else{
                $user = $this->user->create(
                    [
                        "name" =>$request->nome,
                        "email" =>$request->email,
                        "password" => Hash::make($senha_temporaria),
                    ]
                );
            }
            
            $role = Role::where('nome','aluno')->first();
            RoleUser::create([
                'fk_roles_id'=>$role->id,
                'fk_users_id'=>$user->id
            ]);
            $request['fk_user_id'] = $user->id;
            $dados=Aluno::create($request->all());
            DB::commit();
            try {
                $user->notify(new NotificarNovoUsuario($senha_temporaria));
            } catch (\Throwable $th) {
                //throw $th;
            }
            return response()->json($this->model->with(['user','curso','turma'])->find($dados->id));
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json('Erro Interno',500);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Aluno  $aluno
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
        return response()->json($this->model->with(['user','curso','turma'])->get());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Aluno  $aluno
     * @return \Illuminate\Http\Response
     */
    public function edit(Aluno $aluno)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Aluno  $aluno
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Aluno $aluno,$id)
    {
        //
        Gate::authorize('update-discente');
        DB::beginTransaction();
        try {
            //code...
            if(isset($request->formado)){
                $request['formado']= true;
            }else{
                $request['formado']= false;
            }
            $aluno->find($id)->update($request->all());
            DB::commit();
            return response()->json($aluno->with(['user','curso','turma'])->find($id));
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json('Erro Interno',500);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Aluno  $aluno
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Gate::authorize('delete-discente');
        $aluno = Aluno::find($id);
        try {
            //code...
            User::find($aluno->fk_user_id)->delete();
        } catch (\Throwable $th) {
            //throw $th;
        }
        
        $aluno->delete();
        return response()->json(true);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Aluno  $aluno
     * @return \Illuminate\Http\Response
     */
    public function findById($id){
        return response()->json($this->model->with(['user','curso','turma'])->find($id));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function linkTheme(Request $request)
    {
        //
        $aluno = Aluno::where('fk_user_id',auth()->user()->id)->first();
        $tema = Tema::find($request->tema_id);
        $user = User::with('professor')->find($tema->user_id_created);
        if(empty($user->professor)){
            $this->aluno_tema->create(
                [
                    'fk_alunos_id'=>$aluno->id,
                    'fk_tema_id'=>$request->tema_id,
                ]
            );
        }else{
            $this->aluno_tema->create(
                [
                    'fk_alunos_id'=>$aluno->id,
                    'fk_tema_id'=>$request->tema_id,
                    'fk_professores_id'=>$user->professor->id
                ]
            );
        }
        
        $aluno = auth()->user()->aluno;
        $dados = Tema::with(['areas','criado','temaAluno','temaAluno.professor'])->whereHas('temaAluno',function($query) use($aluno){
            $query->where('fk_alunos_id',$aluno->id);
        })->get();
        return response()->json($dados);
            
    }
}
