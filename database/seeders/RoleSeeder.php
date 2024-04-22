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
