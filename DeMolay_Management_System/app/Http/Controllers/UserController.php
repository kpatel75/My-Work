<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use Illuminate\Http\Request;

use App\Models\User; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

//Validation
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class UserController extends Controller
{
    // 
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests; 


    public function displayUsers()
    {   
        $userChapterId = Auth::user()->chapter_id; 
        $userJurisdictionId = Auth::user()->chapter_id;  

        if($userJurisdictionId == 0) 
        {   
            $table = 'chapters';  
            $userrole = DB::table('role_users')->where('user_id', Auth::user()->id)->first(); 
            $createUsers = DB::table('create_users')->where('user_access_role_id', $userrole->role_id )->pluck('create_access_role_id');

            $users = DB::table('users')->join('role_users', 'users.id', '=', 'role_users.user_id')->join('roles', 'role_users.role_id', '=', 'roles.id')->join('jurisdictions', 'users.jurisdiction_id', '=', 'jurisdictions.id')->leftjoin('chapters', function($join) use ($table){
            $join->on($table.'.id', '=', 'users.chapter_id'); 
            $join->on($table.'.jurisdiction_id', '=', 'users.jurisdiction_id');
            })
            ->select('users.id as id','email', 'first_name', 'last_name', 'jurisdictions.description as jurisdiction', 'chapters.description as chapter', 'roles.role_name')
            ->whereIn('roles.id', $createUsers)
            ->get();  
            
        } 
        else if($userJurisdictionId != null && $userChapterId != null)
        {
            //$users = User::where('chapter_id', $userChapterId)->where('jurisdiction_id', $userJurisdictionId)->get();
            $table = 'chapters';
            $users = DB::table('users')->join('role_users', 'users.id', '=', 'role_users.user_id')->join('roles', 'role_users.role_id', '=', 'roles.id')->join('jurisdictions', 'users.jurisdiction_id', '=', 'jurisdictions.id')->leftjoin('chapters', function($join) use ($table){
                $join->on($table.'.id', '=', 'users.chapter_id'); 
                $join->on($table.'.jurisdiction_id', '=', 'users.jurisdiction_id');
                })
                ->select('users.id as id','email', 'first_name', 'last_name', 'jurisdictions.description as jurisdiction', 'chapters.description as chapter', 'roles.role_name')
                ->where('users.chapter_id', Auth::user()->chapter_id) 
                ->where('users.jurisdiction_id', Auth::user()->jurisdiction_id)
                ->get();  
        } 
        else
        {
            //$users = User::where('jurisdiction_id', $userJurisdictionId)->get();
            $table = 'chapters';
            $users = DB::table('users')->join('role_users', 'users.id', '=', 'role_users.user_id')->join('roles', 'role_users.role_id', '=', 'roles.id')->join('jurisdictions', 'users.jurisdiction_id', '=', 'jurisdictions.id')->leftjoin('chapters', function($join) use ($table){
                $join->on($table.'.id', '=', 'users.chapter_id'); 
                $join->on($table.'.jurisdiction_id', '=', 'users.jurisdiction_id');
                })
                ->select('users.id as id','email', 'first_name', 'last_name', 'jurisdictions.description as jurisdiction', 'chapters.description as chapter', 'roles.role_name')
                //->where('users.chapter_id', Auth::user()->chapter_id) 
                ->where('users.jurisdiction_id', Auth::user()->jurisdiction_id)
                ->get(); 
        } 
            //print($users);
        return view('users.manageusers', ['users'=>$users]);
         
    } 

    public function initManageUser($id)
    {
        $users = User::where('id', $id)->join('role_users', 'users.id', '=', 'role_users.user_id')->first();  
        //print($users);
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

         return view('users.updateuser', ['users'=>$users, 'roles'=>$availableRoles, 'jurisdiction'=>$userjurisdictions, 'successmessage'=>null]);
    } 

    public function updateUser(Request $req)
    {   
        
        if($req->first_name != null && $req->last_name != null)
        {   
            $req->validate([
            'email' => ['required', 'email'], 
            'first_name' => ['required'], 
            'last_name' => ['required']

            ]);
            $emailExists =  DB::table('users')->where('email', $req->email)->count(); 
            
            $oldEmail =  DB::table('users')->where('email', $req->email)->pluck('email');
            if($emailExists != 0 && !strcmp($req->stremail, $oldEmail))
            {
                return back()->withInput()->with('error', 'This email address is already associated with an account');
            } 

            DB::update('update users set first_name = ?, last_name = ?, email = ? where id = ?', [$req->first_name, $req->last_name, $req->email, $req->id]);
        }
        else
        {   
            $jurisdiction = $req->jurisdiction;  
            //if($req->chapter != '' && $req->chapter != null)
           // {
                $chapter = $req->chapter; 
           // } 
           // else
           // {
            //    $chapter = null; 
            //}
            $user = User::where('id', $req->id)->first();

            if($jurisdiction == null)
            {
                $jurisdiction = $user->jurisdiction_id;
            } 
            
            /*if($req->chapter == null)
            {
                $chapter = $user->chapter_id;
            } */
            
            //$jurisdiction = null;
            try{ 
                DB::beginTransaction();  

                /*if($jurisdiction != $user->jurisdiction_id || $chapter == null)
                {
                    //DB::update('update users set jurisdiction_id = ?, chapter_id = ? where id = ?', [null, null, $req->id]);  
                   // DB::statement('ALTER TABLE users DROP CONSTRAINT users_chapter_id_jurisdiction_id_foreign;');
                   DB::statement('ALTER TABLE users DISABLE KEYS'); 
                    //print('if'); 
                    //return back()->with('error', 'IF Statement');

                    DB::update('update users set jurisdiction_id = ?, chapter_id = ? where id = ?', [$jurisdiction, $chapter, $req->id]); 
                    DB::update('update role_users set role_id = ? where user_id = ?', [$req->roles, $req->id]);

                    $userLog = User::where('id', $req->id)->first();
                    LogActivity::log('Update', "Update user $userLog->first_name $userLog->last_name with id: $req->id");

                    //DB::statement("ALTER TABLE users ADD CONSTRAINT users_chapter_id_jurisdiction_id_foreign FOREIGN KEY ('chapter_id', 'jurisdiction_id') REFERENCES chapters('id', 'jurisdiction_id');");
                    DB::statement('ALTER TABLE users ENABLE KEYS'); 
                }
                else{*/
                DB::update('update users set jurisdiction_id = ?, chapter_id = ? where id = ?', [$jurisdiction, $chapter, $req->id]); 
                DB::update('update role_users set role_id = ? where user_id = ?', [$req->roles, $req->id]); 

                $userLog = User::where('id', $req->id)->first();
                LogActivity::log('Update', "Update user $userLog->first_name $userLog->last_name with id: $req->id"); 
               // }
            } catch(Exception $e) 
            {
                DB::rollback();
                return redirect()->back()->withInput()->with('error', $e->getMessage());
            } 
        } 
        DB::commit();
        // DB::update('update chapters set description = ?, location = ? where id = ? and jurisdiction_id = ?', [$req->description, $req->location, $req->id, $req->jurisdiction]); 
        if(Auth::user()->id != $req->id)
        {
            return redirect('manageusers')->with('success', 'User successfully updated');
        } 
        else
        {
            return back()->with('success', 'User successfully updated');
        }
    } 

    public function deleteUser($id)
    {   
        DB::beginTransaction();
        try{ 
            $user = DB::table('users')->where('id', $id)->first();
            DB::table('role_users')->where('user_id', $id)->delete(); 
         DB::table('users')->where('id', $id)->delete();  
         LogActivity::log('Delete', "Delete user $user->first_name $user->last_name");
        } 
        catch(Exception $e) 
        {
            DB::rollback();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        } 
        DB::commit();
        return redirect('manageusers');
    } 

   
}
