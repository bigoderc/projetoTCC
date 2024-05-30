<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGrauRequest;
use App\Models\Grau;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GrauController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        Gate::authorize('read-grau');
        return view('pages.graus.index');
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
    public function store(StoreGrauRequest $request)
    {
        //
        Gate::authorize('insert-grau');
        $dados = Grau::create($request->all());
        return response()->json($dados);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Grau  $grau
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
        Gate::authorize('read-grau');
        return response()->json(Grau::orderBy('id','desc')->get());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Grau  $grau
     * @return \Illuminate\Http\Response
     */
    public function edit(Grau $grau)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Grau  $grau
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        Gate::authorize('update-grau');
        Grau::find($id)->update($request->all());
        return response()->json(Grau::find($id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Grau  $grau
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Gate::authorize('delete-grau');
        Grau::find($id)->delete();
        return response()->json(['success' => true]);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Aluno  $aluno
     * @return \Illuminate\Http\Response
     */
    public function findById($id){
        return response()->json(Grau::find($id));
    }
}
