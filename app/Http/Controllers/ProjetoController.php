<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjetoRequest;
use App\Models\Area;
use App\Models\Professor;
use App\Models\Projeto;
use Illuminate\Http\Request;

class ProjetoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $professor,$model,$area;

    public function __construct()
    {
        $this->professor = new Professor();
        $this->model = new Projeto();
        $this->area = new Area();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Projeto $projetos)
    {
        //
        //dd($projetos->get());
        return view('pages.projetos.index',['areas'=>$this->area->get(),'professores'=>$this->professor->get()]);
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
    public function store(StoreProjetoRequest $request)
    {
        //
        if($request->hasFile('arquivo')){
            // Get filename with the extension
            $filenameWithExt = $request->file('arquivo')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
           
            $extension = $request->file('arquivo')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'.'.$extension;
            // Upload Image
            $fileNameToStore = str_replace(" ", "",  $fileNameToStore);
            $path = $request->file('arquivo')->storeAs('projeto', $fileNameToStore,'public');
            $request['projeto'] = $fileNameToStore;
        }
        $dados=Projeto::create($request->all());
       
        return response()->json($this->model->with(['professor','area'])->find($dados->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Projeto  $projeto
     * @return \Illuminate\Http\Response
     */
    public function show(Projeto $projeto)
    {
        //
        return response()->json($this->model->with(['professor','area'])->get());
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Projeto  $projeto
     * @return \Illuminate\Http\Response
     */
    public function findById($id)
    {
        //
        return response()->json($this->model->with(['professor','area'])->find($id));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Projeto  $projeto
     * @return \Illuminate\Http\Response
     */
    public function edit(Projeto $projeto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Projeto  $projeto
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProjetoRequest $request, $id)
    {
        //
        if($request->hasFile('arquivo')){
            // Get filename with the extension
            $filenameWithExt = $request->file('arquivo')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
           
            $extension = $request->file('arquivo')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'.'.$extension;
            // Upload Image
            $fileNameToStore = str_replace(" ", "",  $fileNameToStore);
            $path = $request->file('arquivo')->storeAs('projeto', $fileNameToStore,'public');
            $request['projeto'] = $fileNameToStore;
        }
        $this->model->find($id)->update($request->all());
        return response()->json($this->model->with(['professor','area'])->find($id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Projeto  $projeto
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $this->model->find($id)->delete();
        return response()->json(true);
    }
}
