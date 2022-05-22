<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fullday extends Model
{
    use HasFactory;

    public function reservetime()
    {
        return $this->belongsTo(Reservetime::class);
    }
}
