<?php

namespace App\Providers;

use App\Models\Role;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->registerMemberPolicies(); 
        $this->registerUserPolicies();  
        $this->registerGeneralAccess();


        //
    }

    public function registerMemberPolicies()
    {
        Gate::define('create-member', function($user){
           if($user->hasRole('chapter')||$user->hasRole('secretary'))
           {
                return true;
           }  
           return false; 
        });
    } 

    public function registerUserPolicies()
    {
        Gate::define('create-user', function($user)
        {
            if(!$user->hasRole('chapter'))
           {
                return true;
           }  
           return false; 
        });
    } 

    public function registerGeneralAccess()
    {
        Gate::define('accessRole', function($user, array $roles){
            $authenticate = false; 

            foreach($roles as $role)
            {
                if($user->hasRole($role))
                {
                    $authenticate = true; 
                }
            } 
            return $authenticate; 
        });
    }
}
