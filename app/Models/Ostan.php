<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ostan extends Model
{
    use HasFactory;
    use SoftDeletes;


    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
