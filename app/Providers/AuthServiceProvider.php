<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Auth\Access\Response;

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
        if (Schema::hasTable($permissoes->getTable()) ) {

            $permissoes = Permission::with('roles')->get();
            //

            //roda todas as permissoes e verifica o que o usuario pode ver
            foreach ($permissoes as $permissao) {
                //dd($permissao->roles);
                //dd(auth()->user());
                $gate->define($permissao->name, function(User $user) use ($permissao){
                    return $user->hasPermission($permissao);
                });
            }
            //antes de rodar a função ele entra nessa condição para o administrador
            $gate->before(function( User $user, $habilidade){
                /*se o usuario estiver vinculado a regra "adm" ele retorna true e consegue ver todas as permissoes*/
                if($user->hasAnyRoles('admin') ){
                    return true;
                }
            });
        }
    }
}
