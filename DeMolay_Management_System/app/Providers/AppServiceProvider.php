<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\Response;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        //
        Paginator::useBootstrap(); 
        //$this->registerPolicies();  

        //Gate::define
        Blade::if('ITAdmin', function(String $level, String $permission) {
           //$userPermission = DB::table('role_permissions')->where('role_id', Auth::user()->roles[0]->id)->first(); 
           // print($userPermission);  
           $role = 1;//Auth::user()->roles[0]->role_permissions_id; 
        //print($role);
            $userPermission = DB::table('role_permissions')->where('id', $role)->first(); 
        //$userPermission = Auth::user()->roles[0]->role_permission_id; 
        // print($userPermission->member_read);
            $isAuth = false;  

            if(Auth::user()->roles[0]->id == 2)
            {
                switch($level)
                {
                    case 'member': 
                        if($permission == 'readwrite' && $userPermission->member_read == true && $userPermission->member_write == true)
                        {
                            $isAuth = true; 
                        } 
                        else if($permission == 'write' && $userPermission->member_write == true)
                        {
                            $isAuth = true; 
                        }
                        else if($permission == 'read' && $userPermission->member_read == true)
                        {
                            $isAuth = true; 
                        } 
                    break; 
                    case 'jurisdiction': 
                        if($permission == 'readwrite' && $userPermission->jurisdiction_read == true && $userPermission->jurisdiction_write == true)
                        {
                            $isAuth = true; 
                        } 
                        else if($permission == 'write' && $userPermission->jurisdiction_write == true)
                        {
                            $isAuth = true; 
                        }
                        else if($permission == 'read' && $userPermission->jurisdiction_read == true)
                        {
                            $isAuth = true; 
                        } 
                    break; 
                    
                    case 'country': 
                        if($permission == 'readwrite' && $userPermission->country_read == true && $userPermission->country_write == true)
                        {
                            $isAuth = true; 
                        } 
                        else if($permission == 'write' && $userPermission->country_write == true)
                        {
                            $isAuth = true; 
                        }
                        else if($permission == 'read' && $userPermission->country_read == true)
                        {
                            $isAuth = true; 
                        } 
                    break; 

                } 
            /*if($isAuth)
            {
               return Response::allow();
            }
            else
            {
               return Response::deny('IT admin is not authorized for this action');
            }*/
           
            } 
            else
            {
                $isAuth = true; 
            }
            return $isAuth; 
        });

    }
}
