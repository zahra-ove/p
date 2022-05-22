<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usertotalstatusmali extends Model
{
    use HasFactory;

    protected $table = "usertotalstatusmalis";
    public $timestamps = false;

    //one to one
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    // one to many
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // one to many
    public function transactiontype()
    {
        return $this->belongsTo(Transactiontype::class, 'transactiontype_id');
    }

    // one to many
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // one to many
    public function jarime()
    {
        return $this->belongsTo(Jarime::class, 'jarime_id');
    }


    // one to many
    public function Usertotalstatusmalitransactions()
    {
        return $this->hasMany(Usertotalstatusmalitransaction::class);
    }
}
