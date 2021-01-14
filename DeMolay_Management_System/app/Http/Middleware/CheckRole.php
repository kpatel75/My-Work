<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; 
use App\Models\UserRole;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */ 
    
    //checks if a user has a specific role
    public function handle(Request $request, Closure $next, $role)
    {   
        $isAuth = false; 
        //print($request->user()->hasRole($role));  

        $roles = explode('|', $role); 
        array_push($roles, 'Admin', 'IT Admin'); 


        foreach($roles as $item)
        {
            if($request->user()->hasRole($item) == 1)
            {   
               $isAuth = true;
              // print($item);
            }  
        }

        if(!$isAuth)
        {
            return redirect('home');
        }
        return $next($request);
       
    }
}
