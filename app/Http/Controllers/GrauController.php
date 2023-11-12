<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGrauRequest;
use App\Models\Grau;
use Illuminate\Http\Request;

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
        $dados = Grau::create($request->all());
        return response()->json($dados);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Grau  $grau
     * @return \Illuminate\Http\Response
     */
    public function show(Grau $grau)
    {
        //
        return response()->json(Grau::all());
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
    public function update(Request $request, Grau $grau)
    {
        //
        if($request->ajax()){
            $grau->find($request->input('pk'))->update([$request->input('name') => $request->input('value')]);
            return response()->json(['success' => true]);
        }
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
       Grau::find($id)->delete();
        return response()->json(['success' => true]);
    }
}
