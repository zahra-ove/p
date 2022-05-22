<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory;
    use SoftDeletes;




    protected $appends = ['naqdtype_equivalent'];


    // one to many
    public function transaction_type()
    {
        return $this->belongsTo(Transactiontype::class,'transactiontype_id');
    }


    //one to many
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    // one to many
    public function jarime()
    {
        return $this->belongsTo(Jarime::class);
    }


    // one to many
    public function order()
    {
        return $this->belongsTo(Order::class);
    }


    //one to one
    public function wallettransaction()
    {
        return $this->hasOne(Wallettransaction::class, 'id', 'id');
    }


    //one to many
    public function naqdtype()
    {
        return $this->belongsTo(Naqdtype::class, 'naqdtype_id');
    }

    //one to one
    public function usertotalstatusmali()
    {
        return $this->hasMany(Usertotalstatusmali::class);
    }

    public function qest()
    {
        return $this->belongsTo(Qest::class);
    }


    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function Usertotalstatusmalitransaction()
    {
        return $this->belongsTo(Usertotalstatusmalitransaction::class);
    }

    // one to many
    public function statusmalichangedorder()
    {
        return $this->hasMany(Statusmalichangedorder::class);
    }
//======================================= accessors =======================================//

    public function getTransactiontypeIdAttribute($value)
    {
        switch ($value) {
            case '1':
                return 'پرداخت نقد';

            case '2':
                return 'پرداخت قسط';

            case '3':
                return 'کسر از کیف پول';

            case '4':
                return 'شارژ کیف پول';

            case '5':
                return 'برداشت از کیف پول';

            case '6':
                return 'بازگشت وجه به مشتری';

            case '7':
                return 'بازگشت به کیف پول';

        }
    }


//    public function getNaqdtypeIdAttribute($value)
    public function getNaqdtypeEquivalentAttribute($value)
    {
        $naqdtype = Naqdtype::find($value);
        if(!$naqdtype)
            return '';
        return $naqdtype->title;
    }


}
