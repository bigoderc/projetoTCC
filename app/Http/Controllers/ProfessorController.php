<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfessorRequest;
use App\Models\Area;

use App\Models\Especialidade;
use App\Models\Grau;
use App\Models\Professor;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class ProfessorController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $professor,$area,$especialidade,$grau,$user;

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
        Gate::authorize('professor');
        return view('pages.professores.index',[
            'areas'=>$this->area->get(),
            'especialidades'=>$this->especialidade->get(),
            'graus'=>$this->grau->get()
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
        $user = $this->user->create(
            [
                "name" =>$request->nome,
                "email" =>$request->email,
                "password" => Hash::make('alterar123'),
            ]
        );
        $role = Role::where('nome','professor')->first();
        RoleUser::create([
            'fk_roles_id'=>$role->id,
            'fk_users_id'=>$user->id
        ]);
        $request['fk_user_id'] = $user->id;
        $dados = Professor::create($request->all());
        return response()->json($this->professor->with(['areas','especialidade','graus','user'])->find($dados->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Professor  $professor
     * @return \Illuminate\Http\Response
     */
    public function show(Professor $professor)
    {
        //
        return response()->json($this->professor->with(['areas','especialidade','graus','user'])->get());
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
        return response()->json($this->professor->with(['areas','especialidade','graus','user'])->find($id));
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
    public function update(Request $request, Professor $professor,$id)
    {
        //
        $professor->find($id)->update($request->all());
        return response()->json($this->professor->with(['areas','especialidade','graus','user'])->find($id));
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
        $this->professor->find($id)->delete();
        return response()->json(true);
    }
}
