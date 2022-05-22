<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usertotalstatusmalitransaction extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = "usertotalstatusmalitransactions";


    // one to many
    public function Usertotalstatusmali()
    {
        return $this->belongsTo(Usertotalstatusmali::class);
    }


    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
