<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurisdiction extends Model
{
    use HasFactory; 
    public $incrementing = false;

    public function country()
    {
        $this->belongsTo('App\Models\Country', 'country_id');
    } 

    public function chapter()
    {
        $this->hasMany('App\Models\Chapter', 'chapter_id');  
    }  

    public function users()
    {
        $this->hasMany('App\Models\User'); 
    }

    public function displayJurisdictions()
    {
        Jurisdiction::all(); 
    }
}
