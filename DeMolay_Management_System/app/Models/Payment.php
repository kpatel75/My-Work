<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['amount', 'payment_date', 'member_id'];

    public function member(){
        return $this->hasOne('App\Models\Member', 'member_Id');
    }

    public function advisor(){
        return $this->hasOne('App\Models\users', 'id');
    }
}
