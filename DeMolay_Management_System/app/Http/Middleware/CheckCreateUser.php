<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; 
use App\Http\Models\UserRole;

class CheckCreateUser
{
    /**
     * Handle an incoming request to check if a user can have access to the create user page. Queries from the 
     * create user role
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {   

        $userRoles = Auth::user()->roles; 
        $hasRole = false;
        foreach($userRoles as $role)
        {
            if( DB::table('create_users')->where('user_access_role_id', $role->id)->first() != null)
            {
                $hasRole = true;
            }
        }

        if(!$hasRole)
        {
            return redirect('home');
        }
        
        return $next($request);
    }
}
