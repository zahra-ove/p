<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Services\Admin\Cities\CityService;
use App\Services\Shop\BuyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BuyController extends Controller
{
    private $buyService;
    private $cityService;

    /**
     * BuyController constructor.
     * @param $buyService
     */
    public function __construct(BuyService $buyService,CityService $cityService)
    {
        $this->buyService = $buyService;
        $this->cityService = $cityService;
    }


    public function reservBoomgardi(Request $request)
    {


        $reserv=$this->buyService->reservBoomgardi($request->productUserId,$request->count,$request->freetimeId,$request->tourId);

        if ($reserv!='notfound'){
            return redirect(route('setpassengers',$reserv->id));
        }
        elseif ($reserv=='notfound'){
            return redirect()->back()->withInput();
        }elseif ($reserv=='muchpassenger')
        {
            return redirect()->back();
            toastr()->error('تعداد انتخاب شده بیشتر از ظرفیت است.');
        }
    }

    public function setPassengers($id)
    {

//dd(Session::get('sabad'));
        $cities = $this->cityService->getAllCities();
        $orderdetail=$this->buyService->getOrderdetailById($id);
        $passengers=$this->buyService->setPassengers($id);
        return view('store.orders.passengers',compact(['orderdetail','passengers','cities']));
    }

    public function editPassenger(Request $request)
    {
//dd($request->id);

for ($i=0;$i<count($request->name);$i++) {
    $passenger = $this->buyService->editPassengers($request->id[$i], $request->name[$i], $request->family[$i], $request->age[$i], $request->ncode[$i], $request->gender[$i]);

}
        if ($passenger=='ok'){
            toastr()->success('محصول به سبد خرید اضافه شد.', 'موفق');
            return redirect(asset(''));
        }
        elseif ($passenger=="notfound"){
            return "notfound";
        }
    }

    public function deletePassenger($id)
    {
    $pass=$this->buyService->deletePassenger($id);
    if ($pass=='ok'){
        return 'ok';
    }
    elseif($pass=='notfound'){
        return 'notfound';
    }
}


    public function basketPage()
    {

        $basket=$this->buyService->Basket();

        $cities = $this->cityService->getAllCities();
        return view('store.basket.basket',compact(['basket','cities']));
    }

    public function basket()
    {
        $basket=$this->buyService->Basket();
        return $basket;
    }

    public function deleteFromBasket(Request $request)
    {
        $delete=$this->buyService->deleteFromBasket($request->item);
        if ($delete){

            return redirect()->back();
        }
        else{
            return 'notfound';
        }
    }

    public function myOrders()
    {
        $orders=$this->buyService->myOrders();
//        dd($orders);
        return view('admin.orders.myorder',compact('orders'));
    }

    public function doneOrders()
    {
        $orders=$this->buyService->doneOrders();
//        dd($orders);
        return view('admin.orders.doneorders',compact('orders'));
    }

    public function moalaghOrders()
    {
        $orders=$this->moalaghOrders()->doneOrders();
//        dd($orders);
        return view('admin.orders.doneorders',compact('orders'));
    }

    public function cancelOrders()
    {
        $orders=$this->buyService->cancelOrders();
//        dd($orders);
        return view('admin.orders.doneorders',compact('orders'));
    }
}
