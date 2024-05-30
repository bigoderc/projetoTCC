<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTurmaRequest;
use App\Models\Curso;
use App\Models\Turma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TurmaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        Gate::authorize('read-turma');
        return view('pages.turmas.index',['cursos'=>Curso::all()]);
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
    public function store(StoreTurmaRequest $request)
    {
        //
        Gate::authorize('insert-turma');
        $turma = Turma::create($request->all());
        return response()->json(Turma::with('curso')->find($turma->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Turma  $turma
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        Gate::authorize('read-turma');
        return response()->json(Turma::with('curso')->where('fk_curso_id',$id)->orderBy('id','desc')->get());
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Turma  $turma
     * @return \Illuminate\Http\Response
     */
    public function edit(Turma $turma)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Turma  $turma
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        Gate::authorize('update-turma');
        Turma::find($id)->update($request->all());
        return response()->json(Turma::with('curso')->find($id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Turma  $turma
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Gate::authorize('delete-turma');
        Turma::find($id)->delete();
        return response()->json(['success' => true]);
    }
     /**
     * Display the specified resource.
     *
     * @param  \App\Models\Aluno  $aluno
     * @return \Illuminate\Http\Response
     */
    public function findById($id){
        return response()->json(Turma::with('curso')->find($id));
    }
}
