<?php


namespace App\Services\Admin\User;


use App\Exceptions\UserNotSavedException;
use App\Models\Address;
use App\Models\Group;
use App\Models\Mobile;
use App\Models\Ncodetype;
use App\Models\Order;
use App\Models\Photo;
use App\Models\Qest;
use App\Models\User;
use App\Models\Usertotalstatusmali;
use App\Models\Wallet;
use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;


class UserService
{

    public function registers (Array $data)
    {
        $birthdayExplod = explode('/',$data['birthday']);
        $birth=Verta::createJalali($birthdayExplod[0],$birthdayExplod[1],$birthdayExplod[2])->formatGregorian('Y-m-d');
        $user= new User();
        $user->name=$data['name'];
        $user->family=$data['family'];
        $user->mobilecode=$data['mobilecode'];
        $user->gender=$data['gender'];
        $user->ncode=$data['ncode'];
        $user->email=$data['email'];
        $user->birthday=$birth;
        $user->password=Hash::make($data['password']);
        $user->city_id=$data['city_id'];
        $user->registertype_id=2;



        DB::beginTransaction();
        if ($user->save()) {


            // create a wallet for newly created user
            $wallet = new Wallet();
            $wallet->id = $user->id;
            $wallet->mojoodi = 0;
            $wallet->save();
            $user->group()->attach(3);

            // create a usertotalstatusmali record for this newly created user
            $usertotalstatusmali = new Usertotalstatusmali();
            $usertotalstatusmali->id = $user->id;
            $usertotalstatusmali->total_wallet_used_amount = 0;
            $usertotalstatusmali->total_wallet_mojoodi = 0;
            $usertotalstatusmali->total_user_bedehi = 0;
            $usertotalstatusmali->total_user_pardakhti = 0;
            $usertotalstatusmali->total_jarime_bedehkar = 0;
            $usertotalstatusmali->total_jarime_pardakhti = 0;
            $usertotalstatusmali->total_returned_amount_to_customer = 0;
            $usertotalstatusmali->save();

            DB::commit();
            return $user;
        }
        else {
            DB::rollBack();
            throw new UserNotSavedException('user not saved in database!');
        }


    }

    public function getAllproviders()
    {
        $user = DB::table('users as u')->select(['u.id', 'u.business_title', 'u.name', 'u.family', 'u.provider_contract_enddate as enddate', 'provider_contract_startdate as startdate', 'u.provider_contract_number as contractNumber'])
            ->whereNull('u.deleted_at')
            ->get();
        return count($user) > 0 ? $user : "notfound";
    }


    public function deleteUserById($id)
    {
        $user=User::find($id);
        if ($user->delete()){
            $user->group()->detach();
            return 'ok';
        }
        else{
            return 'notfound';
        }

    }



    public function insertPersonal($name, $family, $birthday, $ncode, $gender, $phone, $mobilecode, $email, $city_id, $cardnumber, $file,$addressTitle,$addr,$ncodetype,$mobiles)
    {

        $user = new User();
        $user->name = $name;
        $user->family = $family;
        $user->birthday = $birthday;
        $user->ncode = $ncode;
        $user->gender = $gender;
        $user->password=Hash::make($ncode);
        $user->phone = $phone;
        $user->mobilecode = $mobilecode;
        $user->email = $email;
        $user->city_id = $city_id;
        $user->cardnumber = $cardnumber;
        $user->registertype_id = 1;
        $userNcodeExist=User::where('ncode',$ncode)->exists();

        if ($userNcodeExist){

            return 'ncodeExist';
        }
        $userMobileCodeExist=User::where('mobilecode',$mobilecode)->exists();

        if ($userMobileCodeExist){

            return 'mobileExist';
        }


        DB::beginTransaction();
        if ($user->save()) {
            if ($mobiles!=null) {
                for ($i = 0; $i < count($mobiles); $i++) {
                    $mobile = new Mobile();
                    $mobile->number = $mobiles[$i];
                    $mobile->user_id = $user->id;
                    $mobile->save();
                }
            }
            $address= new Address();
            $address->title=$addressTitle;
            $address->addr=$addr;
            $address->user_id=$user->id;
            $address->save();
            $user->group()->attach(2);
            if ($file != null) {
                for($i=0;$i<count($file);$i++){
                    $ntype=Ncodetype::find($ncodetype[$i]);
                    $filename=$file[$i]->getClientOriginalName();
                    $path = 'storage/images/ncode/'.$filename;
                    $user->ncodetype()->attach($ncodetype[$i],['path'=>$path]);
                    $file[$i]->storeAs('public/images/ncode/', $filename);
                }
            }
            DB::commit();
            return "ok";
        } else {
            DB::rollback();
            DB::rollback();
            return "notfound";
        }
    }

