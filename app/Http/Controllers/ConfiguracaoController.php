<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\PermissionProperty;
use App\Models\Unidade;
use App\Models\UnidadeUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
    public function index()
    {
        //
        Gate::authorize('configuracoes');
        return view('pages.configuracoes.index');
    }

    public function permission()
    {
        //
       
        Gate::authorize('configuracoes');

        $roles = new role;
        
        return view('pages.configuracoes.permissoes')->with("model",  $roles->all());
      
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
    public function getPermission(Request $request,$id)
    {
        
        $permissions = new Permission;
        $permissionProperty = new PermissionProperty;
         
        $permissions = $permissions->get();
        $properties = DB::select("select pp.* from permission_properties pp
        inner join permissions p on (pp.fk_permission_id = p.id)
        inner join permission_roles pr on (pr.fk_permission_id = p.id)
        where pr.fk_roles_id = {$id}");
        //return $properties;
        foreach ($permissions as $permission) {
            foreach ($properties as $property) {
                if($permission->id == $property->fk_permission_id){
                    $permission[$property->acao] = true;
                }
            }
        }
        
        return json_encode($permissions);
        
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function setPermission(Request $request)
    {   
        
        PermissionProperty::where("fk_permission_id", $request->permission)->delete();

        if (!empty($request->acao)){
            foreach ($request->acao as $value) {
                PermissionProperty::create([
                    'fk_permission_id' => $request->permission,
                    'fk_role_id' => $request->role,
                    'acao' => $value
                ]);
            }
        }

        if(empty($request->acao)){
            PermissionRole::where('fk_roles_id', $request->role)->where("fk_permission_id", $request->permission)->delete();
        } else {
            if(!empty(PermissionRole::where('fk_roles_id', $request->role)->where("fk_permission_id", $request->permission))){
                PermissionRole::create([
                    'fk_roles_id' => $request->role,
                    'fk_permission_id' => $request->permission
                ]);
            }
        }
        
        $dados['success'] = true;
        return json_encode($dados);
      
    }
   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function setRole(Request $request)
    {
        //

        foreach($request->permission as $id){
            PermissionRole::create([
                'fk_roles_id' =>$request->roles,
                'fk_permission_id' =>$id
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
