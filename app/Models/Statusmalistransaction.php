<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statusmalistransaction extends Model
{
    use HasFactory;

    protected $table = "statusmalistransactions";


    // one to many
    public function statusmali()
    {
        return $this->belongsTo(Statusmali::class);
    }

    //one to one
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'id', 'id');
    }

    //one to many
    public function statusorder()
    {
        return $this->belongsTo(Statusorder::class, 'status_order_id');
    }
}
