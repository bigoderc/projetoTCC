<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $super_role = new Role();
        $super_role->nome = 'admin';
        $super_role->description = 'Super Usuário';
        $super_role->save();

        $aluno_role = new Role();
        $aluno_role->nome = 'aluno';
        $aluno_role->description = 'Usuário Aluno do Sistema';
        $aluno_role->save();

        $professor_role = new Role();
        $professor_role->nome = 'professor';
        $professor_role->description = 'Usuário Professor do Sistema';
        $professor_role->save();

        // Cadastrar no banco a permission configurações
        $configuracao_all = new Permission();
        $configuracao_all->name = 'configuracoes';
        $configuracao_all->acao = 'Configurações do Sistema';
        $configuracao_all->save();
        // Cadastrar no banco a permission gasto
        $aluno_all = new Permission();
        $aluno_all->name = 'aluno';
        $aluno_all->acao = 'Cadastro Aluno';
        $aluno_all->save();
        // Cadastrar no banco a permission professor
        $professor_all = new Permission();
        $professor_all->name = 'professor';
        $professor_all->acao = 'Cadastro de professor';
        $professor_all->save();
        // Cadastrar no banco a permission tema
        $tema_all = new Permission();
        $tema_all->name = 'tema';
        $tema_all->acao = 'Cadastro de Temas';
        $tema_all->save();
        // Cadastrar no banco a permission Centro de projeto
        $projeto_all = new Permission();
        $projeto_all->name = 'projeto';
        $projeto_all->acao = 'Cadasrto de projeto';
        $projeto_all->save();
        // Cadastrar no banco a permission Usuario
        $usuario_all = new Permission();
        $usuario_all->name = 'usuario';
        $usuario_all->acao = 'Usuário';
        $usuario_all->save();
        //criando Usuario
        $user = User::where('email','admin@paper.com')->first();
        if(empty($user)){
            $super = new User();
            $super->name = 'Admin';
            $super->email = 'admin@paper.com';
            $super->password = bcrypt('secret');
            $super->save();
            $super->roles()->attach($super_role);
        }
   
    }
}
