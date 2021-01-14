<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory; 

    public function Province()
    {
        return $this->hasMany('App\Models\Jurisdiction', 'jusrisdiction_id');
    }
}
