<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Boolean;
use SebastianBergmann\ObjectEnumerator\Enumerator;
use Symfony\Component\VarDumper\Caster\EnumStub;

class CheckItAdminPermission
{   
    /**
     * Handle an incoming request and checks if an it admin can access a certain page based on table: role_permissions.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    //check IT Admin current user permissions
    public function handle(Request $request, Closure $next, $permissionLevel, $readWrite)
    {   
         $isAuth = false; 
         $role = $request->user()->roles[0]->id; 
        if($role == 2)
        {
            $permissions = DB::table('role_permissions')->first();  
           // $permissions = $request->user()->roles->role_permissions;
            if($permissionLevel == 'member')
            {
                if($readWrite == 'readwrite' && $permissions->member_read == true && $permissions->member_write == true)
                {
                    $isAuth = true;  
                  ;
                } 
                else if ($readWrite == 'write' && $permissions->member_write == true)
                {
                    $isAuth = true; 
                   
                } 
                else if($readWrite == 'read' && $permissions->member_read == true)
                {
                    $isAuth = true; 
                  
                } 
                else
                {
                    $isAuth = false; 
                }
            }

        } 
        else
        {
            $isAuth = true;  
         
        } 
       // print($isAuth);
        if(!$isAuth)
        {
            return redirect('home');
        }

         //$userPermission = DB::table('role_permissions')->where('role_id', Auth::user()->roles[0]->id)->first(); 
           // print($userPermission);  
          /* $role = Auth::user()->roles[0]->role_permissions_id; 
        //print($role);
            $userPermission = DB::table('role_permissions')->where('id', $role)->first();  
            print($userPermission->member_read); 
            print($permissionLevel);
        //$userPermission = Auth::user()->roles[0]->role_permission_id; 
        // print($userPermission->member_read);
            $isAuth = false; 
            switch(strval($permissionLevel))
            {
                case 'member': 
                    if($permission == 'readwrite' && $userPermission->member_read == true && $userPermission->member_write == true)
                    {
                        $isAuth = true;  
                        print('both');
                    } 
                    else if($permission = 'write' && $userPermission->member_write == true)
                    {
                        $isAuth = true;  
                        print('write');
                    }
                    else if($permission = 'read' && $userPermission->member_read == true)
                    {
                        $isAuth = true;  
                        print('read');
                    } 
                break; 
                case 'jurisdiction': 
                    if($permission = 'readwrite' && $userPermission->jurisdiction_read == true && $userPermission->jurisdiction_write == true)
                    {
                        $isAuth = true; 
                    } 
                    else if($permission = 'write' && $userPermission->jurisdiction_write == true)
                    {
                        $isAuth = true; 
                    }
                    else if($permission = 'read' && $userPermission->jurisdiction_read == true)
                    {
                        $isAuth = true; 
                    } 
                break; 
                
                case 'country': 
                    if($permission = 'readwrite' && $userPermission->country_read == true && $userPermission->country_write == true)
                    {
                        $isAuth = true; 
                    } 
                    else if($permission = 'write' && $userPermission->country_write == true)
                    {
                        $isAuth = true; 
                    }
                    else if($permission = 'read' && $userPermission->country_read == true)
                    {
                        $isAuth = true; 
                    } 
                break; 

            } 
            if(!$isAuth)
            {
               return redirect('home');
            }
            /*else
            {
               return Response::deny('IT admin is not authorized for this action');
            }*/
            //return $isAuth;
        return $next($request);
    } 

} 

class PermissionLevel 
{
    const Member = 'member'; 
    const Jurisdiction = 'jurisdiction'; 
    const Country = 'country'; 
} 

abstract class AccessLevel
{
    const Read = 'read'; 
    const Write = 'write';  
    const both = 'readwrite';
}


