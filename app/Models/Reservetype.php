<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservetype extends Model
{
    use HasFactory;
    use SoftDeletes;


    //each reservetype may have many orders
    public function order()
    {
        return $this->hasMany(Order::class);
    }

    //each reservetype may be involved in many takhts
    public function takhts()
    {
        return $this->hasMany(Takht::class);
    }
}
