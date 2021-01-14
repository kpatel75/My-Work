<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    use HasFactory;

    protected $fillable = ['amount', 'description', 'demolay_contribution', 'chapter_contribution', 
                            'added_by', 'edited_by_id', 'edited_by_first_name', 'edited_by_last_name'];

    public function payment() {
        return $this->hasMany('App\Model\Payment');
    }
}
