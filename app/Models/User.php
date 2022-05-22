<?php

namespace App\Models;

use App\Services\Permission\Traits\HasGroup;
use App\Services\Permission\Traits\HasPermission;
use App\Services\Permission\Traits\HasUser;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
//    use HasApiTokens, HasFactory, Notifiable, SoftDeletes,HasGroup;
    use HasFactory, Notifiable, SoftDeletes,HasGroup;
    use HasUser,HasPermission;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'family',
        'ncode',
        'mobilecode',
        'city_id',
        'birthday',
        'password',
        'gender',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    public function photo()
    {
        return $this->morphMany(Photo::class,'picable');
    }

    public function address()
    {
        return $this->hasMany(Address::class);
    }

    public function group()
    {
//        return $this->belongsToMany(Group::class)->withPivot('group_id');
        return $this->belongsToMany(Group::class, 'group_user', 'user_id', 'group_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }




//================

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    // many to many
    public function ncodetype()
    {
        return $this->belongsToMany(Ncodetype::class,'shenasayis', 'user_id', 'ncodetype_id')->withPivot(['path','title']);
    }

    public function permission()
    {
        return $this->belongsToMany(Permission::class,'permission_user');
    }

    public function mobile()
    {
        return $this->hasMany(Mobile::class);
    }


    //added by zizi

    // each user may have many transactions
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }


    // one to one
    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'id', 'id');
    }


    // one to one
    public function usertotalstatusmali()
    {
        return $this->hasOne(Usertotalstatusmali::class);
    }
}
