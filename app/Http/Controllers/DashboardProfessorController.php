<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\AlunoTema;
use App\Models\Area;
use App\Models\Professor;
use App\Models\Tema;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardProfessorController extends Controller
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
        
        return view('pages.dashboard-professor.index',[
            'areas' => Area::all()
        ]);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deferir(Request $request)
    {
        //
        $data = [
            'justificativa' => $request->justificativa,
            'deferido' => $request->deferido == 'false' ? false : true,
        ];
        
        if ($request->deferido == 'false') {
            $data['fk_professores_id'] = null;
        }
        AlunoTema::where('fk_tema_id',$request->tema_id)->update($data);
        $professor = auth()->user()->professor;
        $dados = Tema::with(['areas','criado','temaAluno','temaAluno.professor','temaAluno.aluno'])->whereHas('temaAluno',function($query) use($professor){
            $query->where('fk_professores_id',$professor->id);
            $query->where(function ($query) {
                $query->where('deferido', '<>', false)
                    ->orWhereNull('deferido');
            });
        })->get();
        return response()->json($dados);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        //
        $professor = auth()->user()->professor;
        $query = $this->tema->query();
        
        $query->with(['areas'=>function($query) use($request){
            if($request->input('areas')){
                $query->whereIn('areas.id',$request->input('areas'));
            }
        },'criado','temaAluno','temaAluno.professor'])
        ->whereHas('areas',function($query) use($request){
            if ($request->input('areas')) {
                $query->whereIn('areas.id',$request->input('areas'));
            }
            
        })->whereHas('temaAluno',function($query) use($professor, $request){
            $query->where('fk_professores_id',$professor->id);
            switch ($request->status) {
                case 1:
                    # code...
                    $query->whereNull('deferido');
                    break;
                case 2:
                        $query->where('deferido', true);
                    break;
                default:
                    
                    break;
            }
        });
        
        $query->whereRaw('DATE(created_at) BETWEEN ? AND ?', [$request->data_inicio, $request->data_fim]);
                    
        $data = $query->orderBy('id','desc')->get();
        return response()->json($data);
       
        
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tema  $tema
     * @return \Illuminate\Http\Response
     */
    public function linkThemeCheck(Request $request)
    {
        //
        $professor = auth()->user()->professor;
        $dados = Tema::with(['areas','criado','temaAluno','temaAluno.professor','temaAluno.aluno'])->whereHas('temaAluno',function($query) use($professor, $request){
            $query->where('fk_professores_id',$professor->id);
            if($request->todos =='true'){
                $query->where(function ($query) {
                    $query->whereNull('deferido');
                });
            }else{
                $query->where(function ($query) {
                    $query->where('deferido', '<>', false)
                        ->orWhereNull('deferido');
                });
            }
            
        })->get();
        return response()->json($dados);
               
    }
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function notification()
    {
        //
        $professor = auth()->user()->professor;
        $dados = Tema::with(['areas','criado','temaAluno','temaAluno.professor','temaAluno.aluno'])->whereHas('temaAluno',function($query) use($professor){
            $query->where('fk_professores_id',$professor->id);
            $query->where(function ($query) {
                $query->whereNull('deferido');
            });
        })->count();
        return response()->json($dados);
               
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