    public function insertCustomer($name, $family, $birthday, $ncode, $gender, $phone, $mobilecode, $email, $city_id, $cardnumber, $file,$addressTitle,$addr,$ncodetype,$mobiles)
    {

        $user = new User();
        $user->name = $name;
        $user->family = $family;
        $user->birthday = $birthday;
        $user->ncode = $ncode;
        $user->gender = $gender;
        $user->phone = $phone;
        $user->password=Hash::make($ncode);
        $user->mobilecode = $mobilecode;
        $user->email = $email;
        $user->city_id = $city_id;
        $user->cardnumber = $cardnumber;
        $user->registertype_id = 1;


        DB::beginTransaction();
        if ($user->save()) {
            if ($mobiles!=null) {
                for ($i = 0; $i < count($mobiles); $i++) {
                    $mobile = new Mobile();
                    $mobile->number = $mobiles[$i];
                    $mobile->user_id = $user->id;
                    $mobile->save();
                }
            }
            $address= new Address();
            $address->title=$addressTitle;
            $address->addr=$addr;
            $address->user_id=$user->id;
            $address->save();
            $user->group()->attach(3);
            $wallet=new Wallet();
            $wallet->bedehkar=0;
            $wallet->user_id=$user->id;
            $wallet->save();
            if ($file != null) {
                for($i=0;$i<count($file);$i++){
                    $ntype=Ncodetype::find($ncodetype[$i]);
                    $filename=$file[$i]->getClientOriginalName();
                    $path = 'storage/images/ncode/' .$filename;
                    $user->ncodetype()->attach($ncodetype[$i],['path'=>$path]);
                    $file[$i]->storeAs('public/images/ncode/', $filename);
                }
            }
            DB::commit();
            return "ok";
        } else {
            DB::rollback();
            DB::rollback();
            return "notfound";
        }
    }
    public function editPersonal($id, $name, $family, $birthday, $ncode, $gender, $phone, $mobilecode, $email, $city_id, $cardnumber, $password, $file,$addressTitle,$addr,$ncodetype)
    {


        $user = User::find($id);
        $user->name = $name;
        $user->family = $family;
        $user->birthday = $birthday;
        $user->ncode = $ncode;
        $user->gender = $gender;
        $user->phone = $phone;
        $user->mobilecode = $mobilecode;
        $user->email = $email;
        $user->city_id = $city_id;
        $user->cardnumber = $cardnumber;
//        $user->password = Hash::make($password);



        DB::beginTransaction();
        if ($ncodetype!=null) {
            for ($i = 0; $i < count($ncodetype); $i++) {
                foreach ($user->ncodetype as $nn){
                    if ($nn->id==$ncodetype[$i]){
                        $user->ncodetype()->detach($nn->id);
                    }
                }
                $ntype=Ncodetype::find($ncodetype[$i]);
                $filename=$file[$i]->getClientOriginalName();
                $path = 'storage/images/ncode/'.$filename;
                $user->ncodetype()->attach($ncodetype[$i],['path'=>$path]);
                $file[$i]->storeAs('public/images/ncode/', $filename);
            }
        }
        if (count($user->address)>0){
            $address= $user->address[0];
        }
        else{
            $address= new Address();
            $address->user_id=$user->id;
        }

        $address->title=$addressTitle;
        $address->addr=$addr;

        if ($user->save() && $address->save()) {

            DB::commit();
            return "ok";
        } else {
            DB::rollback();
            return "notfound";
        }
    }

