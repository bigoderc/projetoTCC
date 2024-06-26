<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEspecialidadeRequest;
use App\Http\Requests\StoreEspecialidadesRequest;
use App\Models\Especialidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EspecialidadeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        Gate::authorize('read-especialidade');
        return view('pages.especialidades.index');
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
    public function store(StoreEspecialidadeRequest $request)
    {
        //
        Gate::authorize('insert-especialidade');
        $dados = Especialidade::create($request->all());
        return response()->json($dados);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Especialidade  $especialidade
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
        Gate::authorize('read-especialidade');
        return response()->json(Especialidade::orderBy('id','desc')->get());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Especialidade  $especialidade
     * @return \Illuminate\Http\Response
     */
    public function edit(Especialidade $especialidade)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Especialidade  $especialidade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        Gate::authorize('update-especialidade');
        Especialidade::find($id)->update($request->all());
        return response()->json(Especialidade::find($id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Especialidade  $especialidade
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Gate::authorize('delete-especialidade');
        Especialidade::find($id)->delete();
        return response()->json(['success' => true]);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Aluno  $aluno
     * @return \Illuminate\Http\Response
     */
    public function findById($id){
        return response()->json(Especialidade::find($id));
    }
}
