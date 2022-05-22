<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Hotel;
use App\Models\Productuser;
use App\Models\User;
use App\Services\Sms\Sms;
use Illuminate\Http\Request;
use Kavenegar;

class testController extends Controller
{
    function getBycategory(){
        $user=User::find(32);
        dd($user->favorite->where('id',1)->exists());
    }

    public function kaveh(Sms $sms)
    {
$sms->send('09120779413','سایتم');

//
//        try{
//            $sender = "10001110010010";		//This is the Sender number
//
//            $message = "من بهترین سایتو دارم خستو";		//The body of SMS
//
//            $receptor = array("09126336932");			//Receptors numbers
//
//            $result = Kavenegar::Send($sender,$receptor,$message);
//            if($result){
//                foreach($result as $r){
//                    echo "messageid = $r->messageid";
//                    echo "message = $r->message";
//                    echo "status = $r->status";
//                    echo "statustext = $r->statustext";
//                    echo "sender = $r->sender";
//                    echo "receptor = $r->receptor";
//                    echo "date = $r->date";
//                    echo "cost = $r->cost";
//                }
//            }
//        }
//        catch(\Kavenegar\Exceptions\ApiException $e){
//            // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
//            echo $e->errorMessage();
//        }
//        catch(\Kavenegar\Exceptions\HttpException $e){
//            // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
//            echo $e->errorMessage();
//        }
}
}
