<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $arrays = [
            ['name'=>'curso','description'=>'Curso'],
            ['name'=>'turma','description'=>'Turma'],
            ['name'=>'area','description'=>'Linha de Pesquisa'],
            ['name'=>'especialidade','description'=>'Área'],
            ['name'=>'grau','description'=>'Grau'],
            ['name'=>'discente','description'=>'Discente'],
            ['name'=>'professor','description'=>'Professor'],
            ['name'=>'proposta_tema','description'=>'Proposta Tema'],
            ['name'=>'pre_tcc','description'=>'Pré TCC'],
            ['name'=>'tcc','description'=>'Tcc'],
            ['name'=>'usuario','description'=>'Usuário'],
            ['name'=>'configuracao','description'=>'Configurção']
        ];

        foreach($arrays as $key => $value){
            Permission::updateOrCreate($value);
        }
    }
}
