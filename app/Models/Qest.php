<?php

namespace App\Models;

use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Qest extends Model
{
    use HasFactory;
    use SoftDeletes;

    // one to many
    public function order()
    {
        return $this->belongsTo(Order::class);
    }


    // one to many
    // included failed and successful transactions
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

//======================================= accessors =======================================//
    public function getTarikhMoghararAttribute($value)
    {
        if(!$value)
            return '';
        $splitRaft = explode('-', $value);
        return Verta::create($splitRaft[0], $splitRaft[1], $splitRaft[2], 00, 00, 00)->formatJalaliDate();
    }


    public function getTarikhPardakhtAttribute($value)
    {
        if(!$value)
            return '';

        $splitRaft = explode('-', $value);
        return Verta::create($splitRaft[0], $splitRaft[1], $splitRaft[2], 00, 00, 00)->formatJalaliDate();
    }

    public function getStatusAttribute($value)
    {
        switch ($value) {
            case '0':
                return 'پرداخت نشده';

            case '1':
                return 'پرداخت شده';

            case '-1':
                return 'کنسل شده';
        }
    }

}
