<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CancelOrderRequest;
use App\Models\Group;
use App\Services\Admin\Orders\OrderService;
use App\Services\Admin\Pansion\PansionService;
use App\Services\Admin\Takht\TakhtService;
use App\Services\Admin\User\UserService;
use App\Services\Admin\Wallet\WalletService;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{

    private $orderService;
    private $pansionService;
    private $userService;
    private $walletService;

    /**
     * OrderController constructor.
     * @param $orderService
     */
    public function __construct(PansionService $pansionService,OrderService $orderService, UserService $userService, WalletService $walletService)
    {
        $this->orderService = $orderService;
        $this->pansionService = $pansionService;
        $this->userService = $userService;
        $this->walletService = $walletService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders=$this->orderService->getAllOrders();
        return view('admin.master.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $updatePorKhali=$this->orderService->setPorKhaliStatus();

        if ($updatePorKhali){
            $reservetypes=$this->orderService->getAllreservetype();
            $pansions=$this->pansionService->getAllPansions();
            $users=$this->userService->getAllCustomers();
            $naqdtypes=$this->orderService->getAllNaqdtypes();
            $ncodes=$this->orderService->getAllNcodetype();
            $user_mali = $this->userService->getUserTotalStatusmali(Auth::id());

            $maande = $user_mali['maande'];    // مانده حساب مشتری
            $wallet_mojoodi = $user_mali['wallet_mojoodi'];    // موجودی کیف پول


            return view('admin.reserves.create',compact(['reservetypes','pansions','users','naqdtypes','ncodes', 'maande', 'wallet_mojoodi']));
        }
        else{
            return 'خطا در بروز رسانی.';
        }

    }

    // reservation by customer
    public function customReserve($id)
    {
       $this->orderService->setMoalaghOrders();
        $updatePorKhali=$this->orderService->setPorKhaliStatus();
        if ($updatePorKhali){
            $reservetypes=$this->orderService->getAllreservetype();
            $pansions=$this->pansionService->getAllPansions();
            $user=$this->userService->getUserById($id);
            $user_mali = $this->userService->getUserTotalStatusmali($id);

            return view('admin.customs.customreserve',compact(['reservetypes','pansions','user', 'user_mali']));
        }
        else{
            return 'خطا در بروز رسانی.';
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
//    public function store(Request $request)
//    {
//        $jalaliTarikh=[];
//
//        if ($request->qesttarikh!=null) {
//
//
//        }
//
//        $order=$this->orderService->insertOrder($request->reservetype,$request->takht_id,$request->user_id,$request->raft,$request->bargasht,$request->days,$request->price,$request->takhfif,$request->paytype,$request->qesttarikh,$request->totalPrice,$request->finallyPrice,$request->perMonth,$request->naqdtypeTitle,$request->naqdtypeMablagh,$request->permounth,$request->mounth,$request->fish);
//        if ($order=='ok'){
//            $this->orderService->setFullEmptyOrders();
//            toastr()->success('رزرو برای مشترک انجام شد.', 'موفق');
//          return redirect()->back();
//        }
//        elseif ($order=='notfound')
//        {
//            toastr()->error('خطای سیستمی');
//            return redirect()->back();
//        }
//    }


// برای حالتی که سفارش توسط پرسنل انجام شده است.
    public function store(Request $request)
    {

//        dd($request);
//        @todo: form request

        $defaultData = [
            "user_id"         => '',
            "karshenas_id"    => '',
            "takht_id"        => '',
            "raft"            => '',
            "bargasht"        => '',
            "days"            => '',
            "month"           => '',
            "reservetype_id"  => '',
            "takhfif"         => '',
            "charge"          => '',                     // part of order is paid from wallet or not. (1:yes, 0:no)
            "totalPrice"      => '',
            "finallyPrice"    => '',
            "paytype"         => '',                 // naqd, qest
            "qesttarikh"      => '',                // an array that should save to qest table (tarikhe aqsat)
            "qestmablagh"     => '',               // an array that should save to qest table (tarikhe aqsat)
            "naqdtypeTitle"   => '',              // an array that should save to transaction_naqdtype table
            "naqdtypeMablagh" => '',            // an array that should save to transaction_naqdtype table
            "fish"            => '',
            "walletAmountUsedInput"  => '',
            "dargah_mablagh"  => ''
        ];

        $data = [
            "user_id"      => $request->user_id,
            "karshenas_id" => Auth::id(),
            "takht_id"     => $request->takht_id,
            "raft"         => $request->raft,
            "bargasht"     => $request->bargasht,
            "days"         => $request->days,
            "month"        => $request->mounth,
            "reservetype_id"  => $request->reservetype,
            "takhfif"      => $request->takhfif,
            "charge"       => $request->charge,                     // part of order is paid from wallet or not. (1:yes, 0:no)
            "totalPrice"   => $request->totalprice,
            "finallyPrice" => $request->finallyprice,
            "paytype"      => $request->paytype,                // naqd, qest
            "qesttarikh"   => $request->qesttarikh,            // an array that should save to qest table (tarikhe aqsat)
            "qestmablagh"  => $request->qestmablagh,          // an array that should save to qest table (tarikhe aqsat)
            "naqdtypeTitle" => $request->naqdtypeTitle,      // an array that should save to transaction_naqdtype table
            "naqdtypeMablagh" => $request->naqdtypeMablagh, // an array that should save to transaction_naqdtype table
            "fish"            => $request->fish,
            "walletAmountUsedInput"  => $request->walletamountused
        ];

        $data = array_merge($defaultData, $data);

        $order=$this->orderService->insertOrder($data);

        if ($order){
            $this->orderService->setFullEmptyOrders();
            toastr()->success('رزرو برای مشترک انجام شد.', 'موفق');
          return redirect()->back();
        }else {
            toastr()->error('خطای سیستمی');
            return redirect()->back();
        }
    }



    public function customStore(Request $request)
    {
        $order=$this->orderService->customReserve($request->reservetype,$request->takht_id,$request->user_id,$request->raft,$request->bargasht,$request->days,$request->price,$request->permounth,$request->mounth,$request->totalPrice,$request->finallyPrice,$request->charge,$request->beforeCharge,$request->beforeWallet);

        if (isset($order)){
            $this->orderService->setFullEmptyOrders();
            toastr()->success('رزرو انجام شد.', 'موفق');
          return redirect(route('paymentorder',[$order->id,$request->finallyPrice]));
        }
        elseif ($order=='notfound')
        {
            toastr()->error('خطای سیستمی');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order=$this->orderService->editOrder($id,$request->order_status);
        if ($order=='ok'){
            $this->orderService->setFullEmptyOrders();
            toastr()->success('ویرایش انجام شد.', 'موفق');
            return redirect()->back();
        }
        elseif ($order=='notfound')
        {
            toastr()->error('خطای سیستمی');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id  means order id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Request $request)
    {
//        dd($request);
        //@todo: make form request and validate data
        $order=$this->orderService->deleteOrderById($id,$request->fish_jarime,$request->fish_bazgasht_vajh,$request->priceTrans,$request->jarimeh,$request->title,$request->pay_type);
        if ($order=='ok'){
            $this->orderService->setFullEmptyOrders();
            toastr()->success('رزرو کنسل شد.', 'موفق');
            return redirect()->back();
        } elseif ($order=='notfound'){
            toastr()->error('خطای سیستمی');
            return redirect()->back();
        } elseif ($order == 'not enough amount in wallet') {
            toastr()->error('موجودی کیف پول به مقدار کافی نیست!');
            return redirect()->back();
        }elseif($order == 'returning price is not logical') {
            toastr()->error('مبلغ بازگشتی بیش از مبلغ سپرده کاربر نزد پانسیون است!');
            return redirect()->back();
        }
    }


    public function getOrderByTakht($id)
    {
        $orders=$this->orderService->getOrderByTakht($id);
        return $orders;
    }


    public function getOrderByUser($id)
    {
        $orders=$this->orderService->getOrderByUser($id);
        return $orders;
    }

//    public function cancelReserve()
    public function showCancelReserveForm()
    {
//        $users=$this->userService->getAllCustomsHasReserve();

        // لیست تمام کاربرانی که سفارش فعال دارند و هنوز تاریخ شروع سفارش آنها فرا نرسیده است.
        $users=$this->userService->getAllCustoms();
        $usersStatusmali=$this->userService->getUserTotalStatusmali(Auth::id());

        return view('admin.reserves.cancel', [
            'users' => $users,
            'maande' => $usersStatusmali['maande'],
            'wallet_mojoodi' => $usersStatusmali['wallet_mojoodi']
        ]);
    }




    public function moveReserve()
    {
        $users=$this->userService->getAllCustomsHasReserve();
        $reservetypes=$this->userService->getAllCustoms();
        return view('admin.reserves.move',compact(['users','reservetypes']));
    }

    public function indexekhraj()
    {
        $users=$this->userService->getAllCustomsHasReserve();
        $reservetypes=$this->userService->getAllCustoms();
        return view('admin.reserves.ekhrajiha',compact(['users','reservetypes']));
    }


    public function indexkhoruj()
    {
        $users=$this->userService->getAllCustomsHasReserve();
        $reservetypes=$this->userService->getAllCustoms();
        return view('admin.reserves.khorujiha',compact(['users','reservetypes']));
    }


    public function taghirVaziat()
    {
        $users=$this->userService->getAllCustomsHasReserve();
        $reservetypes=$this->userService->getAllCustoms();
        return view('admin.reserves.taghirvaziat',compact(['users','reservetypes']));
    }


    public function deletePassDay($id,Request $request)
    {

        $jalaliTarikh=[];
        if ($request->qesttarikh!=null) {
            foreach ($request->qesttarikh as $tar) {

                $split = explode('/', $tar);
                $har = Verta::createJalali($split[0], $split[1], $split[2], 00, 00, 00);
                $jalali = $har->formatGregorian('Y-m-d');
                array_push($jalaliTarikh, $jalali);
            }
        }
        $order=$this->orderService->deleteOrderPassById($id,$request->reservetype,$request->takht_id,$request->user_id,$request->raft,$request->bargasht,$request->days,$request->price,$request->takhfif,$request->paytype,$jalaliTarikh,$request->totalPrice,$request->finallyPrice,$request->perMonth,$request->permounth,$request->mounth,$request->bestankar,$request->naqdtypeTitle,$request->naqdtypeMablagh,$request->fish);

        if ($order=='ok'){
            $this->orderService->setFullEmptyOrders();
            toastr()->success('کنسلی انجام شد.', 'موفق');
            return redirect(route('recentreserve'));        }
        elseif ($order=='notfound'){
            toastr()->error('خطای سیستمی');
            return redirect()->back();
        }
    }


    public function ekhraaj($id,Request $request)
    {

        $jalaliTarikh=[];
        if ($request->qesttarikh!=null) {
            foreach ($request->qesttarikh as $tar) {

                $split = explode('/', $tar);
                $har = Verta::createJalali($split[0], $split[1], $split[2], 00, 00, 00);
                $jalali = $har->formatGregorian('Y-m-d');
                array_push($jalaliTarikh, $jalali);
            }
        }
        $order=$this->orderService->ekhrajOrderPassById($id,$request->reservetype,$request->takht_id,$request->user_id,$request->raft,$request->bargasht,$request->days,$request->price,$request->takhfif,$request->paytype,$jalaliTarikh,$request->totalPrice,$request->finallyPrice,$request->perMonth,$request->permounth,$request->mounth,$request->bestankar,$request->naqdtypeTitle,$request->naqdtypeMablagh,$request->fish,$request->editor);

        if ($order=='ok'){
            $this->orderService->setFullEmptyOrders();
            toastr()->success('اخراج فرد انجام شد.', 'موفق');
            return redirect(route('recentreserve'));        }
        elseif ($order=='notfound'){
            toastr()->error('خطای سیستمی');
            return redirect()->back();
        }
    }
    public function khorooj($id,Request $request)
    {

        $jalaliTarikh=[];
        if ($request->qesttarikh!=null) {
            foreach ($request->qesttarikh as $tar) {

                $split = explode('/', $tar);
                $har = Verta::createJalali($split[0], $split[1], $split[2], 00, 00, 00);
                $jalali = $har->formatGregorian('Y-m-d');
                array_push($jalaliTarikh, $jalali);
            }
        }
        $order=$this->orderService->khorujOrderPassById($id,$request->reservetype,$request->takht_id,$request->user_id,$request->raft,$request->bargasht,$request->days,$request->price,$request->takhfif,$request->paytype,$jalaliTarikh,$request->totalPrice,$request->finallyPrice,$request->perMonth,$request->permounth,$request->mounth,$request->bestankar,$request->naqdtypeTitle,$request->naqdtypeMablagh,$request->fish);

        if ($order=='ok'){
            $this->orderService->setFullEmptyOrders();
            toastr()->success('خروج فرد انجام شد.', 'موفق');
            return redirect(route('recentreserve'));        }
        elseif ($order=='notfound'){
            toastr()->error('خطای سیستمی');
            return redirect()->back();
        }
    }

    public function getAllnaqdtypes()
    {
        $naqdtypes=$this->orderService->getAllNaqdtypes();
        return $naqdtypes;
    }

    public function getAllreservetypes()
    {
        $reservetype=$this->orderService->getAllreservetype();
        return $reservetype;
    }

    public function cancelPast($id)
    {
        $order=$this->orderService->getOrderById($id);
        $naqdtypes=$this->orderService->getAllNaqdtypes();
        return view('admin.reserves.pastcancel',compact(['order','naqdtypes']));

    }

//    public function ajaxPast($id)
//    {
//        $order=$this->orderService->getOrderById($id);
//        $naqdtypes=$this->orderService->getAllNaqdtypes();
//        return view('admin.reserves.ajaxcancel',compact(['order','naqdtypes']));
//
//    }

    public function ajaxKhorooj($id)
    {
        $order=$this->orderService->getOrderById($id);
        $naqdtypes=$this->orderService->getAllNaqdtypes();
        $statusmalis=$this->orderService->getAllStatusmaliByOrder($order->user_id);
        $reservetypes=$this->orderService->getAllreservetype();

        return view('admin.reserves.ajaxkhorooj',compact(['order','naqdtypes','statusmalis','reservetypes']));

    }

    public function ajaxEkhraaj($id)
    {
        $order=$this->orderService->getOrderById($id);
        $reservetypes=$this->orderService->getAllreservetype();
        $naqdtypes=$this->orderService->getAllNaqdtypes();
        $statusmalis=$this->orderService->getAllStatusmaliByOrder($order->user_id);
        return view('admin.reserves.ajaxekhraaj',compact(['order','naqdtypes','statusmalis','reservetypes']));

    }

    public function ajaxMove($id)
    {
        $order=$this->orderService->getOrderById($id);
        $naqdtypes=$this->orderService->getAllNaqdtypes();
        $pansions=$this->pansionService->getAllPansions();
        $reservetypes=$this->orderService->getAllreservetype();
        $statusmalis=$this->orderService->getAllStatusmaliByOrder($order->user_id);
        return view('admin.reserves.ajaxmove',compact(['order','naqdtypes','statusmalis','pansions','reservetypes']));

    }

    public function ajaxVaziat($id)
    {
        $order=$this->orderService->getOrderById($id);
        $naqdtypes=$this->orderService->getAllNaqdtypes();
        $pansions=$this->pansionService->getAllPansions();
        $statusmalis=$this->orderService->getAllStatusmaliByOrder($order->user_id);
        $reservetypes=$this->orderService->getAllreservetype();

        return view('admin.reserves.ajaxvaziat',compact(['order','naqdtypes','statusmalis','pansions','reservetypes']));

    }

    public function ekhraaji($id)
    {
        $order=$this->orderService->getOrderById($id);
        $naqdtypes=$this->orderService->getAllNaqdtypes();
        $statusmalis=$this->orderService->getAllStatusmaliByOrder($order->user_id);
        $reservetypes=$this->orderService->getAllreservetype();

        return view('admin.reserves.ekhraaj',compact(['order','naqdtypes','statusmalis','reservetypes']));

    }

    public function khrooji($id)
    {
        $order=$this->orderService->getOrderById($id);
        $naqdtypes=$this->orderService->getAllNaqdtypes();
        $reservetypes=$this->orderService->getAllreservetype();
        $statusmalis=$this->orderService->getAllStatusmaliByOrder($order->user_id);

        return view('admin.reserves.khorooj',compact(['order','naqdtypes','statusmalis','reservetypes']));

    }

    public function wheremove($id)
    {

        $order=$this->orderService->getOrderById($id);
        $pansions=$this->pansionService->getAllPansions();
        $reservetypes=$this->orderService->getAllreservetype();
        $naqdtypes=$this->orderService->getAllNaqdtypes();
        return view('admin.reserves.wheremove',compact(['order','pansions','reservetypes','naqdtypes']));

    }


    public function vaziat($id)
    {

        $order=$this->orderService->getOrderById($id);
        $pansions=$this->pansionService->getAllPansions();
        $reservetypes=$this->orderService->getAllreservetype();
        $naqdtypes=$this->orderService->getAllNaqdtypes();
        return view('admin.reserves.vaziat',compact(['order','pansions','reservetypes','naqdtypes']));

    }

    public function moveTakht($id,Request $request)
    {
        dd($request);
        $jalaliTarikh=[];
        if ($request->qesttarikh!=null) {

        }

        $order=$this->orderService->moveOrderPassById($id,$request->reservetype,$request->prereservetype,$request->takht_id,$request->user_id,$request->raft,$request->bargasht,$request->days,$request->daysdovom,$request->bestankar,$request->totaldovom,$request->price,$request->takhfif,$request->paytype,$request->qesttarikh,$request->totalPrice,$request->finallyPrice,$request->perMonth,$request->permounth,$request->mounth,$request->monthDovom,$request->naqdtypeMablagh,$request->naqdtypeTitle,$request->fish);

        if ($order=='ok') {
            $this->orderService->setFullEmptyOrders();
            toastr()->success('جابجایی تخت با موفقیت انجام شد.', 'موفق');
            return redirect(route('recentreserve'));
        }
//        elseif ($order=='notfound'){
//            toastr()->error('خطای سیستمی');
//            return redirect()->back();
//        }
    }


    public function getOrdersByUser($id)
    {
        $orders=$this->orderService->getAllOrderByUser($id);
        $user=$this->userService->getUserById($id);
        return view('admin.customs.reserves',compact(['orders','user']));
    }


    public function getReserveOrderAuth()
    {
        $order=$this->orderService->getReserveOrderByUser();

        return view('admin.reserves.recentreserve',compact('order'));
    }

    public function getStatusmaliByOrder($id)
    {
        $statusmali=$this->orderService->getStatusmaliByOrder($id);
        return view('admin.mali.mali',compact('statusmali'));
    }

//    public function getActiveStatusOrderByUser($id)
//    {
//        return $this->orderService->getActiveStatusOrderByUser($id);
//
//    }

    public function getAllOrderLimitOffset(Request $request)
    {
        $orders=$this->orderService->getAllOrderLimitOffset($request->limit,$request->offset);
        return $orders;
    }


    public function getAllOrders()
    {
        if ($this->orderService->getAllOrders()!='notfound'){
        $pages=intval(ceil(count($this->orderService->getAllOrders())/10));
        }
        else{
                $pages=0;
            }
        return view('admin.orders.allorders',compact('pages'));
    }

    public function getAllOrdersByDate()
    {
        if ($this->orderService->getAllOrders()!='notfound'){
            $pages=intval(ceil(count($this->orderService->getAllOrders())/10));
        }
        else{
            $pages=0;
        }
        return view('admin.orders.allordersbydate',compact('pages'));
    }
    public function getOderBySearchLimitOffset(Request $request)
    {
        $orders=$this->orderService->getOderBySearchLimitOffset($request->column,$request->output,$request->limit,$request->offset);
        return $orders;
    }

    public function getOderBySearch(Request $request)
    {
        $orders=$this->orderService->getOderBySearch($request->column,$request->output);
        return $orders;
    }

    public function getAllOrdersReturn()
    {
        $orders=$this->orderService->getAllOrders();
        return $orders;
    }

    public function getOrderByDates(Request $request)
    {
        $orders=$this->orderService->getOrderByDates($request->from,$request->to,$request->limit,$request->offset);
        return $orders;
    }

    public function getAllOrderByDates(Request $request)
    {
        $orders=$this->orderService->getAllOrderByDates($request->from,$request->to);
        return $orders;
    }

    public function getOrdersNotPay()
    {
        if ($this->orderService->getOrdersNotPay()!='notfound'){
            $pages=intval(ceil(count($this->orderService->getOrdersNotPay())/10));
        }
        else{
            $pages=0;
        }

                return view('admin.orders.ordersnotpay',compact('pages'));

    }


    public function getAllOrdersNotPay()
    {
        $orders=$this->orderService->getOrdersNotPay();
        return $orders;

    }


    public function getOrdersNotPayLimitOffset(Request $request)
    {
        $orders=$this->orderService->getOrdersNotPayLimitOffset($request->limit,$request->offset);
        return $orders;
    }
    public function getOrdersNotPayDateLimitOffset(Request $request)
    {
        $orders=$this->orderService->getOrdersNotPayDateLimitOffset($request->from,$request->to,$request->limit,$request->offset);
        return $orders;
    }
    public function getOrdersNotPayDate(Request $request)
    {
        $orders=$this->orderService->getOrdersNotPayDate($request->from,$request->to);
        return $orders;
    }
    public function getAqsatByOrder($id)
    {
        $aqsat=$this->orderService->getAqsatByOrder($id);
        $order=$this->orderService->getOrderById($id);
        $naqdtypes=$this->orderService->getAllNaqdtypes();

        return view('admin.orders.getaqsatbyorder',compact(['aqsat','order','naqdtypes']));
    }

    public function payQest($id,Request $request)
    {

        $qest=$this->orderService->payQest($id,$request->paytarikh,$request->naqdtype,$request->fish);
        if ($qest=='ok'){
            toastr()->success('پرداخت قسط با موفقیت انجام شد.', 'موفق');
            return redirect()->back();
        }
        elseif ($qest=='notfound'){
            toastr()->error('خطای سیستمی');
            return redirect()->back();
        }
    }

    public function getReserveforTakhtBetween2Dates($id,Request $request)
    {
        $orders=$this->orderService->getReserveforTakhtBetween2Dates($id,$request->raft,$request->bargasht,$request->reservetype,$request->thisId);

        return $orders;

    }

    public function getOrders5DaysLeft()
    {
        $orders=$this->orderService->getOrders5DaysLeft();
        return $orders;
    }
    public function getQest3DaysLeft()
    {
        $orders=$this->orderService->getQests3Dayleft();
        return $orders;
    }

    public function getOrders5DaysSoon()
    {
        $orders=$this->orderService->getOrders5DaysSoon();
        return $orders;
    }

//    public function tamdidOrder($id)
//    {
//        $this->orderService->setMoalaghOrders();
//        $user=$this->userService->getUserById($id);
////        $order=$this->orderService->getOrderByUserFirst($id);
//        $order=$this->orderService->getAllActiveOrderInfoForSpecificUser($id);
//        $usersStatusmali=$this->userService->getUserTotalStatusmali(Auth::id());
//
//
//        return view('admin.customs.tamdid', [
//            'user' => $user,
//            'order' => $order,
//            'maande' => $usersStatusmali['maande'],      // مانده اگر منفی باشد، یعنی کاربر بستانکار است.
//            'wallet_mojoodi' => $usersStatusmali['wallet_mojoodi']
//        ]);
//
//    }
//
//    public function tamdid($id)
//    {
//
//        $order=$this->orderService->tamdid($id);
//    }
//
//    public function fullForTamdid($raft,$bargasht,$takht_id)
//    {
//        $order=$this->orderService->fullForTamdid($raft,$bargasht,$takht_id);
//        return $order;
//    }

    public function paymentOrder($id,$price)
    {
        $order=$this->orderService->getOrderById($id);
        $totalPrice=$price;
        return view('admin.customs.payment',compact(['order','totalPrice']));
    }


    //==== added by me
    public function getAllActiveOrderInfoForSpecificUser($id)
    {
        $userOrders = $this->orderService->getAllActiveOrderInfoForSpecificUser($id);
        if(!$userOrders)
            return false;

        return $userOrders;
    }

    // دریافت لیست اقساط یک سفارش خاص
    public function getAqsatListForSpecificOrder($orderId)
    {
        $order_qest_list = $this->orderService->getAqsatListForSpecificOrder($orderId);
        if(!$order_qest_list)
            return 'notfound';

        return $order_qest_list;
    }

    // دریافت لیست تراکنشهای یک سفارش خاص
    public function getTransactionListForSpecificOrder($orderId)
    {
        $order_transaction_list = $this->orderService->getTransactionListForSpecificOrder($orderId);
        if(!$order_transaction_list)
            return 'notfound';

        return $order_transaction_list;
    }

    public function getwalletmojoodiandordertotalprice($userId, $orderId)
    {
        $order_details = $this->orderService->getOrderTotalPrice($orderId);    // get order details for this specific order
        $wallet_mojoodi = $this->walletService->getWalletMojoodiForSpecifcUser($userId);    // get wallet mojoodi for this specific user

        return array_merge($order_details, ['wallet_mojoodi' => $wallet_mojoodi]);
    }

    public function cancelorder(CancelOrderRequest $request)
    {
        $data = [
            "orderId" => $request->post("orderId"),       // شماره آیدی سفارش
            "jarime" => $request->post("jarime"),       // مبلغ حریمه، که ممن است صفر باشد. یعنی کاربر جریمه نشده
            "returnVajhToCustomer" => $request->post("returnVajhToCustomer"),    // چه مبلغی به کاربر بازگشت داده شده
            "paid_amount" => $request->post("paid_amount"),     // کاربر به ازای این سفارش، چه میزان پرداختی داشته
            "jarime_pay_way" => $request->post("jarime_pay_way"),     // روش دریافت جریمه
            "returningfish" => $request->file("returningfish"),      //   فیش مربوط به بازگشت وجه
            "jarimefish" => $request->file("jarimefish"),    // فیش مربوط به جریمه
        ];

        return $this->orderService->cancelorder($data);
    }



    //======== tamdidform
    public function tamdidform()
    {
        $user = Auth::user();    // user object
        $userGroups = array();   // list of user's group
        $ismoshtari = 0;         // is this authenticated user is an ordinary user?  0:no   1:yes
        $ispersonel = 0;         // is this authenticated user is personel?  0:no   1:yes


        foreach($user->group as $group) {
            $userGroups[] = $group->id;
        }

        // if user is in personel group then send all users list to view
        if( in_array(Group::PERSONEL, $userGroups) ) {

            $allUsers = $this->userService->getAllCustomers();   // all users list
            $ispersonel = 1;
        } elseif ( in_array(Group::MOSHTARI, $userGroups) ) {     // if user is an ordinary user, then send only this user info to the view

           // return all active orders related to this user
            $ismoshtari = 1;
            $allActiveOrdersForThisSpecificUser = $this->getAllActiveOrderInfoForSpecificUser($user->id);
        }


        // maande hesabe in user
        $statusmaliResultsForThisUser = $this->userService->getUserTotalStatusmali($user->id);


        return view('admin.customs.tamdid2', [
            'userid' => $user->id,
            'maande' => $statusmaliResultsForThisUser['maande'],
            'wallet_mojoodi' => $statusmaliResultsForThisUser['wallet_mojoodi'],
            'ismoshtari'     => $ismoshtari,
            'ispersonel'     => $ispersonel,
            'allusers'       => $allUsers ?? '',
            'allactiveordersforthisspecificuser' => $allActiveOrdersForThisSpecificUser ?? '',
        ]);
    }


    public function tamdidreserve()
    {

    }





}
