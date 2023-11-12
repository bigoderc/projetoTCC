<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;
use App\Models\RoleUser;

class UserController extends Controller
{
    protected $model;
    public function __construct(User $user)
    {
     $this->model = $user;   
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $users)
    {
        //
        $roles = Role::get();
        return view('pages.users.index',['users'=>$users->get(),'roles'=>$roles]);
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
    public function store(StoreUserRequest $data)
    {
        //

        $dados=User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make('alterar123'),
        ]);
        $user = User::findOrFail($dados->id);
         // Atualizar os papéis (roles) do usuário usando sync
        $user->roles()->sync([$data->input('fk_roles_id')]);

        // Recarregar o modelo com a relação 'roles'
        $user = $user->load('roles');
       
        $data = $this->model->with('roles')->find($dados->id);

        if ($data) {
            $data->role = $data->roles->first();
        }

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $data = $this->model->with('roles')->get();

        $data->each(function ($item) {
            $item->role = $item->roles->first();
        });

        return response()->json($data);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function findById($id)
    {
        //
        $data = $this->model->with('roles')->find($id);

        if ($data) {
            $data->role = $data->roles->first();
        }

        return response()->json($data);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUserRequest $request,User $user, $id)
    {
        //
        $user = User::findOrFail($id);

        // Atualizar os dados do usuário
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);
    
        // Atualizar os papéis (roles) do usuário usando sync
        $user->roles()->sync([$request->input('fk_roles_id')]);
    
        // Recarregar o modelo com a relação 'roles'
        $user = $user->load('roles');
    
        $data = $this->model->with('roles')->find($id);

        if ($data) {
            $data->role = $data->roles->first();
        }

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $this->model->find($id)->delete();
        return response()->json(true);
    }
}
