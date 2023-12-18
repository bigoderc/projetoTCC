<?php

namespace App\Http\Controllers;

use App\Models\AlunoTema;
use App\Models\Tema;
use Illuminate\Http\Request;

class DashboardProfessorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('pages.dashboard-professor.index');
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
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deferir(Request $request)
    {
        //
        $data = [
            'justificativa' => $request->justificativa,
            'deferido' => $request->deferido == 'false' ? false : true,
        ];
        
        if ($request->deferido == 'false') {
            $data['fk_professores_id'] = null;
        }
        AlunoTema::where('fk_tema_id',$request->tema_id)->update($data);
        $professor = auth()->user()->professor;
        $dados = Tema::with(['areas','criado','temaAluno','temaAluno.professor','temaAluno.aluno'])->whereHas('temaAluno',function($query) use($professor){
            $query->where('fk_professores_id',$professor->id);
            $query->where(function ($query) {
                $query->where('deferido', '<>', false)
                    ->orWhereNull('deferido');
            });
        })->get();
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
     * @param  \App\Models\Tema  $tema
     * @return \Illuminate\Http\Response
     */
    public function linkThemeCheck(Tema $tema)
    {
        //
        $professor = auth()->user()->professor;
        $dados = Tema::with(['areas','criado','temaAluno','temaAluno.professor','temaAluno.aluno'])->whereHas('temaAluno',function($query) use($professor){
            $query->where('fk_professores_id',$professor->id);
            $query->where(function ($query) {
                $query->where('deferido', '<>', false)
                    ->orWhereNull('deferido');
            });
        })->get();
        return response()->json($dados);
               
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
