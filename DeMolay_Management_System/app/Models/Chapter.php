<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory; 
   

    public function jurisdiction()
    {
        return $this->belongsTo('App\Models\Jurisdiction', 'jurisdiction_id');
    } 

    public function members()
    {
        return $this->hasMany('App\Models\Member');
    }
}
