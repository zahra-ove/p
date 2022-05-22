<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statusmalichangedorder extends Model
{
    use HasFactory;


    // one to one
    public function order()
    {
        return $this->belongsTo(Order::class, 'id', 'id');
    }

    // one to many
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    // one to many
    public function statusorder()
    {
        return $this->belongsTo(Statusorder::class);
    }

}
