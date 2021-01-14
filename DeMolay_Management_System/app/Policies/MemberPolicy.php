<?php

namespace App\Policies;

use App\Models\Member;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 

class MemberPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
        if ($user()->roles->rolePermission == null) 
        {
            return true;
        }
        else
        {
            $role_id =  $user()->roles->id; 
            $permissions = DB::table('role_permissions')->where('role_id', $role_id)->first();  
            if($permissions->member_read == false)
            {
                return false;
            } 
            else
            {
                return true; 
            }
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Member  $member
     * @return mixed
     */
    public function view(User $user, Member $member)
    {
        //checks if roles has a permissions table. If not allows them to view 
        /*$permissions = DB::table('role_permissions')->where('role_id', $role_id)->first();
        if ($permissions == null) 
        {
            return true;
        }
        else
        {
            $role_id =  $user()->roles->id; 
            $permissions = DB::table('role_permissions')->where('role_id', $role_id)->first();  
            if($permissions->member_read == false)
            {
                return false;
            } 
            else
            {
                return true; 
            }
        }*/
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Member  $member
     * @return mixed
     */
    public function update(User $user, Member $member)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Member  $member
     * @return mixed
     */
    public function delete(User $user, Member $member)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Member  $member
     * @return mixed
     */
    public function restore(User $user, Member $member)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Member  $member
     * @return mixed
     */
    public function forceDelete(User $user, Member $member)
    {
        //
    }
}
