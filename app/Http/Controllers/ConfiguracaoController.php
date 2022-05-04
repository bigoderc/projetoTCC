<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use App\Models\PermissionRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
class ConfiguracaoController extends Controller
{
    public function __construct()
    {

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Permission $model)
    {
        //
        //::authorize('configuracoes');
        return view('pages.configuracoes.index',['permissions'=>$model->all()]);
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
        $dados['dados']=Role::create([
            'nome' => $request['name'],
            'description' => $request['description'],
        ]);
        if(!empty($dados)){
            $dados['success'] = true;
        }
        return json_encode($dados);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function permission(Request $request)
    {
        //
       
        foreach($request->permission as $dd){
            PermissionRole::create([
                'fk_roles_id' =>$request->role,
                'fk_permission_id' =>$dd
            ]);
        }
        $dados['success'] = true;
        return json_encode($dados);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Configuracao  $configuracao
     * @return \Illuminate\Http\Response
     */
    public function show(Role $configuracao)
    {
        //

        return response()->json($configuracao->all());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Configuracao  $configuracao
     * @return \Illuminate\Http\Response
     */
    public function edit(Configuracao $configuracao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Configuracao  $configuracao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        if($request->ajax()){
            Role::find($request->input('pk'))->update([
                $request->input('name') => $request->input('value')
            ]);
             return response()->json(['success' => true]);
         }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Configuracao  $configuracao
     * @return \Illuminate\Http\Response
     */
    public function destroy(Configuracao $configuracao)
    {
        //
    }
}
