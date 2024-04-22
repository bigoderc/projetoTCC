<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        
        $this->registerPolicies($gate);
        $permissoes = new Permission();
        if (Schema::hasTable((new Permission())->getTable())) {
            
            $gate->before(function( User $user, $habilidade){
               
                /*se o usuario estiver vinculado a regra "adm" ele retorna true e consegue ver todas as permissoes*/
                if($user->hasAnyRoles('admin') ){
                    return true;
                }
            });
            $gate->before(function (User $user) {
                // Obter as permissões com base no papel do usuário
                $permissoes = Permission::has('permissionRole')->with(['permissionRole' => function ($query) use ($user) {
                    $query->where('fk_roles_id', $user->roles[0]->id);
                }, 'roles'])->get();
            
                // Agora você pode iterar sobre as permissões aqui ou fazer outras operações necessárias
                foreach ($permissoes as $permissao) {
                    if (!empty($permissao->permissionRole)) {
                        foreach ($permissao->permissionRole as $permission_find) {
                            $permisssion = mb_strtolower($permissao->name, 'UTF-8');
                            $acao = mb_strtolower($permission_find->acao, 'UTF-8');
                            $regra = $acao.'-'.$permisssion;
                            
                            Gate::define($regra, function (User $user) use (&$permissao) {
                                return $user->hasPermission($permissao);
                            });
                        }
                    }
                }

            });
           
            // foreach ($permissoes as $permissao) {
            //     if (!empty($permissao->permissionRole)) {
            //         foreach ($permissao->permissionRole as $permission_find) {
            //             $permisssion = mb_strtolower($permissao->name, 'UTF-8');
            //             $acao = mb_strtolower($permission_find->acao, 'UTF-8');
            //             $regra = $acao.'-'.$permisssion;
                        
            //             $gate->define($regra, function (User $user) use (&$permissao) {
            //                 return $user->hasPermission($permissao);
            //             });
            //         }
            //     }
            // }
            //antes de rodar a função ele entra nessa condição para o administrador
           
        }
    }
}
