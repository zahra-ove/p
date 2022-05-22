<?php

namespace App\Models;

use App\Services\Permission\Traits\HasPermission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasPermission;


    public const MODIR = 1;         // مدیر
    public const PERSONEL = 2;       // پرسنل
    public const MOSHTARI = 3;        // مشتری
    public const RESERVTION = 4;         // رزروشن

    public function permission()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'group_user', 'group_id', 'user_id');
    }
}
