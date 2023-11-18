<?php

namespace App\Http\Controllers;

use App\Models\AlunoTema;
use App\Models\Tema;
use Illuminate\Http\Request;

class DashboardAlunoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('pages.dashboard-aluno.index');
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
    public function store(Request $request)
    {
        //
        AlunoTema::where('fk_tema_id',$request->id)->update(['fk_professores_id'=>$request->professor_id]);

        $dados = Tema::with(['area','criado','temaAluno','temaAluno.professor'])->where('id',$request->id)->get();
        return response()->json($dados);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function findById($id)
    {
        //
        $dados = Tema::with(['area','criado','temaAluno','temaAluno.professor'])->where('id',$id)->first();
        return response()->json($dados);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tema  $tema
     * @return \Illuminate\Http\Response
     */
    public function linkThemeCheck(Tema $tema)
    {
        //
        $aluno = auth()->user()->aluno;
        $dados = Tema::with(['area','criado','temaAluno','temaAluno.professor'])->whereHas('temaAluno',function($query) use($aluno){
            $query->where('fk_alunos_id',$aluno->id);
        })->get();
        
        if(count($dados)>0){
            return response()->json($dados);
        }else{
            return response()->json(Tema::with(['area','criado','temaAluno','temaAluno.professor'])->get());
        }
       
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
