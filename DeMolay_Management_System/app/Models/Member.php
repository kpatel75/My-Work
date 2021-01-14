<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Member extends Model
{
    use HasFactory;

    protected $guarded = []; 


    public function scopeSearch($query , $keyword)
    {
        $query->where('first_name', 'LIKE', '%' . $keyword . '%')
            ->orWhere('last_name', 'LIKE', '%' . $keyword . '%')
            ->orWhereRaw("concat(first_name, ' ', last_name) like '%" . $keyword . "%' ");
        return $query ;
    }

    public function jurisdiction() {
        return $this->hasOne('App\Models\Jurisdiction', 'jurisdiction_id');
    }

    public function Chapter()
    {
        return $this->belongsToMany('App\Models\Chapter');
    } 

    public function phone_number(){
        return $this->hasMany('App\Models\PhoneNumber');
    }

    public function guardian(){
        return $this->hasMany('App\Models\Guardian');
    }


    // public function position(){
    //     return $this->hasOne('App\Models\Position');
    // }

    public function position() {
        return $this->belongsTo('App\Models\Position');
    }


}
