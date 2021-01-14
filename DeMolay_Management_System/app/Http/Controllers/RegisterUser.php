<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\Models\Jurisdiction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use App\Models\User;
use App\Models\UserRole;
use App\Models\Role;
use App\Models\Chapter;
use Exception;
use Illuminate\Support\Carbon;
//Validation
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class RegisterUser extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests; 

    //initalize the add user registration page
    public function getRegisterRoles()
    {
        //get auth user role
        $roleId = $roles = Auth::User()->roles->min('id'); 
        
        //find roles user can create for create_users table
        $availableRoles = DB::table('roles') 
                            ->join('create_users', 'roles.id', '=', 'create_users.create_access_role_id')
                            ->where('user_access_role_id', $roleId)->get();   
        
        $userJurisdiction = Auth::user()->jurisdiction_id;  
         //users that do not have a juridiction of 0 can only create roles in their jurisdiction 
        if($userJurisdiction == 0)
        {
            $userjurisdictions = DB::table('jurisdictions')->get();
        } 
        else
        {
            $userjurisdictions = DB::table('jurisdictions')->where('id', $userJurisdiction)->get();
        } 
       
        //return webpage
    return view('registeruser', ['roles'=>$availableRoles, 'jurisdiction'=>$userjurisdictions, 'successmessage'=>null]);  

    }   

    //This function adds new user to database and assign roles
    public function registerUser(Request $req)
    {       
        //validate inputs
         $req->validate([
            'email' => ['required', 'email'], 
            'first_name' => ['required'], 
            'last_name' => ['required'], 
            'password' => ['required', 'min:8', 'confirmed'] 

        ]); 
        //determines if email is already inuse
        $emailExists =  DB::table('users')->where('email', $req->email)->count(); 
        if($emailExists != 0)
        {
            return back()->withInput()->with('error', 'This email address is already associated with an account');
        }
        
        $executiveOfficerID = Role::Where('role_name', 'Executive Officer')->pluck('id')->first(); 
        DB::beginTransaction();

        try
        {   
            //initialize new user and populate with data
            $user = new User();  
            $user->first_Name = $req->first_name; 
            $user->last_Name = $req->last_name; 
            $user->email = $req->email;
            $user->password = bcrypt($req->password);  
            $user->created_at = Carbon::now(); 
            $user->updated_at = null;  

            if($req->jurisdiction == null)
            {
                $user->jurisdiction_id = Auth::User()->jurisdiction_id;
            }
            else
            {
                $user->jurisdiction_id = $req->jurisdiction;
            }  

            //return error if user has role that must be assigned to chapter
            if($req->roles > $executiveOfficerID && $req->chapter==null)
            {

                return back()->withInput()->with('error', 'A user with a role of chapter chairman or chapter advisor must have a chapter assigned to them');
            } 
            $user->chapter_id = $req->chapter; 

            $user->save(); 

            $insertedUser = DB::table('users')->where('email', $req->email)->first();

            $userrole = new UserRole(); 
            $userrole->role_id = $req->roles; 
            $userrole->user_id = $insertedUser->id;  
            $userrole->save();

            DB::commit(); 
            //query information for loggin purposes
            $rolename = Role::where('id', $req->roles)->pluck('role_name')->first(); 
            $jurisdiction = Jurisdiction::where('id', $user->jurisdiction_id)->pluck('description')->first(); 
            $logmessage = "Create user: $user->first_Name $user->last_Name with role: $rolename on Jurisdiction: $jurisdiction";
            
            if($req->chapter != null)
            {
               // $chapter = Chapter::where('id', $req->chapter)->where('jurisdiction_id', $req->jurisduction)->pluck('description')->first();
               // $logmessage = $logmessage + "and Chapter: $chapter";
            }
            //logs creation of user
            LogActivity::log('Create', $logmessage); 
            } 
        catch(Exception $e) 
        {
            DB::rollback();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        } 
        //return success message
        return redirect()->back()->with('success', 'User Successfully Added.');

    }
}
