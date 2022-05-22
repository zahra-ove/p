<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Takht extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function reservetype()
    {
        return $this->belongsTo(Reservetype::class);
    }

    public function photo()
    {
        return $this->morphMany(Photo::class,'picable');
    }


}
