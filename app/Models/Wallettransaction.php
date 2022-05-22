<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class wallettransaction extends Model
{
    use HasFactory;

    protected $table = "wallettransactions";   //table name
    public $timestamps = false;


    public function wallet()
    {
        return $this->belongsTo(Wallet::class, 'wallet_id', 'id');
    }


    public function transactins()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }
}