    public function getUserById($id)
    {

        $user = User::find($id);

        return isset($user->id) ? $user : 'notfound';

    }

    public function getAllPersonal()
    {


        $user=User::with(['group','city'])->whereHas('group',function ($g){
            $g->where('group_id',2);
        })->get();
        return count($user) > 0 ? $user : "notfound";
    }

    public function getAllCustom()
    {
        $user=User::with(['group','city'])->whereHas('group',function ($g){
            $g->where('group_id',3);
        })->get();
        return count($user) > 0 ? $user : "notfound";
    }

    public function setPersonal($id,$gId)
    {

        $user=User::with('group')->find($id);

        try {
            $user->group()->attach($gId);
            return 'ok';
        }
        catch (\Exception $exception)
        {
            if($user->group()->where('group_id',$gId)->exists()){
                return 'exist';
            }
            return 'notfound';
        }
    }
    public function setPermission($id,$pId)
    {

        $user=User::with('group')->find($id);

        try {
            $user->permission()->attach($pId);
            return 'ok';
        }
        catch (\Exception $exception)
        {
            if($user->permission()->where('group_id',$pId)->exists()){
                return 'exist';
            }
            return 'notfound';
        }
    }

    public function dettachGroupUser($uId,$gId)
    {
        $user=$this->getUserById($uId);
        try {
            $user->group()->detach($gId);
            return 'ok';
        }
        catch (\Exception $exception)
        {

            return 'notfound';
        }
    }

    public function dettachPermissionUser($uId,$pId)
    {
        $user=$this->getUserById($uId);
        try {
            $user->permission()->detach($pId);
            return 'ok';
        }
        catch (\Exception $exception)
        {

            return 'notfound';
        }
    }

    public function editCustumer($id,$name,$family,$ncode,$birthday,$mobilecode,$password,$gender,$email,$addr,$isTrue)
    {
        $user=$this->getUserById($id);

        $user->name=$name;
        $user->family=$family;
        $user->email=$email;
        $user->ncode=$ncode;
        $user->birthday=$birthday;
        $user->mobilecode=$mobilecode;
        if (\Illuminate\Support\Facades\Hash::check($isTrue,$user->password))
        {
            $user->password=Hash::make($password);
        }
        elseif($isTrue==$user->password){

        }
        else
        {
            return "wrongpass";
        }

        $user->gender=$gender;
        if (count($user->address)>0){
            $user->address[0]->addr=$addr;
            if ($user->save()){
                $user->address[0]->save();
                return "ok";
            }
            else
            {
                return "notfound";
            }
        }
        else{
            $address= new Address();
            $address->addr=$addr;
            $address->user_Id=$user->id;
            $address->city_id=$user->city_id;
            if ($user->save()){
                $address->save();
                return "ok";
            }
            else
            {
                return "notfound";
            }
        }

    }

