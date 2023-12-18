<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTemaRequest;
use App\Models\Area;
use App\Models\Tema;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
    public function store(StoreTemaRequest $request)
    {
        //
        Gate::authorize('insert-proposta_tema');
        DB::beginTransaction();
        try {
            //code...
            if($request->hasFile('file')){
                $file = $request->file('file');
                $imageUuid = Uuid::uuid4()->toString();
                $extension = $file->getClientOriginalExtension();
                $path = $imageUuid.'.'.$extension;
                $file->storeAs('temas', strtolower($path), 'public');
                $request['arquivo'] = strtolower($path);
            }
            $tema =Tema::create($request->all());
            $tema = Tema::with(['areas'])->find($tema->id);
            $tema->areas()->sync($request->areas);
            DB::commit();
            return response()->json(Tema::with(['areas'])->find($tema->id));
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json($th->getMessage(),500);
            
        }
        
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
            return response()->json(Tema::with(['areas','criado'])->where('user_id_created',$user->id)->get());
        }else{
            return response()->json(Tema::with(['areas','criado'])->get());
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
        DB::beginTransaction();
        try {
            //code...
            if($request->hasFile('file')){
                $file = $request->file('file');
                $imageUuid = Uuid::uuid4()->toString();
                $extension = $file->getClientOriginalExtension();
                $path = $imageUuid.'.'.$extension;
                $file->storeAs('temas', strtolower($path), 'public');
                $request['arquivo'] = strtolower($path);
            }
            $tema->find($id)->update($request->all());
            $tema = Tema::find($id);
            
            $tema->areas()->sync($request->areas);
            DB::commit();
            return response()->json($tema->with(['areas'])->find($id));
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json($th->getMessage(),500);
        }
        
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
        return response()->json(Tema::with(['areas'])->find($id));
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
