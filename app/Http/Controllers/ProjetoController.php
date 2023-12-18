<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjetoRequest;
use App\Models\Aluno;
use App\Models\Area;
use App\Models\Professor;
use App\Models\Projeto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Ramsey\Uuid\Uuid;

class ProjetoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $professor,$model,$area,$aluno;

    public function __construct()
    {
        $this->professor = new Professor();
        $this->model = new Projeto();
        $this->area = new Area();
        $this->aluno = new Aluno();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Projeto $projetos)
    {
        //
        Gate::authorize('read-tcc');
        //dd($projetos->get());
        return view('pages.projetos.index',['alunos'=>$this->aluno->get(),'areas'=>$this->area->get(),'professores'=>$this->professor->get()]);
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
    public function store(StoreProjetoRequest $request)
    {
        //
        Gate::authorize('insert-tcc');
        DB::beginTransaction();
        try {
            //code...
            if($request->hasFile('arquivo')){
                $file = $request->file('arquivo');
                $imageUuid = Uuid::uuid4()->toString();
                $extension = $file->getClientOriginalExtension();
                $path = $imageUuid.'.'.$extension;
                $file->storeAs('projetos', strtolower($path), 'public');
                $request['projeto'] = strtolower($path);
            }
            $dados=$this->model->create($request->all());
            $projeto = $this->model->with(['aluno','professor','areas'])->find($dados->id);
            $projeto->areas()->sync($request->areas);
            DB::commit();
            return response()->json($this->model->with(['aluno','professor','areas'])->find($dados->id));
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json($th->getMessage(),500);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Projeto  $projeto
     * @return \Illuminate\Http\Response
     */
    public function show(Projeto $projeto)
    {
        //
        Gate::authorize('read-tcc');
        return response()->json($this->model->with(['aluno','professor','areas'])->get());
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Projeto  $projeto
     * @return \Illuminate\Http\Response
     */
    public function findById($id)
    {
        //
        return response()->json($this->model->with(['aluno','professor','areas'])->find($id));
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Projeto  $projeto
     * @return \Illuminate\Http\Response
     */
    public function findByProfessor($id)
    {
        //
        return response()->json($this->model->with(['aluno','professor','areas'])->where('fk_professores_id',$id)->get());
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Projeto  $projeto
     * @return \Illuminate\Http\Response
     */
    public function edit(Projeto $projeto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Projeto  $projeto
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProjetoRequest $request, $id)
    {
        //
        Gate::authorize('update-tcc');
        DB::beginTransaction();
        try {
            //code...
            if($request->hasFile('arquivo')){
                $file = $request->file('arquivo');
                $imageUuid = Uuid::uuid4()->toString();
                $extension = $file->getClientOriginalExtension();
                $path = $imageUuid.'.'.$extension;
                $file->storeAs('projetos', strtolower($path), 'public');
                $request['projeto'] = strtolower($path);
            }
            $this->model->find($id)->update($request->all());
            $projeto = $this->model->find($id);
            $projeto->areas()->sync($request->areas);
            DB::commit();
            return response()->json($this->model->with(['aluno','professor','areas'])->find($id));
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json($th->getMessage(),500);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Projeto  $projeto
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Gate::authorize('delete-tcc');
        $this->model->find($id)->delete();
        return response()->json(true);
    }
}
