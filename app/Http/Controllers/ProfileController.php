<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordRequest;
use App\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('pages.profile.perfil');
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
    public function update(User $user,ProfileRequest $request, $id)
    {
        //
        if ($request->hasFile('arquivo') ) {

            $logotipo = $request->file('arquivo');

            $filenamelogotipo = $request->name.'-'.$logotipo->getClientOriginalName();

            $extension = $request->file('arquivo')->getClientOriginalExtension();

            $filenamelogotipo = str_replace(' ', '_', $filenamelogotipo);

            $path = $request->file('arquivo')->storeAs('fotoPerfil', $filenamelogotipo,'public');

            $request['foto_perfil'] = $filenamelogotipo;
        }


        $user->find($id)->update($request->all());
        //dd('sdfdsf');
        return redirect()->back()->with(['success' => "Perfil Alterado Com Sucesso"]);
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
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function passwordRequest(User $user, PasswordRequest $request,$id){
        $user->find($id)->update(['password' => Hash::make($request->password)]);
        return redirect()->back()->with(['success' => "Senha Alterada"]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function resetPassword(User $user,$id){
        $user->find($id)->update(['password' => Hash::make('secret')]);
        return redirect()->back()->with(['success' => "Senha Redefinida"]);
    }
}
