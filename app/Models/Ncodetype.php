<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ncodetype extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsToMany(User::class,'shenasayis', 'user_id', 'ncodetype_id')->withPivot(['path','title']);
    }

}
