<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberActivity extends Model
{
    use HasFactory;

    protected $fillable = ['type_of_activityid', 'note', 'date', 'memberid', 'advisorid', 'no_of_hour', 'point', 'mile'];

    public function member(){
        return $this->hasOne('App\Models\Member', 'memberid');
    }

    public function advisor(){
        return $this->hasOne('App\Models\users', 'id');
    }

    public function activity(){
        return $this->belongsTo('App\Models\TypeOfActivity', 'type_of_activityid');
    }
}