    public function getAllCustomers()
    {
        $users=User::with(['group','city','order', 'wallet'])->whereHas('group',function ($use){
            $use->where('group_id',3);
        })->get();

        foreach ($users as $user){
//            $user['saken']='ساکن';
            $user['wallet_mojoodi']=$user->wallet->mojoodi;

        }
        return count($users)>0?$users:'notfound';
    }


// لیست کاربرانی که سفارش فعال دارند و هنوز تاریخ شروع سفارش آنها فرا نرسیده است.
    public function getAllCustoms()
    {

//        $users=User::with(['group','city','order'])->whereHas('group',function ($use){
//            $use->where('group_id',3);
//        })->whereHas('order',function ($use){
//            $use->where('status_order_id',1)
//                ->whereDate('raft','<=',Date::now())->whereDate('bargasht','>',Date::now());    //@todo: raf lazeme?
//        })->get();
//
//        foreach ($users as $user){
//            $user['saken']='ساکن';
//            $user['takht']=$user->order()->where('status_order_id',1)->whereDate('raft','<=',Date::now())->whereDate('bargasht','>',Date::now())->first()->takht;
//            $user['room']=$user->order()->where('status_order_id',1)->whereDate('raft','<=',Date::now())->whereDate('bargasht','>',Date::now())->first()->takht->room;
//            $user['pansion']=$user->order()->where('status_order_id',1)->whereDate('raft','<=',Date::now())->whereDate('bargasht','>',Date::now())->first()->takht->room->pansion;
//            $user['orderId']=$user->order()->where('status_order_id',1)->whereDate('raft','<=',Date::now())->whereDate('bargasht','>',Date::now())->first()->id;
////            $user['bedehi']=$user->wallet[0]->bedehkar;
//            $user['bedehi']=$user->wallet->bedehkar;
////            if ($user->wallet[0]->bedehkar < 0) {
//
//
//            //@todo:  baraye taskhkshise vaziate besatnkar ya bedehlar, wallet check shavad ya order.bedehkar?
////            if ($user->wallet->bedehkar < 0) {
////                $user['mali'] = 'بستانکار';
////            } else {
////                $user['mali'] = 'بدهکار';
////            }
//
//
//            // @todo: beporsam az DR
//            $user_order = Order::find($user['orderId']);   // get order related to this user
//            $user_bedehkar_value = $user->wallet->bedehkar + $user_order->statusmali[0]->bedehkar - $user_order->statusmali[0]->bestankar;
//            if ($user_bedehkar_value < 0) {
//                $user['mali'] = 'بستانکار';
//            } else {
//                $user['mali'] = 'بدهکار';
//            }
//
//        }
//        return count($users)>0?$users:'notfound';



        //written by zizi

        // لیست کاربرانی که سفارش فعال دارند و هنوز تاریخ شروع سفارش آنها فرا نرسیده است.
        $users=User::with(['group','city','order'])->whereHas('group',function ($use){
            $use->where('group_id',3);
        })->whereHas('order',function ($use) {
            $use->where('status_order_id', 1)
                ->whereDate('raft', '>=', Date::now());
        })->get();

        if(!$users)
            return 'notfound';

        return $users;
    }



    public function getAllCustomsLimitOffset($limit,$offset)
    {

        $users=User::with(['group','city','order'])->whereHas('group',function ($use){
            $use->where('group_id',3);
        })->whereHas('order',function ($use){
            $use->where('status_order_id',1)->whereDate('raft','<=',Date::now())->whereDate('bargasht','>',Date::now());
        })->limit($limit)->offset($offset)->get();

        foreach ($users as $user){
            $user['saken']='ساکن';
            $user['takht']=$user->order()->where('status_order_id',1)->whereDate('raft','<=',Date::now())->whereDate('bargasht','>',Date::now())->first()->takht;
            $user['room']=$user->order()->where('status_order_id',1)->whereDate('raft','<=',Date::now())->whereDate('bargasht','>',Date::now())->first()->takht->room;
            $user['pansion']=$user->order()->where('status_order_id',1)->whereDate('raft','<=',Date::now())->whereDate('bargasht','>',Date::now())->first()->takht->room->pansion;
            $user['orderId']=$user->order()->where('status_order_id',1)->whereDate('raft','<=',Date::now())->whereDate('bargasht','>',Date::now())->first()->id;
            $user['bedehi']=$user->wallet[0]->bedehkar;
            $user['addr']=count($user->address)!=0?$user->address[0]->addr:'-';
            $user['mobiles']=$user->mobile;
            if ($user->wallet[0]->bedehkar < 0) {
                $user['mali'] = 'بستانکار';
            } else {
                $user['mali'] = 'بدهکار';
            }
        }

        return count($users)>0?$users:'notfound';
    }
    public function getAllCustomsHasReserve()
    {

        $users=User::with(['group','city','order'])->whereHas('group',function ($use){
            $use->where('group_id',3);
        })->whereHas('order',function ($use){
            $use->where('status_order_id',1);
        })->get();

        foreach ($users as $user){
            $user['saken']='ساکن';
            $user['orderId']=$user->order->where('status_order_id',1)->first()->id;
        }
        return count($users)>0?$users:'notfound';
    }


