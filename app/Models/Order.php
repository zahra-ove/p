<?php

namespace App\Models;

use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'order_id',
        'user_id',
        'raft',
        'bargasht',
        'takht_id',
    ];


    public function takht()
    {
        return $this->belongsTo(Takht::class);
    }

    public function statusOrder()
    {
        return $this->belongsTo(Statusorder::class,'status_order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function karshenas()
    {
        return $this->belongsTo(User::class,'karshenas_id');
    }

    public function reservetype()
    {
        return $this->belongsTo(Reservetype::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }


    public function photo()
    {
        return $this->morphMany(Photo::class,'picable');
    }


    //============================Financial part================================

    // one to one
    public function jarime()
    {
        return $this->hasOne(Jarime::class, 'id', 'id');
    }

    // one to one
    public function statusmali()
    {
        return $this->hasOne(Statusmali::class, 'id', 'id');
    }

    //one to many
    public function qests()
    {
        return $this->hasMany(Qest::class);
    }

    //one to  many
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // one to many
    public function orderarchives()
    {
        return $this->hasMany(Orderarchive::class);
    }

    // one to many
    public function usertotalstatusmali()
    {
        return $this->hasMany(Usertotalstatusmali::class);
    }

    // one to one
    public function statusmalichangedorder()
    {
        return $this->hasOne(Statusmalichangedorder::class, 'id', 'id');
    }


//======================================= accessors =======================================//

    public function getRaftAttribute($value)
    {
        $splitRaft = explode('-', $value);
        return Verta::create($splitRaft[0], $splitRaft[1], $splitRaft[2], 00, 00, 00)->formatJalaliDate();
    }

    public function getBargashtAttribute($value)
    {
        $splitRaft = explode('-', $value);
        return Verta::create($splitRaft[0], $splitRaft[1], $splitRaft[2], 00, 00, 00)->formatJalaliDate();
    }
}
