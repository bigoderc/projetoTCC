<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class Permission05122023Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // Cadastrar no banco a permission configurações
        $configuracao_all = new Permission();
        $configuracao_all->name = 'tcc';
        $configuracao_all->acao = 'Projetos de TCC';
        $configuracao_all->save();
        // Cadastrar no banco a permission gasto
        $aluno_all = new Permission();
        $aluno_all->name = 'pre-tcc';
        $aluno_all->acao = 'Projetos de Pré-TCC';
        $aluno_all->save();
    }
}
