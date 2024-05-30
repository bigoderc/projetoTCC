<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\StoreProfessorRequest;
use App\Models\Area;

use App\Models\Especialidade;
use App\Models\Grau;
use App\Models\Professor;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use App\Notifications\NotificarNovoUsuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class ProfessorController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $professor, $area, $especialidade, $grau, $user;

    public function __construct()
    {
        $this->area = new Area();
        $this->especialidade = new Especialidade();
        $this->grau = new Grau();
        $this->professor = new Professor();
        $this->user = new User();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Professor $professor)
    {
        //
        Gate::authorize('read-professor');
        return view('pages.professores.index', [
            'areas' => $this->area->get(),
            'especialidades' => $this->especialidade->get(),
            'graus' => $this->grau->get()
        ]);
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
    public function store(StoreProfessorRequest $request)
    {
        //
        Gate::authorize('insert-professor');
        DB::beginTransaction();
        $senha_temporaria = Helper::gerarSenha();
        try {
            //code...
            $user = $this->user->withTrashed()->where('email', $request->email)->whereNotNull('deleted_at')->first();

            if (!empty($user)) {
                $user->restore();
                $user->update(
                    [
                        "name" => $request->nome,
                        "password" => Hash::make($senha_temporaria),
                        "deleted_at" => null
                    ]
                );
            } else {
                $user = $this->user->create(
                    [
                        "name" => $request->nome,
                        "email" => $request->email,
                        "password" => Hash::make($senha_temporaria),
                    ]
                );
            }

            $role = Role::where('nome', 'professor')->first();
            RoleUser::create([
                'fk_roles_id' => $role->id,
                'fk_users_id' => $user->id
            ]);
            $request['fk_user_id'] = $user->id;
            $dados = Professor::create($request->all());
            $professor = Professor::find($dados->id);
            $professor->linhaPesquisas()->sync($request->linha_pesquisas);
            DB::commit();
            try {
                $user->notify(new NotificarNovoUsuario($senha_temporaria));
            } catch (\Throwable $th) {
                //throw $th;
            }
            return response()->json($this->professor->with(['linhaPesquisas', 'especialidade', 'grau', 'user'])->find($dados->id));
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json('Erro Interno',500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Professor  $professor
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
        return response()->json($this->professor->with(['linhaPesquisas', 'especialidade', 'grau', 'user'])->orderBy('id','desc')->get());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Professor  $professor
     * @return \Illuminate\Http\Response
     */
    public function findById($id)
    {
        //
        return response()->json($this->professor->with(['linhaPesquisas', 'especialidade', 'grau', 'user'])->find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Professor  $professor
     * @return \Illuminate\Http\Response
     */
    public function edit(Professor $professor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Professor  $professor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Professor $professor, $id)
    {
        //
        Gate::authorize('update-professor');
        DB::beginTransaction();
        try {
            //code...
            $professor->find($id)->update($request->all());
            $professor2 = Professor::find($id);
            $professor2->linhaPesquisas()->sync($request->linha_pesquisas);
            DB::commit();
            return response()->json($this->professor->with(['linhaPesquisas', 'especialidade', 'grau', 'user'])->find($id));
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json($th->getMessage(),500);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Professor  $professor
     * @return \Illuminate\Http\Response
     */
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Gate::authorize('delete-professor');
        $professor = $this->professor->find($id);
        try {
            //code...
            $this->user->find($professor->fk_user_id)->delete();
        } catch (\Throwable $th) {
            //throw $th;
        }
        
        $professor->delete();
        return response()->json(true);
    }
}
