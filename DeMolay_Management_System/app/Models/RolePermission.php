<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory; 

    
    public function role()
    {
        return $this->belongsTo('App\Model\Role'); 
    }
}
