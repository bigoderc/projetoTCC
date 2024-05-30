<?php

namespace App\Http\Controllers;

use App\Models\Biblioteca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BibliotecaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        Gate::authorize('read-biblioteca');
        return view('pages.bibliotecas.index');
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
        Gate::authorize('insert-biblioteca');
        $dados =Biblioteca::create($request->all());
       
        return response()->json($dados);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Biblioteca  $biblioteca
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
        Gate::authorize('read-biblioteca');
        return response()->json(Biblioteca::orderBy('id','desc')->get());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Biblioteca  $biblioteca
     * @return \Illuminate\Http\Response
     */
    public function edit(Biblioteca $biblioteca)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Biblioteca  $biblioteca
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //
        Gate::authorize('update-biblioteca');
        Biblioteca::find($id)->update($request->all());
        return response()->json(Biblioteca::find($id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Biblioteca  $biblioteca
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Gate::authorize('delete-biblioteca');
        Biblioteca::find($id)->delete();
        return response()->json(['success' => true]);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Aluno  $aluno
     * @return \Illuminate\Http\Response
     */
    public function findById($id){
        return response()->json(Biblioteca::find($id));
    }
}
