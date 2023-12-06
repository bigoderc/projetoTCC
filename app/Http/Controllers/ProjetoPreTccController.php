<?php

namespace App\Http\Controllers;

use App\Models\ProjetoPreTcc;
use App\Http\Requests\StoreProjetoRequest;
use App\Models\Area;
use App\Models\Professor;
use App\Models\Projeto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Ramsey\Uuid\Uuid;

class ProjetoPreTccController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $professor,$model,$area;

    public function __construct()
    {
        $this->professor = new Professor();
        $this->model = new ProjetoPreTcc();
        $this->area = new Area();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        Gate::authorize('pre-tcc');
        //dd($projetos-pre-tcc->get());
        return view('pages.projetos-pre-tcc.index',['areas'=>$this->area->get(),'professores'=>$this->professor->get()]);
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
        if($request->hasFile('arquivo')){
            $file = $request->file('arquivo');
            $imageUuid = Uuid::uuid4()->toString();
            $extension = $file->getClientOriginalExtension();
            $path = $imageUuid.'.'.$extension;
            $file->storeAs('projetos-pre-tcc', strtolower($path), 'public');
            $request['projeto'] = strtolower($path);
        }
        $dados=Projeto::create($request->all());
       
        return response()->json($this->model->with(['professor','area'])->find($dados->id));
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
        return response()->json($this->model->with(['professor','area'])->get());
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
        return response()->json($this->model->with(['professor','area'])->find($id));
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
        return response()->json($this->model->with(['professor','area'])->where('fk_professores_id',$id)->get());
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
        if($request->hasFile('arquivo')){
            $file = $request->file('arquivo');
            $imageUuid = Uuid::uuid4()->toString();
            $extension = $file->getClientOriginalExtension();
            $path = $imageUuid.'.'.$extension;
            $file->storeAs('projetos-pre-tcc', strtolower($path), 'public');
            $request['projeto'] = strtolower($path);
        }
        $this->model->find($id)->update($request->all());
        return response()->json($this->model->with(['professor','area'])->find($id));
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
        $this->model->find($id)->delete();
        return response()->json(true);
    }
}
