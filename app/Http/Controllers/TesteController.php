<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teste;

class TesteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('st.home');
    }

    public function tabela(){
        return view('st.tabela');
    }
    
    public function create(Request $request)
    {
        $teste['dados'] = Teste::create([
            'nome' => $request->nome,
            'hospital' => $request->hospital,
            'valor' => $request->valor
        ]);

        $teste['success'] = true;
        
        return json_encode($teste);
    }

    public function show()
    {   
        $teste = Teste::all();
        return response()->json($teste);;
    }

    public function edit(Request $request)
    {
        if($request->ajax()){
            Teste::find($request->input('pk'))->update([$request->input('name') => $request->input('value')]);
            return response()->json(['success' => true]);
        }
    }

    public function destroy(Request $request)
    {
        if($request->ajax()){
            Teste::find($request->input('pk'))->delete();
            return response()->json(['success' => true]);
        }
    }
}
