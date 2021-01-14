<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ResetPassword;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    //defined many-to-many relationship with roles
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'role_users');
    } 
    //checks to see if user has a given role
    public function hasRole($role)
    {
        $roles = $this->roles()->where('role_name', $role)->count();  
      // $roles = User::where('role', $role)->get();
        if($roles == 1)
        {
            return true;
        }

        return false; 
    }  

    public function jurisdiction()
    {
        return $this->belongsTo('App\Models\Jurisdiction', 'jurisdiction_id');
    }  

    public function chapter()
    {
        return $this->belongsTo('App\Models\Chapter', 'chapter_id');
    }

    //used in app.blade.php
    //will return true if user can create user accounts for other members
    public function canCreateUser()
    {
       /* $roles = DB::table('create_users')->where('user_access_role_id', Auth::User()->id)->first(); 
        if($roles != null)
        {
            return true;
        } 
        return false; */ 

        $userRoles = Auth::user()->roles; 
        $hasRole = false;
        foreach($userRoles as $role)
        {
            if( DB::table('create_users')->where('user_access_role_id', $role->id)->first() != null)
            {
                $hasRole = true;
            }
        }

       return $hasRole;
    }    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Override sendPasswordResetNotification
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

}