    public function getAllCustomsGone()
    {

        $users=User::with(['group','city','order'])->whereHas('group',function ($use){
            $use->where('group_id',3);
        })->whereHas('order',function ($use){
            $use->where('status_order_id',1)->whereDate('bargasht','<',Date::now());
        })->get();

        foreach ($users as $user){
            $user['saken']='ساکن';
            $user['orderId']=$user->order->where('status_order_id',1)->first()->id;
        }
        return count($users)>0?$users:'notfound';
    }


    public function getCustomsByNcode($column,$data)
    {
        if (Schema::hasColumn('users',$column)){
            $users=User::with(['group','city','order'])->whereHas('group',function ($use){
                $use->where('group_id',3);
            })->whereHas('order',function ($use){
                $use->where('status_order_id',1);
            })->where($column,'regexp',$data)->get();
            foreach ($users as $user){
                $user['saken']='ساکن';
                $user['takht']=$user->order()->where('status_order_id',1)->first()->takht;
                $user['room']=$user->order()->where('status_order_id',1)->first()->takht->room;
                $user['pansion']=$user->order()->where('status_order_id',1)->first()->takht->room->pansion;
                $user['orderId']=$user->order->where('status_order_id',1)->first()->id;
                $user['bedehi']=$user->wallet[0]->bedehkar;
                if ($user->wallet[0]->bedehkar < 0) {
                    $user['mali'] = 'بستانکار';
                } else {
                    $user['mali'] = 'بدهکار';
                }
            }
        }
        else{
            return 'notfound';
        }

        foreach ($users as $user) {
            $user['saken'] = 'ساکن';
            if (count($user->address) != 0) {
                $user['addr'] = $user->address[0]->addr;
                $user['orderId'] = $user->order->where('status_order_id', 1)->first()->id;
            }
        }
        return count($users)>0?$users:'notfound';
    }



    public function getCustomsByNcodeLimitOffset($column,$data,$limit,$offset)
    {

        if (Schema::hasColumn('users',$column)){

            $users=User::with(['group','city','order'])->whereHas('group',function ($use){
                $use->where('group_id',3);
            })->whereHas('order',function ($use){
                $use->where('status_order_id',1);
            })->where($column,'regexp',$data)->limit($limit)->offset($offset)->get();
            if (count($users)!=0) {
                foreach ($users as $user) {
                    $user['saken'] = 'ساکن';
                    $user['takht'] = $user->order()->where('status_order_id', 1)->first()->takht;
                    $user['room'] = $user->order()->where('status_order_id', 1)->first()->takht->room;
                    $user['pansion'] = $user->order()->where('status_order_id', 1)->first()->takht->room->pansion;
                    $user['orderId'] = $user->order->where('status_order_id', 1)->first()->id;
                    $user['bedehi']=$user->wallet[0]->bedehkar;
                    if ($user->wallet[0]->bedehkar < 0) {
                        $user['mali'] = 'بستانکار';
                    } else {
                        $user['mali'] = 'بدهکار';
                    }
                }
            }
        }
        else{
            return 'notfound';
        }

        foreach ($users as $user) {
            $user['saken'] = 'ساکن';
            if (count($user->address) != 0) {
                $user['addr'] = $user->address[0]->addr;
                $user['orderId'] = $user->order->where('status_order_id', 1)->first()->id;
            }
        }
        return count($users)>0?$users:'notfound';
    }



