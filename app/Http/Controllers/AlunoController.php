<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlunoStoreRequest;
use App\Models\Aluno;
use App\Models\Curso;
use Illuminate\Http\Request;

class AlunoController extends Controller
{
    protected $model;
    public function __construct(Aluno $aluno)
    {
     $this->model = $aluno;   
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Aluno $alunos)
    {
        //
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
        $dados=Aluno::create($request->all());
        return response()->json($this->model->with(['curso','turma'])->find($dados->id));
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
        return response()->json($this->model->with(['curso','turma'])->get());
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
    public function update(AlunoStoreRequest $request, Aluno $aluno,$id)
    {
        //
        
        $aluno->find($id)->update($request->all());
        return response()->json($aluno->with(['curso','turma'])->find($id));
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
        Aluno::find($id)->delete();
        return response()->json(['success' => true]);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Aluno  $aluno
     * @return \Illuminate\Http\Response
     */
    public function findById($id){
        return response()->json($this->model->with(['curso','turma'])->find($id));
    }
}
