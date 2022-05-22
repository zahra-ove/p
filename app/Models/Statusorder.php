<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statusorder extends Model
{
    use HasFactory;
    protected $table='status_orders';

    public const ACTIVE = 1;                                          // فعال
    public const CANCELLED = 2;                                   // لغو شده
    public const MOVE_TO_OTHER_TAKHT = 3;      // به تخت دیگری جا به جا شده
    public const CHANGE_TO_OTHER_TIME = 4;              // جابه جایی زمانی
    public const EKHRAJ = 5;                                 // اخراج شده
    public const KHOROUJ_ZOOD_HENGAM = 6;               // خروج زودهنگام
    public const PAYAN_YAFTE = 7;                        // پایان یافته



    //one to many
    public function order()
    {
        return $this->hasMany(Order::class);
    }

    // one to many
    public function orderarchives()
    {
        return $this->hasMany(Orderarchive::class, 'status_order_id');
    }

    // one to many
    public function statusmalichangedorders()
    {
        return $this->hasMany(Statusmalichangedorder::class, 'status_order_id');
    }

    // one to many
    public function statusmalistransactions()
    {
        return $this->hasMany(Statusmalistransaction::class, 'status_order_id');
    }

}
