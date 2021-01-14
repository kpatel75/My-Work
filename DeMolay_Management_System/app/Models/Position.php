<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{

    use HasFactory;

    // public function member() {
    //     return $this->hasMany('App\Models\Member', 'member_id');
    // }

    public function member() {
        return $this->hasMany('App\Models\Member');
    }


}
