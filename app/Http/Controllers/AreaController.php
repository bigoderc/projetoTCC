<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAreaRequest;
use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

class AreaController extends Controller
{
    protected $model;
    public function __construct(Area $area)
    {
     $this->model = $area;   
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        Gate::authorize('read-area');
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
    public function store(StoreAreaRequest $request)
    {
        //
        Gate::authorize('insert-area');
        if($request->hasFile('file')){
            $file = $request->file('file');
            $imageUuid = Uuid::uuid4()->toString();
            $extension = $file->getClientOriginalExtension();
            $path = $imageUuid.'.'.$extension;
            $file->storeAs('areas', strtolower($path), 'public');
            $request['arquivo'] = strtolower($path);
        }
        
        $dados=Area::create($request->all());
        return response()->json($dados);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
        Gate::authorize('read-area');
        return response()->json($this->model->all());
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
        Gate::authorize('update-area');
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
    public function destroy($id)
    {
        //
        Gate::authorize('delete-area');
        Area::find($id)->delete();
        return response()->json(['success' => true]);
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
            $file = $request->file('file');
            $imageUuid = Uuid::uuid4()->toString();
            $extension = $file->getClientOriginalExtension();
            $path = $imageUuid.'.'.$extension;
            $file->storeAs('areas', strtolower($path), 'public');
            $request['arquivo'] = strtolower($path);
        }
        $area->find($request->id)->update($request->all());
        return response()->json(['success' => true]);
    }
    
    public function toView(Area $area,$id){
        $area = $area->find($id);
        $file =Storage::url("areas/".$area->arquivo);
        $pos = strpos($area->arquivo, '.pdf');
        if ($pos === false) {
            echo "<img src='{$file}'/>";
        }else{  
            echo "<iframe src='{$file}' width='100%' height='99%'></iframe>";
        }
    }

}
