<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreateUser extends Model
{
    use HasFactory;
    public function roles()
    {
        return $this->belongsTo('App\Models\Role', 'id', 'create_role_id'); 
    }  

}
