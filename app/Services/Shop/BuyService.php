<?php


namespace App\Services\Shop;


use App\Models\Freetime;
use App\Models\Order;
use App\Models\Orderdetail;
use App\Models\Passenger;
use App\Models\Productuser;
use App\Models\Reserve;

use App\Models\Tour;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BuyService
{

    public function reservBoomgardi($productUserId, $count, $freetimeId,$tourId)
    {
//        dd($freetimeId,$tourId);
        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->status_order_id = '1';
        $order->status = '1';
        $contractNum = str_replace('-', '', Verta(Date::now())->formatDate()) . rand(1000000000, 9999999999);
        $conractExist = Order::where('order_number', $contractNum)->exists();
        if ($conractExist) {
            $contractNum = str_replace('-', '', Verta(Date::now())->formatDate()) . rand(1000000000, 9999999999);
            $conractExist = Order::where('provider_contract_number', $contractNum)->exists();
        }

        if ($conractExist == false) {
            $order->order_number = $contractNum;
        } else {
            return "contractExist";
        }
        DB::beginTransaction();

        if ($order->save()) {
            $orderdetail = new Orderdetail();
            $orderdetail->order_id = $order->id;
            $orderdetail->product_user_id = $productUserId;
            $orderdetail->count = $count;
            if ($orderdetail->save()) {
                Session::push('sabad', ['freetimeId'=>$freetimeId,'orderdetailId'=>$orderdetail->id,'tourId'=>$tourId]);
                $reserv = new Reserve();
                $reserv->orderdetail_id = $orderdetail->id;
                if ($freetimeId!=null) {
                    $reserv->freetime_id = $freetimeId;
                }
                if ($tourId!=null) {
                    $reserv->tour_id = $tourId;
                }
                $reserv->reservestatus_id = 1;
                if ($reserv->save()) {
                    for ($i=0;$i<$count;$i++){
                        $passengers = new Passenger();
                        $passengers->orderdetail_id=$orderdetail->id;
                        $passengers->save();
                    }
                    if ($freetimeId!=null){
                        $free=Freetime::find($freetimeId);
                        $free->status='reserv';
                        $free->save();
                    }
                    if ($tourId!=null){
                        $tour=Tour::find($tourId);
                        $tour->count=intval($tour->count)-intval($count);
                        if ($tour->count==0){
                            $tour->status='full';
                        }
                        if ($tour->count<0){
                            return 'muchpassenger';
                        }
                        $tour->save();
                    }


                }

            }
            DB::commit();
            return $orderdetail;
        } else {
            DB::rollBack();
            return 'notfound';
        }

    }

    public function setPassengers($id)
    {
        $passengers=Passenger::with('orderdetail')->where('orderdetail_id',$id)->get();

        return count($passengers)>0?$passengers:'notfound';

    }

    public function editPassengers($id,$name,$family,$age,$ncode,$gender)
    {
        $passenger=Passenger::find($id);
        $passenger->name=$name;
        $passenger->family=$family;
        $passenger->age=$age;
        $passenger->ncode=$ncode;
        $passenger->gender=$gender;
        $passenger->save();
        try {
            $passenger->save();
            return 'ok';
        }
   catch (\Exception $exception){
       return 'notfound';
   }

    }

    public function getOrderdetailById($id)
    {
        $orderdetail=Orderdetail::find($id);
        return isset($orderdetail)?$orderdetail:'notfound';
    }


    public function Basket()
    {
//dd(Session::get('sabad'));

        $sessions=Session::get('sabad');

//        $productuser=
//        $orderdetail=DB::table('orderdetail as o')->join('product_user as pu')
//
//        $reserv=DB::table('reserves as r')
//            ->join('orderdetail as o','o.id','=','r.orderdetail_id')
//            ->



      $array=[];
      if ($sessions!=null){
        foreach ($sessions as $session) {

            $reserve = Reserve::with(['orderdetail', 'freetime','tour'])
//                ->whereHas('orderdetail', function ($order) use ($session) {
//                    $order->where('product_user_id', $session['productUserId']) ->whereHas('order', function ($orders) use ($session) {
//                        $orders->where('user_id',Auth::id());
//                    });
//                })
                    ->where('orderdetail_id',$session['orderdetailId'])
                ->where('freetime_id', $session['freetimeId'])
                ->orWhere('tour_id', $session['tourId'])
                ->first();

            $reserve['productName'] = $reserve->orderdetail->productuser->product->title;
            $reserve['business_title'] = $reserve->orderdetail->productuser->user->business_title;
            $reserve['price'] = $reserve->orderdetail->productuser->price;
            $reserve['discount_price'] = $reserve->orderdetail->productuser->discount_price;
            $reserve['finally_price'] = intval($reserve['price']) - intval($reserve['discount_price']);
            $reserve['count'] = intval($reserve->orderdetail->productuser->count);
            $reserve['puId'] = intval($reserve->orderdetail->productuser->id);
            $reserve['pathImage'] = $reserve->orderdetail->productuser->photo->where('pick', '1')->first()->path;
            $reserve['cityName'] = $reserve->orderdetail->productuser->city->name;
            $reserve['ostanName'] = $reserve->orderdetail->productuser->city->ostan->name;
            $reserve['rate'] = $reserve->orderdetail->productuser->rate;
            $reserve['passengerCount'] = count($reserve->orderdetail->passenger);
            $reserve['passengers'] = $reserve->orderdetail->passenger;
            if ($reserve->freetime_id!=null){
                $reserve['jalali'] = \verta($reserve->freetime->tarikh)->format("Y") . ' ' . \verta($reserve->freetime->tarikh)->formatWord('l d F');
        }

            if ($reserve->tour_id!=null){
                $reserve['raft'] = \verta($reserve->tour->raft)->format("Y") . ' ' . \verta($reserve->tour->raft)->formatWord('l d F');
                $reserve['bargasht'] = \verta($reserve->tour->bargasht)->format("Y") . ' ' . \verta($reserve->tour->bargasht)->formatWord('l d F');
            }
            array_push($array,$reserve);
//            dd($reserve->orderdetail->productuser->photo->where('pick','1')->first()->path);
        }
      }
//dd($array);
  return count($array)>0?$array:'notfound';
    }

    public function deleteFromBasket($item)
    {
//        try {
            $sessions=Session::get('sabad');
DB::beginTransaction();

if ($sessions[$item]['freetimeId']!=null){
    $free=Freetime::find($sessions[$item]['freetimeId']);
    $free->status='enable';
    $free->save();
    $reserve=Reserve::where('freetime_id',$free->id)->where('orderdetail_id',$sessions[$item]['orderdetailId'])->first();
}
        if ($sessions[$item]['tourId']!=null) {
            $tour = Tour::find($sessions[$item]['tourId']);
            $tour->status = 'enbale';
            $reserve=Reserve::where('tour_id',$tour->id)->where('orderdetail_id',$sessions[$item]['orderdetailId'])->first();

        }

            $orderdetail=Orderdetail::find($reserve->orderdetail_id);
        $reserve->delete();
           Passenger::where('orderdetail_id',$orderdetail->id)->delete();
            $productuser=Productuser::find($orderdetail->product_user_id);
            $productuser->count=intval($productuser->count)+intval($orderdetail->count);
            $order=Order::find($orderdetail->order_id);
        if ($sessions[$item]['tourId']!=null){
        $tour->count=intval($tour->count)+intval($orderdetail->count);
            $tour->save();
        }
            $productuser->save();
            $orderdetail->delete();
            $order->delete();

            Session::forget('sabad.'.$item);
            DB::commit();
            return true;
//        }
//        catch (\Exception $exception){
//            DB::rollBack();
//            return false;
//        }

    }

    public function myOrders()
    {
        $orders = Order::where('status_order_id', 2)->orWhere('status_order_id', 3)->where('user_id', Auth::user()->id)->get();
        if (count($orders) != 0){
            foreach ($orders as $order) {
                if (count($order->orderdetail)>0){
                $order['count'] = $order->orderdetail[0]->count;
                $order['statusTitle'] = $order->statusOrder->title;
                $order['productTitle'] = $order->orderdetail[0]->productuser->product->title;
                $order['productuserId'] = $order->orderdetail[0]->productuser->id;
                }
            }
    }
        return count($orders)>0?$orders:'notfound';
    }



    public function doneOrders()
    {
        $orders=Order::where('status_order_id',2)->get();
        foreach ($orders as $order){
//            dd($order->orderdetail[0]);
            $order['count']=count($order->orderdetail[0]->passenger);
            $order['statusTitle']=$order->statusOrder->title;
            $order['productTitle']=$order->orderdetail[0]->productuser->product->title;
            $order['productuserId']=$order->orderdetail[0]->productuser->id;
            $order['passenger']=$order->orderdetail[0]->passenger;

        }
        return count($orders)>0?$orders:'notfound';

    }

    public function moalaghOrders()
    {
        $orders=Order::where('status_order_id',1)->get();
        foreach ($orders as $order){
            $order['count']=$order->orderdetail[0]->count;
            $order['statusTitle']=$order->statusOrder->title;
            $order['productTitle']=$order->orderdetail[0]->productuser->product->title;
            $order['productuserId']=$order->orderdetail[0]->productuser->id;

        }
        return count($orders)>0?$orders:'notfound';

    }

    public function cancelOrders()
    {
        $orders=Order::where('status_order_id',3)->get();
        foreach ($orders as $order){
            $order['count']=$order->orderdetail[0]->count;
            $order['statusTitle']=$order->statusOrder->title;
            $order['productTitle']=$order->orderdetail[0]->productuser->product->title;
            $order['productuserId']=$order->orderdetail[0]->productuser->id;

        }
        return count($orders)>0?$orders:'notfound';

    }


    public function deletePassenger($id)
    {
        $pass=Passenger::find($id);
        if ($pass->delete()){
            return 'ok';
        }
        else{
            return 'notfound';
        }
    }

}
