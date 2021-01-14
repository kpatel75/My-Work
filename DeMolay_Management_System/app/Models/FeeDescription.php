<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeDescription extends Model
{
    use HasFactory;

    protected $fillable = ['description'];

    public function fee() {
        return $this->belongsToMany('App\Models\Fee');
    }
}
