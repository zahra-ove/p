<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transactiontype extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table='transaction_types';

    public const PARDAKHT_NAGHD = 1;     // پرداخت نقد توسط مشتری
    public const PARDAKHT_QEST = 2;      // پرداخت قسط توسط مشتری
    public const JARIME_WALLET = 3;      // کسر جریمه از کیف پول
    public const SHARJ_WALLET = 4;       // شارژ کیف پول
    public const BARDASHT_WALLET_FOR_RESERVE = 5;     // برداشت از کیف پول بابت هزینه رزرو
    public const BAZGASHT_VAJH_BE_CUSTOMER = 6;      // بازگشت وجه به مشتری
    public const BAZGASHT_TO_WALLET = 7;        // بازگشت به کیف پول بابت مانده حساب مشتری
    public const DARGAH = 8;           // درگاه پرداخت
    public const DARYAFTE_JARIME_AZ_CUSTOMER = 9;       // دریافت جریمه از مشتری


    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }

    public function usertotaltransactions()
    {
        return $this->hasMany(Usertotalstatusmali::class, 'transactiontype_id');
    }
}
