<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use SoftDeletes;
    use HasFactory;

    public function ostan()
    {
        return $this->belongsTo(Ostan::class);
    }

    public function pansion()
    {
        return $this->hasMany(Pansion::class);
    }

    public function photo()
    {
      return $this->morphMany(Photo::class,"picable");
    }


    // added by zizi

    //one city may have many pansions
    public function pansions()
    {
        return $this->hasMany(Pansion::class);
    }

    public function roompicks()
    {
        return $this->hasMany(Roompick::class);
    }
}