    public function getUserByTakht($takhtId)
    {

        $users=User::with(['group','city','order'])->whereHas('group',function ($use){
            $use->where('group_id',3);
        })->whereHas('order',function ($use) use ($takhtId){
            $use->where('status_order_id',1)->where("takht_id",$takhtId);
        })->get();
        if (count($users)!=0) {
            foreach ($users as $user) {
                $user['saken'] = 'ساکن';
                $user['takht'] = $user->order()->where('status_order_id', 1)->first()->takht;
                $user['room'] = $user->order()->where('status_order_id', 1)->first()->takht->room;
                $user['pansion'] = $user->order()->where('status_order_id', 1)->first()->takht->room->pansion;
                $user['orderId'] = $user->order->where('status_order_id', 1)->first()->id;
                $user['bedehi']=$user->wallet[0]->bedehkar;
                if ($user->wallet[0]->bedehkar < 0) {
                    $user['mali'] = 'بستانکار';
                } else {
                    $user['mali'] = 'بدهکار';
                }
            }
        }
        return count($users)>0?$users:'notfound';
    }


    public function getUserByTakhtLimitOffset($takhtId,$limit,$offset)
    {

        $users=User::with(['group','city','order'])->whereHas('group',function ($use){
            $use->where('group_id',3);
        })->whereHas('order',function ($use) use ($takhtId){
            $use->where('status_order_id',1)->where("takht_id",$takhtId);
        })->limit($limit)->offset($offset)->get();
        if (count($users)!=0) {
            foreach ($users as $user) {
                $user['saken'] = 'ساکن';
                $user['takht'] = $user->order()->where('status_order_id', 1)->first()->takht;
                $user['room'] = $user->order()->where('status_order_id', 1)->first()->takht->room;
                $user['pansion'] = $user->order()->where('status_order_id', 1)->first()->takht->room->pansion;
                $user['orderId'] = $user->order->where('status_order_id', 1)->first()->id;
                $user['bedehi']=$user->wallet[0]->bedehkar;
                if ($user->wallet[0]->bedehkar < 0) {
                    $user['mali'] = 'بستانکار';
                } else {
                    $user['mali'] = 'بدهکار';
                }
            }
        }
        return count($users)>0?$users:'notfound';
    }

    public function changePass($id,$oldPass,$newPass)
    {
        $user=User::find($id);

        if (Hash::check($oldPass,$user->password)){
            $user->password=Hash::make($newPass);
            $user->save();
            return 'ok';
        }
        else{
            return  'notfound';
        }
    }

    public function totalCustomers()
    {
        $users=User::with('group')->whereHas('group',function ($g){
            $g->where('group_id',3);
        })->get();
        return count($users)!=0?count($users):0;
    }

    public function detachUserPhoto($id,$photoId)
    {
        $user=User::with('ncodetype')->find($id);
        try {
            $user->ncodetype()->detach($photoId);
            return 'ok';
        }
        catch (\Exception $exception){
            return 'notfound';
        }

    }

