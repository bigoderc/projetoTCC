<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTemaRequest;
use App\Models\Aluno;
use App\Models\AlunoTema;
use App\Models\Area;
use App\Models\Professor;
use App\Models\Tema;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Guid\Guid;
use Ramsey\Uuid\Uuid;

class TemaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Tema $tema)
    {
        //
        Gate::authorize('read-proposta_tema');
        $areas = Area::all();
        $professores = Professor::all();
        $data = User::with('roles')->find(auth()->user()->id);

        return view('pages.temas.index', [
            'areas' => $areas,
            'professores' => $professores,
            'aluno' => $data->roles->first()->nome == 'aluno'
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
    public function store(StoreTemaRequest $request)
    {
        //
        Gate::authorize('insert-proposta_tema');
        DB::beginTransaction();
        try {
            //code...
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $imageUuid = Uuid::uuid4()->toString();
                $extension = $file->getClientOriginalExtension();
                $path = $imageUuid . '.' . $extension;
                $file->storeAs('temas', strtolower($path), 'public');
                $request['arquivo'] = strtolower($path);
            }
            $tema = Tema::create($request->all());
            $tema = Tema::with(['areas'])->find($tema->id);
            $tema->areas()->sync($request->areas);
            if ($request->professor_id) {
                $data = User::with('roles')->find(auth()->user()->id);
                $aluno = Aluno::where('fk_user_id', $data->id)->first();
                $aluno_tema = AlunoTema::where('fk_alunos_id', $aluno->id);
                if ($aluno_tema->count() > 0 && $request->professor_id) {
                    return response()->json(['data' => 'Você já tem uma proposta vinculada, desvincule o professor da proposta, por favor'], 426);
                }
                $qtd_orientandos = AlunoTema::where('fk_professores_id',$request->professor_id)->where('deferido',1)->where('defendido',false)->count();
                $professor = Professor::find($request->professor_id);
                if(($professor->disponibilidade - $qtd_orientandos) < 1){
                    return response()->json(['data' => 'Professor selecionado não possui disponibilidade.'], 426);
                }
                if ($data->roles->first()->nome == 'aluno' && $request->professor_id) {

                    AlunoTema::create(
                        [
                            'fk_alunos_id' => $aluno->id,
                            'fk_tema_id' => $tema->id,
                            'fk_professores_id' => $request->professor_id
                        ]
                    );
                }
            }


            DB::commit();
            return response()->json(Tema::with(['areas'])->find($tema->id));
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json($th->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tema  $tema
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
        Gate::authorize('read-proposta_tema');
        $user = request()->user();
        $data = User::with('roles')->find($user->id);

        if ($data) {
            $data->role = $data->roles->first();
        }
        if ($data->role->nome == 'aluno') {
            return response()->json(Tema::with(['areas', 'criado'])->where('user_id_created', $user->id)->orderBy('id', 'desc')->get());
        } else {
            return response()->json(Tema::with(['areas', 'criado'])->orderBy('id', 'desc')->get());
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tema  $tema
     * @return \Illuminate\Http\Response
     */
    public function edit(Tema $tema)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tema  $tema
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tema $tema, $id)
    {
        //
        Gate::authorize('update-proposta_tema');
        DB::beginTransaction();
        try {
            //code...
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $imageUuid = Uuid::uuid4()->toString();
                $extension = $file->getClientOriginalExtension();
                $path = $imageUuid . '.' . $extension;
                $file->storeAs('temas', strtolower($path), 'public');
                $request['arquivo'] = strtolower($path);
            }
            $tema->find($id)->update($request->all());
            $tema = Tema::find($id);

            $tema->areas()->sync($request->areas);
            DB::commit();
            return response()->json($tema->with(['areas'])->find($id));
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json($th->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tema  $tema
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Gate::authorize('delete-proposta_tema');
        Tema::find($id)->delete();
        return response()->json(['success' => true]);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Aluno  $aluno
     * @return \Illuminate\Http\Response
     */
    public function findById($id)
    {
        return response()->json(Tema::with(['areas'])->find($id));
    }
    public function toView(Tema $tema, $id)
    {
        $tema = $tema->find($id);
        $file = Storage::url("temas/" . $tema->arquivo);
        $pos = strpos($tema->arquivo, '.pdf');
        if ($pos === false) {
            echo "<img src='{$file}'/>";
        } else {
            echo "<iframe src='{$file}' width='100%' height='99%'></iframe>";
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tema  $tema
     * @return \Illuminate\Http\Response
     */
    public function upload(Tema $tema, Request $request)
    {
        //
        //dd('merda');
        if ($request->hasFile('file')) {
            $value = $request->file('file');
            $name = $request->nome . '-' . $value->getClientOriginalName();
            Storage::disk('public')->putFileAs('temas', $value, $name);
            $request['arquivo'] = $name;
        }
        $tema->find($request->id)->update($request->all());
        return response()->json(['success' => true]);
    }
}
