<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Naqdtype extends Model
{
    use HasFactory;

    public const CARD_TO_CARD = 1;              // کارت به کارت
    public const NAGHDI = 2;            // پرداخت به صورت نقدی
    public const HAVALE_BANK = 3;                //حواله بانک
    public const DARGAH_PARDAKHT = 4;        // درگاه پرداخت
    public const POSE = 5;                     // دستگاه پوز
    public const BONE_KHARID = 6;               // بن خرید

    //one to many
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'naqdtype_id');
    }
}
