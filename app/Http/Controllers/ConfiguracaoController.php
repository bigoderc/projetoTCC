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
        Gate::authorize('read-configuracao');
        return view('pages.configuracoes.index');
    }

    public function permission()
    {
        //
       
        Gate::authorize('insert-configuracao') ||  Gate::authorize('update-configuracao');

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
        Gate::authorize('insert-configuracao');
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
        Gate::authorize('insert-configuracao') ||  Gate::authorize('update-configuracao');

        $permissions = new Permission; 
        
        $permissions = $permissions->get();
        $properties = DB::select("select pr.* from  permission_roles pr
        inner join permissions p on (pr.fk_permission_id = p.id)
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
        Gate::authorize('insert-configuracao') ||  Gate::authorize('update-configuracao');

        PermissionRole::where("fk_permission_id", $request->permission)->delete();

        if (!empty($request->acao)){
            foreach ($request->acao as $value) {
                PermissionRole::create([
                    'fk_permission_id' => $request->permission,
                    'fk_roles_id' => $request->role,
                    'acao' => $value
                ]);
            }
        }

        // if(empty($request->acao)){
        //     PermissionRole::where('fk_roles_id', $request->role)->where("fk_permission_id", $request->permission)->delete();
        // } else {
        //     if(!empty(PermissionRole::where('fk_roles_id', $request->role)->where("fk_permission_id", $request->permission))){
        //         PermissionRole::create([
        //             'fk_roles_id' => $request->role,
        //             'fk_permission_id' => $request->permission
        //         ]);
        //     }
        // }
        
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
    public function show()
    {
        //

        return response()->json(Role::all());
        
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
        Gate::authorize('update-configuracao');
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
    public function destroy($id)
    {
        //
        Gate::authorize('delete-configuracao');
        Role::find($id)->delete();
        return response()->json(true);
    }

    
}
