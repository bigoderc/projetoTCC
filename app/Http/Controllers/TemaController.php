<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Tema;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Guid\Guid;
use Ramsey\Uuid\Uuid;

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
        Gate::authorize('read-proposta_tema');
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
        Gate::authorize('insert-proposta_tema');
        if($request->hasFile('file')){
            $file = $request->file('file');
            $imageUuid = Uuid::uuid4()->toString();
            $extension = $file->getClientOriginalExtension();
            $path = $imageUuid.'.'.$extension;
            $file->storeAs('temas', strtolower($path), 'public');
            $request['arquivo'] = strtolower($path);
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
        Gate::authorize('read-proposta_tema');
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
        Gate::authorize('update-proposta_tema');
        if($request->hasFile('file')){
            $file = $request->file('file');
            $imageUuid = Uuid::uuid4()->toString();
            $extension = $file->getClientOriginalExtension();
            $path = $imageUuid.'.'.$extension;
            $file->storeAs('temas', strtolower($path), 'public');
            $request['arquivo'] = strtolower($path);
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
        Gate::authorize('delete-proposta_tema');
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
