<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory;
    use SoftDeletes;

// edited by zizi
//    public function order()
//    {
//        return $this->belongsTo(Order::class);
//    }
    //each room may be in many orders
    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function pansion()
    {
        return $this->belongsTo(Pansion::class);
    }

    public function photo()
    {
        return $this->morphMany(Photo::class,'picable');
    }

    public function pubemkanat()
    {
        return $this->belongsToMany(Pubemkanat::class);
    }

    public function pvemkanat()
    {
        return $this->hasMany(Pvemkanat::class);
    }

    public function takht()
    {
        return $this->hasMany(Takht::class);
    }

    public function roompicks()
    {
        return $this->hasMany(Roompick::class);
    }
}
