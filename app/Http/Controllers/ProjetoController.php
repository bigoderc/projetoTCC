<?php

namespace App\Http\Controllers;

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
    public function index(Projeto $projetos)
    {
        //
        //dd($projetos->get());
        return view('pages.projetos.index',['projetos'=>$projetos->get(),'professores'=>Professor::get()]);
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
        $dados['dados']=Projeto::create($request->all());
        if(!empty($dados)){
            $dados['success'] =true;
        }
        return redirect()->route('projetos.index');
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
        
        $img = asset("storage/projeto/".$projeto->projeto);
        $pos = strpos($projeto->projeto, '.pdf');
        if ($pos === false) {
            echo "<img src='{$img}'/>";
        }else{
            header('Content-type: application/pdf');
            header('Content-Disposition: inline; filename="arquivo.pdf"');
            header('Content-Transfer-Encoding; binary');
            header('Accept-Ranges; bytes');
            readfile($img);
        }
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
    public function update(Request $request, Projeto $projeto)
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
        $projeto->update($request->all());
        return redirect()->route('projetos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Projeto  $projeto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Projeto $projeto)
    {
        //
    }
}
