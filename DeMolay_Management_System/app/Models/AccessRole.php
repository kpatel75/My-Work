<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessRole extends Model
{
    use HasFactory;  
    protected $table = 'access_roles';

    public function userrole()
    {
        return $this->belongsToMany('App\Models\Role');
    }
}
