<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Tema;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TemaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Tema $tema)
    {
        //
        $areas = Area::all();
        return view('pages.temas.index',['areas'=>$areas]);
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
        if($request->hasFile('file')){
            $value = $request->file('file');
            $name = $request->nome.'-'.$value->getClientOriginalName();
            Storage::disk('public')->putFileAs('temas',$value,$name);
           $request['arquivo'] = $name;
        }
        $dados =Tema::create($request->all());
        return response()->json(Tema::with(['area'])->find($dados->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tema  $tema
     * @return \Illuminate\Http\Response
     */
    public function show(Tema $tema)
    {
        //
        $user = request()->user();
        $data = User::with('roles')->find($user->id);

        if ($data) {
            $data->role = $data->roles->first();
        }
        if($data->role->nome =='aluno'){
            return response()->json(Tema::with(['area','criado'])->where('user_id_created',$user->id)->get());
        }else{
            return response()->json(Tema::with(['area','criado'])->get());
        }
        
    }

    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tema  $tema
     * @return \Illuminate\Http\Response
     */
    public function edit(Tema $tema)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tema  $tema
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tema $tema,$id)
    {
        //
        if($request->hasFile('file')){
            $value = $request->file('file');
            $name = $request->nome.'-'.$value->getClientOriginalName();
            Storage::disk('public')->putFileAs('temas',$value,$name);
            $request['arquivo'] = $name;
        }
        $tema->find($id)->update($request->all());
        return response()->json($tema->with(['area'])->find($id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tema  $tema
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Tema::find($id)->delete();
        return response()->json(['success' => true]);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Aluno  $aluno
     * @return \Illuminate\Http\Response
     */
    public function findById($id){
        return response()->json(Tema::with(['area'])->find($id));
    }
    public function toView(Tema $tema,$id){
        $tema = $tema->find($id);
        $file =Storage::url("temas/".$tema->arquivo);
        $pos = strpos($tema->arquivo, '.pdf');
        if ($pos === false) {
            echo "<img src='{$file}'/>";
        }else{  
            echo "<iframe src='{$file}' width='100%' height='99%'></iframe>";
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tema  $tema
     * @return \Illuminate\Http\Response
     */
    public function upload(Tema $tema, Request $request)
    {
        //
        //dd('merda');
        if($request->hasFile('file')){
            $value = $request->file('file');
            $name = $request->nome.'-'.$value->getClientOriginalName();
            Storage::disk('public')->putFileAs('temas',$value,$name);
           $request['arquivo'] = $name;
        }
        $tema->find($request->id)->update($request->all());
        return response()->json(['success' => true]);
    }
}
