<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use App\Models\RolePermission; 

class AdminController extends Controller
{
    // initialized manageitadmin page
    public function index()
    {   
        $itRole = DB::table('roles')->where('role_name', 'IT Admin')->first(); 
        $permissions = DB::table('role_permissions')
                        ->where('id', $itRole->role_permissions_id)
                        ->first();
        
        return view('admin.manageitadmin', ['permissions' => $permissions]);
    } 

    //recievies request from manageitadmin page
    public function updateItAdmin(Request $req)
    {
        $itRole = DB::table('roles')->where('role_name', 'IT Admin')->first(); 
        $permissions = RolePermission::where('id', $itRole->role_permissions_id)
                        ->first() 
                        ->get();  
        $id = RolePermission::where('id', $itRole->role_permissions_id)
        
        ->pluck('id')
        ->first();
        //->get(); 

        //sets user permissions based on response for member
        if($req->member == 'read')
        {
            $permissions->member_read = true; 
            $permissions->member_write = false; 
        }
        else if ($req->member == 'write')
        {
            $permissions->member_read = false; 
            $permissions->member_write = true; 
        }
        else if ($req->member == 'readwrite')
        {
            $permissions->member_read = true; 
            $permissions->member_write = true; 
        } 
        else
        {
            $permissions->member_read = false; 
            $permissions->member_write = false; 
        } 
        //sets user permissions based on response for jurisdiction  
        if($req->jurisdiction == 'read')
        {
            $permissions->jurisdiction_read = true; 
            $permissions->jurisdiction_write = false; 
        }
        else if ($req->jurisdiction == 'write')
        {
            $permissions->jurisdiction_read = false; 
            $permissions->jurisdiction_write = true; 
        }
        else if ($req->jurisdiction == 'readwrite')
        {
            $permissions->jurisdiction_read = true; 
            $permissions->jurisdiction_write = true; 
        } 
        else
        {
            $permissions->jurisdiction_read = false; 
            $permissions->jurisdiction_write = false; 
        }  
        //sets users permissions based on resposne for country
        if($req->country == 'read')
        {
            $permissions->country_read = true; 
            $permissions->country_write = false; 
        }
        else if ($req->country == 'write')
        {
            $permissions->country_read = false; 
            $permissions->country_write = true; 
        }
        else if ($req->country == 'readwrite')
        {
            $permissions->country_read = true; 
            $permissions->country_write = true; 
        } 
        else
        {
            $permissions->country_read = false; 
            $permissions->country_write = false; 
        }  

        

        DB::update('update role_permissions set member_read = ?, member_write = ?, jurisdiction_read = ?, jurisdiction_write = ?, country_read = ?, country_write = ? where id = ?', [ $permissions->member_read, $permissions->member_write, $permissions->jurisdiction_read, $permissions->jurisdiction_write, $permissions->country_read, $permissions->country_write, $id]);  

        LogActivity::log('Update', 'Updated IT Admin user permissions');

        return redirect()->back()->with('success', 'IT Admin setting updated successfully.');
    }
    
}
