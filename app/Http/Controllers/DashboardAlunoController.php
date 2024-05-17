<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\AlunoTema;
use App\Models\Area;
use App\Models\Professor;
use App\Models\Tema;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardAlunoController extends Controller
{
    protected $model,$user,$professor,$area,$tema;
    public function __construct(Aluno $aluno,User $user,Professor $professor,Area $area,Tema $tema)
    {
        $this->model = $aluno;   
        $this->user = $user;   
        $this->professor = $professor;
        $this->area = $area;
        $this->tema = $tema;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('pages.dashboard-aluno.index',['areas'=>$this->area->all(),'professores'=>$this->professor->all()]);
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
        AlunoTema::where('fk_tema_id',$request->id)->update(['fk_professores_id'=>$request->professor_id]);

        $dados = Tema::with(['areas','criado','temaAluno','temaAluno.professor'])->where('id',$request->id)->get();
        return response()->json($dados);
    }

    /**
     * Confirmed a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function confirmed(Request $request)
    {
        //
        AlunoTema::where('fk_tema_id',$request->tema_id)->update([
            'justificativa'=>null,
            'deferido'=>null,
            'fk_professores_id'=>null
        ]);
        $dados = Tema::with(['areas','criado','temaAluno','temaAluno.professor'])->where('id',$request->tema_id)->get();
        return response()->json($dados);
    }
    /**
     * Confirmed a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function setTema(Request $request)
    {
        //
        AlunoTema::where('fk_tema_id',$request->tema_id)->delete();
        $dados = Tema::with(['areas','criado','temaAluno','temaAluno.professor'])->doesntHave('temaAluno')->get();
        return response()->json($dados);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        //
        $query = $this->tema->query();
        
        $query->with(['areas'=>function($query) use($request){
            if($request->input('areas')){
                $query->whereIn('areas.id',$request->input('areas'));
            }
        },'criado','temaAluno','temaAluno.professor'])
        ->whereHas('areas',function($query) use($request){
            if($request->input('areas')){
                $query->whereIn('areas.id',$request->input('areas'));
            }
        });
        $query->whereRaw('DATE(created_at) BETWEEN ? AND ?', [$request->data_inicio, $request->data_fim]);
        // if (!empty($request->area_id)) {
        //     $query->where('fk_areas_id',$request->area_id);
        // } 
        if (!empty($request->professor_id)) {
            $professor = Professor::find($request->professor_id);
            $query->where('user_id_created',$professor->fk_user_id);
        }        
        $data = $query->orderBy('id','desc')->doesntHave('temaAluno')->get();
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
        $dados = Tema::with(['areas','criado','temaAluno','temaAluno.professor'])->where('id',$id)->first();
        return response()->json($dados);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tema  $tema
     * @return \Illuminate\Http\Response
     */
    public function linkThemeCheck(Tema $tema)
    {
        //
        $aluno = auth()->user()->aluno;
        $dados = Tema::with(['areas','criado','temaAluno','temaAluno.professor'])->whereHas('temaAluno',function($query) use($aluno){
            $query->where('fk_alunos_id',$aluno->id ??0);
        })->orderBy('created_at','desc')->get();
        
        if(count($dados)>0){
            return response()->json($dados);
        }else{
            return response()->json(Tema::with(['areas','criado','temaAluno','temaAluno.professor'])->orderBy('created_at','desc')->doesntHave('temaAluno')->get());
        }
       
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
    public function update(Request $request, $id)
    {
        //
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
}