    public function payQest($id)
    {
        $aqsat=Qest::with(['statusmali'])->whereHas('statusmali',function ($q) use ($id){
            $q->whereHas('order',function ($qe) use ($id){
                $qe->where('user_id',$id);
            });
        })->get();
        foreach ($aqsat as $qest) {
            $splitTarikh = explode('-', $qest->tarikh);
            $qest['tarikhJalali'] = Verta::create($splitTarikh[0], $splitTarikh[1], $splitTarikh[2], 00, 00, 00)->formatJalaliDate();
            if ($qest->paytarikh != null) {
                $splitPayTarikh = explode('-', $qest->paytarikh);

                $qest['payTarikhJalali'] = Verta::create($splitPayTarikh[0], $splitPayTarikh[1], substr($splitPayTarikh[2], 0, -9), 00, 00, 00)->formatJalaliDate();

            }
            $qest['fullname'] = $qest->statusmali->order->user->name . ' ' . $qest->statusmali->order->user->family;
            $qest['takhtnumber'] = $qest->statusmali->order->takht->takhtnumber;
            $qest['roomnumber'] = $qest->statusmali->order->takht->room->roomnumber;
            $qest['pansionname'] = $qest->statusmali->order->takht->room->pansion->name;
            if ($qest['status'] == '0') {
                $qest['vaziat'] = 'پرداخت نشده.';
            } elseif ($qest['status'] == '1') {
                $qest['vaziat'] = 'پرداخت شده.';
            }
        }
        return count($aqsat)!=0?$aqsat:'notfound';
    }


    public function setActiveCodeForUser($userId)
    {

        $activationCode = rand(100000,999999);   //generate activation code

        //save activation code and generated time to database
        $user = User::where('id',$userId)->update([
            'active_code' => $activationCode,
            'active_code_register_time' => Date::now(),
            'active_code_verify' => '0'
        ]);


        if($user){   //@todo: later activate sms and uncomment below line
            //$this->smsActivationCodeToUser($user->mobilecode, $activationCode);  // sms activation code to user
            return 'true';
        }else {
            return 'false';
//            throw new \Exception("Error in Assigning active code to user");
        }
    }


    public function checkActivationCodeForSpecificUser($active_code, $user_id)
    {
        if(!User::where(['active_code'=>$active_code, 'id'=>$user_id])->exists()) {
            return false;
        }

        $user = User::where(['active_code'=>$active_code, 'id'=>$user_id])->first();
        $user->active_code_verify = '1';
        $user->save();

        return true;
    }

    public function smsActivationCodeToUser($userMobile, $activationCode)
    {
        //@todo
        $apikey = config('kavenegar.apikey');
        $sender = config('kavenegar.linenumber');
        $receptor = "09163216900";   //@todo: change it to user mobile
        $message = $activationCode;

        try{
            $api = new \Kavenegar\KavenegarApi( $apikey );
            $result = $api->Send($sender,$receptor,$message);


            if($result){
                foreach($result as $r){
                    echo "messageid = $r->messageid";
                    echo "message = $r->message";
                    echo "status = $r->status";
                    echo "statustext = $r->statustext";
                    echo "sender = $r->sender";
                    echo "receptor = $r->receptor";
                    echo "date = $r->date";
                    echo "cost = $r->cost";
                }
            }
        }
        catch(\Kavenegar\Exceptions\ApiException $e){
            // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
            echo $e->errorMessage();
        }
        catch(\Kavenegar\Exceptions\HttpException $e){
            // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
            echo $e->errorMessage();
        }
    }


    //============= added by zizi


    //finding bedehkar-bestankat status for this user
    public function getUserTotalStatusmali($id)
    {
        if(! Usertotalstatusmali::where('id', $id)->exists()) {
            return 0;    // user had no transaction, so there is 0 $mande
        }

        //get last totalstatusmali record for this user
        $user_total_status_mali = Usertotalstatusmali::findOrFail($id);
        $bedehi = $user_total_status_mali->total_user_bedehi;    // کل بدهی کاربر
        $pardakhti = $user_total_status_mali->total_user_pardakhti;     // کل پرداختی کاربر

        $mande = intval($bedehi) - intval($pardakhti);   // مانده حساب مشتری. اگر عدد منفی بود یعنی کاربر بستانکار است. در غیر اینصورت کاربر بدهکار است.
        $wallet_mojoodi = $user_total_status_mali->total_wallet_mojoodi;     // موجودی کیف پول کاربر


        return [
            'maande' => $mande,
            'wallet_mojoodi' => $wallet_mojoodi,
        ];
    }

}
