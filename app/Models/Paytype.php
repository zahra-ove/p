<?php

namespace App\Models;

use App\Models\Statusmali;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Paytype extends Model
{
    use HasFactory;

    protected $table = "paytypes";

    protected $fillable = [
        'title',
    ];


    public const NAQD = 1;                                     // نقد
    public const QEST = 2;                                   // اقساط
    public const WALLET = 3;                              // کیف پول
    public const DARGAH_PARDAKHT = 4;               // درگاه پرداخت


    // many to many
    public function statusmalis()
    {
        return $this->belongsToMany(Statusmali::class, 'statusmali_paytype', 'paytype_id', 'statusmali_id');
    }
}
