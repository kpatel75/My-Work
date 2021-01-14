<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    //defines a many to many relationship for roles to a user
    public function users()
    {
        return $this->belongsToMany('App\Models\User'); 
    } 

    public function accessRole()
    {
        return $this->hasOne('App\Models\AccessRole');
    }

    public function createUser()
    {
        return $this->hasMany(CreateUser::class, 'create_role_id', 'id'); 
    }  

    public function rolePermission()
    {
        return $this->hasOne('App\Models\RolePermission', 'id', 'role_permissions_id');
    }
}
