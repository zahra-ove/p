<?php

namespace App\Models;

use App\Models\Paytype;
use App\Models\Statusmalistransaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Statusmali extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $incrementing = false;


    protected $fillable = [
        'id',
        'status_order_id',
        'order_total_price_before_takhfif',
        'takhfif',
        'order_finally_price',
        'total_wallet_amount_paid',
        'total_dargah_amount_paid',
        'total_naghdi_amount_paid',
        'total_qest_amount_paid',
        'maande_amount',
        'financial_status',
    ];


    // one to one relationship
    public function order()
    {
        return $this->belongsTo(Order::class, 'id', 'id');
    }


    // one to many
    public function statusmalitransaction()
    {
        return $this->hasMany(Statusmalistransaction::class);
    }

    // many to many
    public function paytypes()
    {
        return $this->belongsToMany(Paytype::class, 'statusmali_paytype', 'statusmali_id', 'paytype_id');
    }


//======================================= accessors =======================================//

    public function getFinancialStatusAttribute($value)
    {
        switch ($value) {
            case 'paid':
                return 'تسویه شده';

            case 'notpaid':
                return 'تسویه نشده';

            case 'partialpaid':
                return 'بخش تسویه شده';

            case 'vajh_returned':
                return 'وجه بازگشت داده شده';

            case 'vajh_returned_jarime':
                return 'وجه بازگشت داده شد و جریمه دریافت شده';
        }
    }



}
