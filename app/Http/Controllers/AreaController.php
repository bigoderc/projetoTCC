<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('pages.areas.index');
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
        $dados['dados']=Area::create($request->all());
        if(!empty($dados)){
            $dados['success'] =true;
        }
        return json_encode($dados);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function show(Area $area)
    {
        //
        $teste = $area->all();
        return response()->json($teste);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function edit(Area $area)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Area $area)
    {
        //
        if($request->ajax()){
            $area->find($request->input('pk'))->update([$request->input('name') => $request->input('value')]);
             return response()->json(['success' => true]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function destroy(Area $area)
    {
        //
    }
     /**
     * Display the specified resource.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function upload(Area $area, Request $request)
    {
        //
        //dd('merda');
        if($request->hasFile('file')){
            // Get filename with the extension
            $filenameWithExt = $request->file('file')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
           
            $extension = $request->file('file')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'.'.$extension;
            // Upload Image
            $fileNameToStore = str_replace(" ", "",  $fileNameToStore);
            $path = $request->file('file')->storeAs('anexos', $fileNameToStore,'public');
            $request['arquivo'] = $fileNameToStore;
        }
        $area->find($request->id)->update($request->all());
        return redirect()->route('areas.index');
    }
    
    public function toView(Area $area,$id){
        $area = $area->find($id);
        $img = asset("storage/projeto/".$area->arquivo);
        $pos = strpos($area->arquivo, '.pdf');
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

}
