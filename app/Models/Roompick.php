<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Roompick extends Model
{
    use HasFactory;
    use SoftDeletes;


    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
