<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pansion extends Model
{
    use HasFactory;
    use SoftDeletes;


    public function city()
    {
        return $this->belongsTo(City::class,'city_id');
    }

    public function address()
    {
        return $this->hasMany(Address::class);
    }

    public function room()
    {
        return $this->hasMany(Room::class);
    }

    public function photo(){
        return $this->morphMany(Photo::class,'picable');
    }

    public function video(){
        return $this->morphMany(Video::class,'video');
    }
}
