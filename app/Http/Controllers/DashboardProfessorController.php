<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\AlunoTema;
use App\Models\Area;
use App\Models\Professor;
use App\Models\Projeto;
use App\Models\ProjetoArea;
use App\Models\ProjetoPreTcc;
use App\Models\ProjetoPreTccArea;
use App\Models\Tema;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

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
        }else{
            $tema = Tema::with(['temaAluno','areas'])->find($request->tema_id);
            $dados=ProjetoPreTcc::create([
                'instituicao' => 'IF BAIANO',
                'fk_professores_id' => $tema->temaAluno->fk_professores_id,
                'fk_aluno_id' => $tema->temaAluno->fk_alunos_id,
                'nome' =>$tema->nome,
                'tema_id' => $request->tema_id
            ]);
            foreach ($tema->areas as $key => $value) {
                ProjetoPreTccArea::create([
                    'fk_projeto_pre_tcc_id' => $dados->id,
                    'fk_area_id' => $value->id
                ]);
            }
        }
        AlunoTema::where('fk_tema_id',$request->tema_id)->update($data);
        $professor = auth()->user()->professor;
        if($request->incrementar == 'true'){
            Professor::find($professor->id)->update(['disponibilidade' => ($professor->disponibilidade + 1)]);
        }
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
            $query->where('fk_professores_id',$professor->id)
            ->where('defendido',false);
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
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDashboard()
    {
        //
        $professor = auth()->user()->professor;
        $qtd_orientandos = AlunoTema::where('fk_professores_id',$professor->id)->where('deferido',1)->where('defendido',false)->count();
        $professor = Professor::find($professor->id);
        return response()->json(['qtd_orientandos'=>$qtd_orientandos, 'disponibilidade' => ($professor->disponibilidade - $qtd_orientandos)]);
               
    }
     /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function findByTema($id)
    {
        //
        $projeto_pre_tcc = ProjetoPreTcc::where('tema_id',$id)->first()->apresentacao;
        return response()->json($projeto_pre_tcc ? true : false);
               
    }
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function defendido(Request $request)
    {
        DB::beginTransaction();
        try {
            //code...
           
            $tema = Tema::with(['temaAluno','areas'])->find($request->tema_id);
            $projeto_pre_tcc = ProjetoPreTcc::where('tema_id',$request->tema_id)->first()->apresentacao;
            if($projeto_pre_tcc){
                if($request->hasFile('arquivo')){
                    $file = $request->file('arquivo');
                    $imageUuid = Uuid::uuid4()->toString();
                    $extension = $file->getClientOriginalExtension();
                    $path = $imageUuid.'.'.$extension;
                    $file->storeAs('projetos', strtolower($path), 'public');
                    $request['projeto'] = strtolower($path);
                }
                Projeto::where('tema_id',$tema->id)->update([
                    'projeto' => $request->projeto,
                    'apresentacao' => $request->apresentacao,
                ]);
                AlunoTema::find($tema->temaAluno->id)->update(['defendido' =>true]);
            }else{
                if($request->hasFile('arquivo')){
                    $file = $request->file('arquivo');
                    $imageUuid = Uuid::uuid4()->toString();
                    $extension = $file->getClientOriginalExtension();
                    $path = $imageUuid.'.'.$extension;
                    $file->storeAs('projetos-pre-tcc', strtolower($path), 'public');
                    $request['projeto'] = strtolower($path);
                }
                ProjetoPreTcc::where('tema_id',$tema->id)->update([
                    'projeto' => $request->projeto,
                    'apresentacao' => $request->apresentacao,
                ]);
                $dados=Projeto::create([
                    'instituicao' => 'IF BAIANO',
                    'fk_professores_id' => $tema->temaAluno->fk_professores_id,
                    'fk_aluno_id' => $tema->temaAluno->fk_alunos_id,
                    'nome' =>$tema->nome,
                    'tema_id' => $tema->id
                ]);
                foreach ($tema->areas as $key => $value) {
                    ProjetoArea::create([
                        'fk_projeto_id' => $dados->id,
                        'fk_area_id' => $value->id
                    ]);
                }
            }
           
            DB::commit();
            return $this->linkThemeCheck($request);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json($th->getMessage(),500);
        }
        return response()->json($request->all());
               
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
