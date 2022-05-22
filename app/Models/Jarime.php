<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jarime extends Model
{
    use HasFactory;

    // one to many
    public function order()
    {
        return $this->belongsTo(Order::class, 'id', 'id');
    }

    // one to many
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // one to one
    public function usertotalstatusmali()
    {
        return $this->hasOne(Usertotalstatusmali::class, 'jarime_id');
    }
}
