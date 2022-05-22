<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderarchive extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'status_order_id'];

    // one to many
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function statusorder()
    {
        return $this->belongsTo(Statusorder::class, 'status_order_id');
    }



    //================= Mutators
    public function setUpdatedAt($value)
    {
        // Do nothing for disabling updated_at column for this model
    }
}
