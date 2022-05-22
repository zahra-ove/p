<?php


namespace App\Services\Admin\Orders;


use App\Exceptions\ModelNotSavedException;
use App\Exceptions\WalletException;
use App\Models\Jarime;
use App\Models\Massage;
use App\Models\Naqdtype;
use App\Models\Ncodetype;
use App\Models\Order;
use App\Models\Orderarchive;
use App\Models\Photo;
use App\Models\Qest;
use App\Models\Reservetime;
use App\Models\Reservetype;
use App\Models\Room;
use App\Models\Statusmali;
use App\Models\Statusmalichangedorder;
use App\Models\Statusorder;
use App\Models\Takht;
use App\Models\Transaction;
use App\Models\Transactiontype;
use App\Models\Usertotalstatusmali;
use App\Models\Wallet;
use App\Models\wallettransaction;
use App\Services\Admin\Jarime\JarimeService;
use App\Services\Admin\Statusmali\StatusmalichangedorderService;
use App\Services\Admin\Statusmali\StatusmalitransactionService;
use App\Services\Admin\Transaction\TransactionService;
use App\Services\Admin\Wallet\WalletService;
use App\Services\Sms\Sms;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use http\Client\Curl\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use App\Models\Paytype;
use App\Services\Admin\Statusmali\UsertotalstatusmaliService;
use App\Services\Admin\Statusmali\UsertotalstatusmalitransactionsService;



class OrderService
{

    private $smsService;
    private $walletService;
    private $transactionService;
    private $statusmalitransactionService;
    private $usertotalstatusmaliService;
    private $usertotalstatusmalitransactionsService;
    private $statusmalichangedorderService;
    private $jarimeService;


    public function __construct(Sms $smsService,
                                WalletService $walletService,
                                TransactionService $transactionService,
                                StatusmalitransactionService $statusmalitransactionService,
                                UsertotalstatusmaliService $usertotalstatusmaliService,
                                UsertotalstatusmalitransactionsService $usertotalstatusmalitransactionsService,
                                StatusmalichangedorderService $statusmalichangedorderService,
                                JarimeService $jarimeService
    )
    {
        $this->smsService = $smsService;
        $this->walletService = $walletService;
        $this->transactionService = $transactionService;
        $this->statusmalitransactionService = $statusmalitransactionService;
        $this->usertotalstatusmaliService = $usertotalstatusmaliService;
        $this->usertotalstatusmalitransactionsService = $usertotalstatusmalitransactionsService;
        $this->statusmalichangedorderService = $statusmalichangedorderService;
        $this->jarimeService = $jarimeService;
    }


    public function getAllOrders()
    {
        $orders = Order::all();
        return count($orders) > 0 ? $orders : 'notfound';
    }


//=============================== modified method by zizi ===============================//

    // دریافت لیست اقساط یک سفارش خاص
    public function getAqsatListForSpecificOrder($orderId)
    {
        return json_encode(Order::findOrFail($orderId)->qests);
    }

    // دریافت لیست تراکنشهای یک سفارش خاص
    public function getTransactionListForSpecificOrder($orderId)
    {
        $order = Order::findOrFail($orderId);

        if(!$order)
            return 'notfound';

        $orderTransactionsList = array();

        if($order->transactions->count())  {

            foreach($order->transactions as $transKey => $t) {

                if($t->status == 'success') {
                    $orderTransactionsList[$transKey] = $t;
                }

            }
        }


        return json_encode($orderTransactionsList);
    }



    // get all active orders with all related information
    public function getAllActiveOrderInfoForSpecificUser($userId)
    {

//        $userOrders = Order::with('qests')->where('user_id', $userId)
        $userOrders = Order::where('user_id', $userId)
                            ->where('status_order_id', 1)
                            ->get();


        if(!$userOrders) return false;

        $filteredUserOrders = array();
        $allPaytypes = array();


        foreach($userOrders as $orderkey => $order) {

            // جزییات پرداخت برای هر سفارش
            foreach($order->statusmali->paytypes as $paytype) {

                // wallet
                if($paytype->id == Paytype::WALLET) {

                    $allPaytypes[$paytype->title] = $order->statusmali->total_wallet_amount_paid;
                }


                // dargah
                if($paytype->id == Paytype::DARGAH_PARDAKHT) {

                    $allPaytypes[$paytype->title] = $order->statusmali->total_dargah_amount_paid;
                }

                // qests
                if($paytype->id == Paytype::QEST) {

                    $allPaytypes[$paytype->title] = [
                        'nobat_count' => $order->qests()->count()
                    ];
                    foreach($order->qests as  $qest) {
                        $allPaytypes[$paytype->title]['nobats'][$qest->nobate_qest]['amount'] = $qest->amount;
                        $allPaytypes[$paytype->title]['nobats'][$qest->nobate_qest]['tarikh_mogharar'] = $qest->tarikh_mogharar;
                        $allPaytypes[$paytype->title]['nobats'][$qest->nobate_qest]['tarikh_pardakht'] = $qest->tarikh_pardakht;
                        $allPaytypes[$paytype->title]['nobats'][$qest->nobate_qest]['status'] = $qest->status == '0' ? 'پرداخت شده' : ' پرداخت نشده';
                    }
                }

                // naqd
                if($paytype->id == Paytype::NAQD) {
                    foreach($order->transactions as $transaction) {
                        if( !is_null($transaction->naqdtype_id) ) {
                            $allPaytypes[$paytype->title][$transaction->naqdtype->title] = $transaction->price;
                        }
                    }
                }


            }

            $pansionName = $order->takht->room->pansion->name;
            $roomNumber = $order->takht->room->roomnumber;
            $takhtNumber = $order->takht_id;


            $filteredUserOrders[$orderkey] = array(
                "id" => $order->id,
                "takht_info" => ' پانسیون: ' . $pansionName . ' ، ' .  'اتاق: ' . $roomNumber . ' ، ' . ' تخت: ' . $takhtNumber,
                "raft" => $order->raft,
                "bargasht" => $order->bargasht,
                "order_finally_price" => intval($order->statusmali->order_finally_price),
//                "paid_way" => $pays ?? '',
                "paid_amount" => intval($order->statusmali->total_wallet_amount_paid + $order->statusmali->total_dargah_amount_paid + $order->statusmali->total_naghdi_amount_paid + $order->statusmali->total_qest_amount_paid),                  // مبلغ پرداخت شده توسط مشتری
                "maande_amount" => intval($order->statusmali->maande_amount),               // مبلغ مانده قابل پرداخت
                "total_mali_status" => $order->statusmali->financial_status,              // وضعیت کلی مالی این سفارش
                "allpaytypes" => $allPaytypes
            );
        }


        return json_encode($filteredUserOrders);
    }



    // رزرو توسط پرسنل انجام شده و شامل حالت درگاه پرداخت نمیشود.
    public function insertOrder($data)
    {
        //---- initial setup

        // اگر کیف استفاده نشده باشد، مقدار 0 بذار.
        if($data['charge'] == null) {
            $data['charge'] = 0;
        }
        // مبلغ مصرف شده از کیف پول
        if($data['walletAmountUsedInput']== null) {
            $data['walletAmountUsedInput'] = 0;
        }

        // کل مبلغ نقد پرداخت شده برای این سفارش
        $total_naqd_mablaq = 0;
        if($data['naqdtypeMablagh']) {
            foreach ($data['naqdtypeMablagh'] as $key => $naqdmablaq) {
                $total_naqd_mablaq += $naqdmablaq;
            }
        }


        //---- begin transaction

        DB::beginTransaction();

        // اطلاعات کلی سفارش
        $order = new Order();
        $order->user_id = $data['user_id'];
        $order->karshenas_id = Auth::id();
        $order->takht_id = $data['takht_id'];
        $order->raft = $data['raft'];
        $order->bargasht = $data['bargasht'];
        $order->days = $data['days'];
        $order->month = $data['month'];
        $order->order_number = substr(time () . uniqid(), 0, 18);   // generate unique random number
        $order->status_order_id = Statusorder::ACTIVE;
        $order->reservetype_id = $data['reservetype_id'];
        $order->takht_move = '0';
        $order->time_move = '0';

        if($order->save()) {

            // ثبت وضعیت سفارش
            $orderArchive = new Orderarchive(array('status_order_id' => $order->status_order_id));
            $order->orderarchives()->save($orderArchive);

            // وضعیت مالی سفارش
            $orderStatusMali = new Statusmali();
            $orderStatusMali->id = $order->id;     //one to one relation bw `statusmali` and `order`
            $orderStatusMali->status_order_id = $order->status_order_id;
            $orderStatusMali->order_total_price_before_takhfif = $data['totalPrice'];
            $orderStatusMali->takhfif = $data['takhfif'];
            $orderStatusMali->order_finally_price = $data['finallyPrice'];
            $orderStatusMali->total_wallet_amount_paid = $data['walletAmountUsedInput'];
            $orderStatusMali->total_dargah_amount_paid = 0;
            $orderStatusMali->total_naghdi_amount_paid = $total_naqd_mablaq;
            $orderStatusMali->total_qest_amount_paid = 0;
            $orderStatusMali->maande_amount = $data['finallyPrice'] -  $total_naqd_mablaq;

            if($orderStatusMali->maande_amount == 0) {
                // tasvie shode
                $orderStatusMali->financial_status = 'paid';
            } elseif( ($orderStatusMali->maande_amount > 0)  &&  ($orderStatusMali->maande_amount == $data['finallyPrice']) ) {
                // tasvie nashode
                $orderStatusMali->financial_status = 'notpaid';
            } elseif( ($orderStatusMali->maande_amount > 0)  &&  ($orderStatusMali->maande_amount != $data['finallyPrice']) ) {
                // bakhshi tasvie shode
                $orderStatusMali->financial_status = 'partiallypaid';
            }
            $orderStatusMali->save();

            // تمام روشهای پرداخت استفاده شده برای این سفارش
            // شامل روش: نقد/ قسط/ درگاه پرداخت/ کیف پول
            // این مقادیر در جدول میانی قرار میگیرند
            if($data['walletAmountUsedInput'] > 0) {
                $orderStatusMali->paytypes()->attach(Paytype::WALLET);
            } elseif($data['dargah_mablagh'] > 0) {
                $orderStatusMali->paytypes()->attach(Paytype::DARGAH_PARDAKHT);
            } elseif($total_naqd_mablaq > 0) {
                $orderStatusMali->paytypes()->attach(Paytype::NAQD);
            } elseif($data['paytype'] == 'q') {
                $orderStatusMali->paytypes()->attach(Paytype::QEST);
            }



            // افزایش مقدار بدهی و پرداختی برای وضعیت کلی مالی کاربر
            $total_pardakhti_for_this_order = $data['walletAmountUsedInput'] + $total_naqd_mablaq;   // @todo: dargah ham bayad dar nazar gerefte shavad
            $this->usertotalstatusmaliService->updateUsertotalstatusmali($order->user_id, 0, 0, ($data['finallyPrice'] + $data['walletAmountUsedInput']), $total_pardakhti_for_this_order, 0, 0, 0);


            // update bedehi column in usertotalstatusmalitransactions for this order
            $mainData = [
                'usertotalstatusmalis_id' => $data['user_id'],
                'order_id' => $order->id,
                'bedehi_changed_amount' => $data['finallyPrice'],
                'bedehi_change_type' => '1',
            ];
            $this->usertotalstatusmalitransactionsService->createUsertotalstatusmalitransaction($mainData);


            // به ازای هر یک پرداختی های نقدی، یک تراکنش ثبت شود.
            if( ($data['paytype'] == 'n')  &&  ($data['finallyPrice'] > 0) ) {
                foreach($data['naqdtypeMablagh'] as $key => $naqdmablaq) {

                    // transaction for each naqd payment
                    $mainData = [
                        'order_id' => $order->id,
                        'user_id' => $data['user_id'],
                        'karshenas_id' => Auth::id(),
                        'transactiontype_id' => Transactiontype::PARDAKHT_NAGHD,   // پرداخت نقدی
                        'naqdtype_id' => $data['naqdtypeTitle'][$key],
                        'price' => $naqdmablaq,
                        'fish_path' => !is_null($data['fish']) ? $data['fish'][$key] : '',
                        'status' => 'success',
                        'type' => 'variz',
                    ];
                    $transactionId = $this->transactionService->createTransaction($mainData);    // returns id of new inserted transaction


                    //statusmalitransaction for each naqd payment
                    $mainData = [
                        'statusmali_id' => $order->id,
                        'transaction_id' => $transactionId,
                        'order_id' => $order->id,
                        'status_order_id' => $order->status_order_id,
                        'order_total_price_before_takhfif' => $orderStatusMali->order_total_price_before_takhfif,
                        'takhfif' => $orderStatusMali->takhfif,
                        'order_finally_price' => $orderStatusMali->order_finally_price,
                        'naghdi_amount_paid' => $naqdmablaq,
                    ];
                    $this->statusmalitransactionService->createStatusmalitransaction($mainData);


                    $mainData = [
                        'usertotalstatusmalis_id' => $data['user_id'],
                        'transaction_id' => $transactionId,
                        'order_id' => $order->id,
                        'pardakhti_changed_amount' => $naqdmablaq,
                        'pardakhti_change_type' => '1',
                    ];
                    $this->usertotalstatusmalitransactionsService->createUsertotalstatusmalitransaction($mainData);

                }

            }   // end of naqd payment foreach


            // update wallet mojoodi and related tables, if wallet is used for payment
            if(  $data['charge'] == '1' ) {

                $this->walletService->walletDecreaseForReservation($data['user_id'], floatval($data['walletAmountUsedInput']), $order->id, $order->status_order_id, 'کسر از کیف پول بابت پرداخت بخشی از هزینه رزرو');
            }


            // اگر پرداخت اقساطی هم باشد، قسطها را ثبت کن
            if( $data['finallyPrice'] > 0 ) {
                if ($data['paytype'] == 'q') {   // qest pay
                    if (count($data['qesttarikh']) != 0) {

                        for ($i = 0; $i < count($data['qesttarikh']); $i++) {
                            $qest = new Qest();
                            $qest->order_id = $order->id;
                            $qest->tarikh_mogharar = $data['qesttarikh'][$i];
                            $qest->nobate_qest = $i + 1;                         // نوبت قسط
                            $qest->amount = $data['qestmablagh'][$i];         // qest amount
                            $qest->status = '0';                              // not paid
                            $qest->save();
                        }

                    }
                }
            }
            DB::commit();
            return true;

        } else {
            DB::rollBack();
            return false;
        }


        // end of method
    }


    // reserve by customer
    public function customReserve($data)
    {

        //@TODO:  dargah pardakht ezafe beshe be logic
        //---- initial setup
        if($data['charge'] == null) {
            $data['charge'] = 0;
        }
        $paid_amount = 0;     // total amount that customer paid (include naqd and wallet or dargah)

        //---- begin transaction
        DB::beginTransaction();

        $order = new Order();
        $order->user_id = $data['user_id'];
        $order->karshenas_id = Auth::id();
        $order->takht_id = $data['takht_id'];
        $order->raft = $data['raft'];
        $order->bargasht = $data['bargasht'];
        $order->days = $data['days'];
        $order->month = $data['month'];
        $order->order_number = substr(time () . uniqid(), 0, 18);   // generate unique random number
        $order->status_order_id = Statusorder::ACTIVE;
        $order->reservetype_id = $data['reservetype_id'];


        // if wallet mojoodi is greater than `finally price`, then `finally price` become zero
        if($data['finallyPrice'] == '0' && $data['charge'] == '1') {    // only wallet

            // wallet transaction
            $order->finanicial_status_order = 'paid';
            $order->paid_way = 'wallet';
            $paid_amount = floatval($data['finallyPrice']);

        } elseif($data['paytype'] == 'dargah' && $data['charge'] == '1') {      // dargah + wallet

            $order->finanicial_status_order = 'paid';
            $order->paid_way = 'dargah_wallet';
            $paid_amount = floatval($data['finallyPrice']);

        } elseif($data['paytype'] == 'dargah' && $data['charge'] == '0') {      // dargah

            $order->finanicial_status_order = 'paid';
            $order->paid_way = 'dargah';
            $paid_amount = floatval($data['finallyPrice']);

        }


        $order->takht_move = '0';
        $order->time_move = '0';
        $order->total_price_before_takhfif_wallet = $data['totalPrice'];    // total price before after applying takhfif and wallet
        $order->total_price_after_takhfif_wallet = $data['finallyPrice'];   // finally price after applying takhfif and wallet
        $order->takhfif = $data['takhfif'];

        if ($order->save()) {

            // user total statusmali
            $usertotalstatusmaliService = new Usertotalstatusmali();
            $usertotalstatusmaliService->user_id = $data['user_id'];
            $usertotalstatusmaliService->order_id = $order->id;
            $usertotalstatusmaliService->total_bedehi = $usertotalstatusmaliService->total_bedehi + $data['finallyPrice'];
            $usertotalstatusmaliService->save();


            // order statusmali
            // more info: if payment is by only wallet, then $data['finallyPrice'] is zero
            $statusMali = new Statusmali();
            $statusMali->id = $order->id;
            $statusMali->totalprice = $data['finallyPrice'];
            $statusMali->bestankar = $paid_amount;   // how much customer paid
            $statusMali->maande =  floatval($data['finallyPrice'] - $paid_amount) < 0 ? 0 :  floatval($data['finallyPrice'] - $paid_amount);
            $statusMali->save();



            // update wallet mojoodi and related tables, if wallet is used for payment
            if($data['charge'] == '1') {

                $this->walletService->walletDecreaseForReservation((int)$data['user_id'], (int)$data['walletAmountUsedInput'],$order->id, 'کسر از کیف پول بابت پرداخت بخشی از هزینه رزرو');
            }


            // if $data['finallyPrice'] is not zero
            if( $data['finallyPrice'] > 0 ) {

                // ثبت لیست اقساط
                if ($data['paytype'] == 'q') {   // qest pay
                    if (count($data['qesttarikh']) != 0) {

                        for ($i = 0; $i < count($data['qesttarikh']); $i++) {
                            $qest = new Qest();
                            $qest->order_id = $order->id;
                            $qest->tarikh_mogharar = $data['qesttarikh'][$i];
                            $qest->nobate_qest = $i + 1;                         // نوبت قسط
                            $qest->amount = $data['qestmablagh'][$i];         // qest amount
                            $qest->status = '0';                              // not paid
                            $qest->save();
                        }
                    }
                }
            }


            DB::commit();
            return true;
        } else {
            DB::rollBack();
            return false;
        }

    }



    public function getAllreservetype()
    {
        $reserves = Reservetype::all();
        return count($reserves) > 0 ? $reserves : 'notfound';
    }


    public function getOrderByTakht($id)
    {
        $orders = Order::with('takht')->orderByDesc('id')->where('status_order_id', 1)->where('takht_id', $id)->get();

        foreach ($orders as $order) {
            $splitRaft = explode('-', $order->raft);
            $splitBargasht = explode('-', $order->bargasht);
            $order['jalaliRaft'] = Verta::create($splitRaft[0], $splitRaft[1], $splitRaft[2], 00, 00, 00)->formatJalaliDate();
            $order['jalaliBargasht'] = Verta::create($splitBargasht[0], $splitBargasht[1], $splitBargasht[2], 00, 00, 00)->formatJalaliDate();
            $order['fullName'] = $order->user->name . ' ' . $order->user->family;
        }

        return count($orders) > 0 ? $orders : 'notfound';
    }


    public function getOrderByUser($id)
    {
        $orders = Order::with('takht')->orderByDesc('id')->where('status_order_id', 1)->where('user_id', $id)->get();

        foreach ($orders as $order) {
            $order['pansion'] = $order->takht->room->pansion->name;
            $order['takhtnumber'] = $order->takht->takhtnumber;
              $order['mobilecode'] = $order->user->mobilecode;
                $order['ncode'] = $order->user->ncode;
            $order['roomnumber'] = $order->takht->room->roomnumber;
            $order['vaziat'] = $order->statusOrder->title;
            $order['price'] = $order->takht->price;
            if ($order->move == '1') {
                $order['jabjayi'] = 'بله';
            } elseif ($order->move == '0') {
                $order['jabjayi'] = 'خیر';
            }
            $order['karshenasName'] = $order->karshenas->name . ' ' . $order->karshenas->family;
            $order['fullname'] = $order->user->name . ' ' . $order->user->family;
            $splitRaft = explode('-', $order->raft);
            $splitBargasht = explode('-', $order->bargasht);
            $order['jalaliRaft'] = Verta::create($splitRaft[0], $splitRaft[1], $splitRaft[2], 00, 00, 00)->formatJalaliDate();
            $order['jalaliBargasht'] = Verta::create($splitBargasht[0], $splitBargasht[1], $splitBargasht[2], 00, 00, 00)->formatJalaliDate();
        }
        return count($orders) > 0 ? $orders : 'notfound';
    }



//    public function getOrderByUserFirst($id)
//    {
//        $order = Order::with('takht')->orderByDesc('id')->where('status_order_id', 1)->where('user_id', $id)->first();
//
//        if(! $order)
//            return 'notfound';
//
//
//        if (count($order->statusmali) != 0) {
//
//            $order['bedehkar'] = $order->statusmali[0]->bedehkar - $order->statusmali[0]->bestankar;
//            $order['totalprice'] = $order->statusmali[0]->totalprice;
//            $order['takhfif'] = $order->statusmali[0]->takhfif;
//
//            if (count($order->statusmali[0]->qest) != 0) {
//
//                $order['aqsat'] = $order->statusmali[0]->qest;
//                $recenQest = 0;
//                $pastTarikh = [];
//
//                foreach ($order->aqsat as $key => $qest) {
//
//                    // یافتن نزدیک قسط
//                    if (strtotime($qest->tarikh) < $recenQest && $recenQest != 0 && $qest->status != 1) {
//                        $recenQest = strtotime($qest->tarikh);
//                        $order['recentQest'] = $qest;
//                        $splitTarikh = explode('-', $qest->tarikh);
//
//                        $order['recentQest']['jalaliTarikh'] = Verta::create($splitTarikh[0], $splitTarikh[1], $splitTarikh[2], 00, 00, 00)->formatJalaliDate();
//                    } elseif ($recenQest == 0 && $qest->status != 1) {
//                        $recenQest = strtotime($qest->tarikh);
//                        $order['recentQest'] = $qest;
//
//                        $splitTarikh = explode('-', $qest->tarikh);
//                        $order['recentQest']['jalaliTarikh'] = Verta::create($splitTarikh[0], $splitTarikh[1], $splitTarikh[2], 00, 00, 00)->formatJalaliDate();
//                    }
//
//
//                    // qest lists that are not paid
//                    if (strtotime($qest->tarikh) < time() && $qest->status != 1) {
//                        $splitTarikh = explode('-', $qest->tarikh);
//
//                        $qest['jalaliTarikh'] = Verta::create($splitTarikh[0], $splitTarikh[1], $splitTarikh[2], 00, 00, 00)->formatJalaliDate();
//                        array_push($pastTarikh, $qest);
//                    }
//
//
//                    $splitPaytime = explode('-', $qest->tarikh);
//                    $order['aqsat'][$key]['paytime'] = Verta::create($splitPaytime[0], $splitPaytime[1], $splitPaytime[2], 00, 00, 00)->formatJalaliDate();
//                    if ($qest->paytarikh != null) {
//                        $splitPaytarikh = explode('-', Date::create($qest->paytarikh)->toDateString());
//                        $order['aqsat'][$key]['pardakhti'] = Verta::create($splitPaytarikh[0], $splitPaytarikh[1], $splitPaytarikh[2], 00, 00, 00)->formatJalaliDate();
//                    }
//                    if ($qest->status == '0') {
//                        $order['aqsat'][$key]['vaziat'] = 'پرداخت نشده';
//                    } elseif ($qest->status == '1') {
//                        $order['aqsat'][$key]['vaziat'] = 'پرداخت شده';
//                    }
//                }
//
//                $order['pastTarikh'] = $pastTarikh;
//
//
//            } elseif ($order->statusmali[0]->naqdtype != null) {
//
//                $order['naqditype'] = $order->statusmali[0]->naqdtype;
//                foreach ($order->naqditype as $naqd) {
//                    $naqd['mablagh'] = $naqd->pivot->mablagh;
//                }
//            }
//            if ($order->statusmali[0]->status == 'o') {
//                $order['statusmalis'] = 'باز';
//            } elseif ($order->statusmali[0]->status == 'd') {
//                $order['statusmalis'] = 'تسویه شده';
//            } elseif ($order->statusmali[0]->status == 'c') {
//                $order['statusmalis'] = 'کنسل شده';
//            }
//        }
//        $order['pansionname'] = $order->takht->room->pansion->name;
//        $order['takhtnumber'] = $order->takht->takhtnumber;
//          $order['mobilecode'] = $order->user->mobilecode;
//                $order['ncode'] = $order->user->ncode;
//        $order['roomnumber'] = $order->takht->room->roomnumber;
//        $order['vaziat'] = $order->statusOrder->title;
//        $order['price'] = $order->takht->price;
//        if ($order->move == '1') {
//            $order['jabjayi'] = 'بله';
//        } elseif ($order->move == '0') {
//            $order['jabjayi'] = 'خیر';
//        }
//        $order['karshenasName'] = $order->karshenas->name . ' ' . $order->karshenas->family;
//        $order['fullname'] = $order->user->name . ' ' . $order->user->family;
//        $splitRaft = explode('-', $order->raft);
//        $splitBargasht = explode('-', $order->bargasht);
//        $order['jalaliRaft'] = Verta::create($splitRaft[0], $splitRaft[1], $splitRaft[2], 00, 00, 00)->formatJalaliDate();
//        $order['jalaliBargasht'] = Verta::create($splitBargasht[0], $splitBargasht[1], $splitBargasht[2], 00, 00, 00)->formatJalaliDate();
//        $order['raftjalali'] = Verta::create($splitRaft[0], $splitRaft[1], $splitRaft[2], 00, 00, 00)->format('Y/m/d');
//        $order['bargashtjalali'] = Verta::create($splitBargasht[0], $splitBargasht[1], $splitBargasht[2], 00, 00, 00)->format('Y/m/d');
//
//        return isset($order) > 0 ? $order : 'notfound';
//    }



    public function getAllOrderByUser($id)
    {
        $orders = Order::with('takht')->orderByDesc('id')->where('user_id', $id)->get();

        foreach ($orders as $order) {
            $order['pansion'] = $order->takht->room->pansion->name;
            $order['takhtnumber'] = $order->takht->takhtnumber;
              $order['mobilecode'] = $order->user->mobilecode;
                $order['ncode'] = $order->user->ncode;
            $order['roomnumber'] = $order->takht->room->roomnumber;
            $order['vaziat'] = $order->statusOrder->title;
            $order['price'] = $order->takht->price;
            if ($order->move == '1') {
                $order['jabjayi'] = 'بله';
            } elseif ($order->move == '0') {
                $order['jabjayi'] = 'خیر';
            }
            $order['karshenasName'] = $order->karshenas->name . ' ' . $order->karshenas->family;
            $order['fullname'] = $order->user->name . ' ' . $order->user->family;
            $splitRaft = explode('-', $order->raft);
            $splitBargasht = explode('-', $order->bargasht);
            $order['jalaliRaft'] = Verta::create($splitRaft[0], $splitRaft[1], $splitRaft[2], 00, 00, 00)->formatJalaliDate();
            $order['jalaliBargasht'] = Verta::create($splitBargasht[0], $splitBargasht[1], $splitBargasht[2], 00, 00, 00)->formatJalaliDate();
            $order['raftjalali'] = Verta::create($splitRaft[0], $splitRaft[1], $splitRaft[2], 00, 00, 00)->format('Y/m/d');
            $order['bargashtjalali'] = Verta::create($splitBargasht[0], $splitBargasht[1], $splitBargasht[2], 00, 00, 00)->format('Y/m/d');
        }
        return count($orders) > 0 ? $orders : 'notfound';
    }


    public function deleteOrderById($id,$fish_jarime,$fish_bazgasht_vajh,$priceTrans,$jarimeh,$title,$pay_type)
    {

        // if jarime value is empty, then jarime=0
        if (! $jarimeh) {
            $jarimeh = 0;
        }


        DB::beginTransaction();
        $order = Order::find($id);
        $order->status_order_id = 4;    // order is cancelled
        $order->save();


        // change statusmali.status to 'c' : means this order is cancelled
        $statusmali = Statusmali::where('order_id', $order->id)->first();   // get related statusmali to this order
        $statusmali->status = 'c';    //order status is cancelled => 'c'
        $statusmali->save();


        // if order paytype is qest then change all qests status to -1
        if($statusmali->paytype == 'q') {
            $qests = Qest::where('statusmali_id', $statusmali->id)->update(['status'=>'-1']);
        }


        //================= there is any Jarime?
        if ($jarimeh > 0) {

            // save jarime amount to this table
            $jarime = new Jarime();
            $jarime->order_id = $order->id;
            $jarime->user_id = $order->user_id;
            $jarime->karshenas_id = Auth::id();         // who saved this record
            $jarime->title = $title;                   // description for this jarime
            $jarime->amount = $jarimeh;               // amount of jarime
            $jarime->tarikh = date('Y-m-d');
            $jarime->save();

            // create new transaction for this order
            $transaction = new Transaction();
            $transaction->order_id = $order->id;
            $transaction->user_id = $order->user_id;
            $transaction->jarimeh = $jarimeh;


            if($pay_type == 'naqd') {            // jarime is paid based on naqdi

                $transaction->transactiontype_id = Transactiontype::CANCEL_KASR_VAJH;     // kasre mablagh baabate canceli

                // save fish path
                // fish is only in 'naqd' mod.
                // pay from wallet mode has no fish to upload
                if($fish_jarime) {
                    $filename = $fish_jarime->getClientOriginalName();
                    $path = 'storage/images/fish/' . $filename;
                    $fish_jarime->storeAs('public/images/fish/', $filename);
                    $transaction->fish = $path;
                }


            } elseif($pay_type == 'wallet') { // jarime pay type is based on wallet
                $wallet= Wallet::where('user_id', $order->user_id)->first();
                $wallet_amount = $wallet->bedehkar;    // get bedehkar amount of wallet

                // check if wallet amount is greater than jarime amount then allow to proceed
                if($wallet_amount > $jarimeh) {
                   $wallet->bedehkar = $wallet_amount + $jarimeh;   // decrease wallet bedehkar
                   $wallet->save();
                } else {
                    DB::rollBack();
                    return 'not enough amount in wallet';
                }

                $transaction->transactiontype_id = Transactiontype::KASR_AZ_WALLET;     // pardakht = 8
            }

            $transaction->save();
        }
        //=================


        //================= check order bedehkar-bestankar values to return vajh
        if($priceTrans > 0) {   //should return any vajh to customer?
            if($priceTrans == $statusmali->bestankar - $jarimeh) {
                // create new transaction for returning vajh
                $transaction = new Transaction();
                $transaction->order_id = $order->id;
                $transaction->user_id = $order->user_id;
                $transaction->price = $priceTrans;
                $transaction->transactiontype_id = Transactiontype::BAZGASHT_VAJH;


                if($fish_bazgasht_vajh) {  // fish image upload for returning vajh
                    $filename = $fish_bazgasht_vajh->getClientOriginalName();
                    $path = 'storage/images/fish/' . $filename;
                    $fish_bazgasht_vajh->storeAs('public/images/fish/', $filename);
                    $transaction->fish = $path;
                }

                $transaction->save();

            } else {
                DB::rollBack();
                return 'returning price is not logical';
            }
        }

        DB::commit();
        return 'ok';
        //=================
    }




    public function deleteOrderPassById($orderId, $reservetype, $takhtId, $userId, $raft, $bargasht, $days, $price, $takhfif, $paytype, $qesttarikh, $totalPrice, $finallyPrice, $perMonth, $permounth, $mounth, $bestankar, $naqdtypeTitle, $naqdtypeMablagh, $fish)
    {

        $orders = Order::find($orderId);
//        try {

        DB::beginTransaction();
        if ($finallyPrice != 0) {
            $bestankar = $bestankar - $finallyPrice;
            if ($bestankar < 0) {
                $bestankar = 0;
            }
        }

        $changeStatusmali = Statusmali::where('order_id', $orders->id)->first();
        $changeStatusmali->status = 'c';
        $changeStatusmali->save();
        $orders->status_order_id = 4;
        $orders->canceled_at = Date::now();
        $orders->save();
        $order = new Order();
        $order->takht_id = $takhtId;
        $order->user_id = $userId;
        $order->reservetype_id = $reservetype;
        $order->raft = $raft;
        $order->days = $days;
        $order->permonth = $permounth;
        $order->month = $mounth;
        $order->move = '0';

        $order->status_order_id = 1;
        $order->karshenas_id = Auth::id();
        $order->bargasht = $bargasht;
        $contractNum = str_replace('-', '', Verta(Date::now())->formatDate()) . rand(1000000000, 9999999999);
        $conractExist = Order::where('order_number', $contractNum)->exists();
        if ($conractExist) {
            $contractNum = str_replace('-', '', Verta(Date::now())->formatDate()) . rand(1000000000, 9999999999);
            $conractExist = Order::where('order_number', $contractNum)->exists();
        }
        if ($conractExist == false) {
            $order->order_number = $contractNum;
        } else {
            return "contractExist";
        }
        if ($order->save()) {
            $statusMali = new Statusmali();
            $statusMali->order_id = $order->id;
            $statusMali->bedehkar = $finallyPrice;
            $statusMali->bestankar = 0;
            $statusMali->takhfif = $takhfif;
            $statusMali->totalprice = $totalPrice;
            $statusMali->status = 'd';
            $statusMali->paytype = $paytype;
            $statusMali->save();
            if (count($qesttarikh) != 0) {
                for ($i = 0; $i < count($qesttarikh); $i++) {
                    $qest = new Qest();
                    $qest->statusmali_id = $statusMali->id;
                    $qest->tarikh = $qesttarikh[$i];
                    $qest->amount = $perMonth;
                    $qest->status = 0;
                    $qest->save();
                }
                $naqdtypeTitle = [];

            }
            if (count($naqdtypeTitle) != 0) {
                $statusMali->bestankar = $finallyPrice;
                $statusMali->status = 'd';
                $statusMali->save();
                for ($i = 0; $i < count($naqdtypeTitle); $i++) {
                    $naqdExist = Naqdtype::where('title', $naqdtypeTitle[$i])->exists();
                    $naqdFirst = Naqdtype::where('title', $naqdtypeTitle[$i])->first();
                    if ($finallyPrice != 0) {
                    if ($naqdExist) {
                        if ($naqdtypeMablagh[$i] != null) {
                            $statusMali->naqdtype()->attach($naqdtypeTitle[$i], ['mablagh' => $naqdtypeMablagh[$i], 'path' => $fish[$i]]);
                            $transaction = new Transaction();
                            $transaction->price = $naqdtypeMablagh[$i];
                            $transaction->order_id = $order->id;
                            $transaction->user_id = $order->user_id;
                            if ($fish != null) {
                                $filename = $fish[$i]->getClientOriginalName();
                                $path = 'storage/images/fish/' . $filename;
                                $fish[$i]->storeAs('public/images/fish/', $filename);
                                $transaction->fish = $path;
                            }
                            $transaction->transactiontype_id = 1;
                            $transaction->save();
                        } else {
                            $statusMali->naqdtype()->attach($naqdtypeTitle[$i], ['mablagh' => '0']);
                        }

                    } else {

                        $statusMali->naqdtype()->attach($naqdtypeTitle[$i], ['mablagh' => $naqdtypeMablagh[$i], 'path' => $fish[$i]]);
                    }
                    }


                }

                $transactionscan = new Transaction();
                if ($finallyPrice == 0) {
                    $transactionscan->price = $totalPrice;
                } else {
                    $transactionscan->price = $finallyPrice;
                }

                $transactionscan->order_id = $order->id;
                $transactionscan->transactiontype_id = 5;
                $transactionscan->save();

                $transactions = new Transaction();
                $transactions->price = $bestankar;
                $transactions->order_id = $order->id;
                $transactions->transactiontype_id = 4;
                $transactions->save();
            }
            $wallet = Wallet::where('user_id', $orders->user_id)->first();

            $wallet->bedehkar = $wallet->bedehkar - (intval($orders->statusmali[0]->bedehkar) - intval($orders->statusmali[0]->bestankar));

            $wallet->bedehkar = $wallet->bedehkar + intval($statusMali->bedehkar) - intval($statusMali->bestankar) - $bestankar;

            $wallet->save();
            DB::commit();
            return 'ok';
        }
        DB::commit();
        return 'ok';
//        }
//        catch (\Exception $exception){
//            DB::rollBack();
//            return 'notfound';
//        }
    }


    public function ekhrajOrderPassById($orderId, $reservetype, $takhtId, $userId, $raft, $bargasht, $days, $price, $takhfif, $paytype, $qesttarikh, $totalPrice, $finallyPrice, $perMonth, $permounth, $mounth, $bestankar, $naqdtypeTitle, $naqdtypeMablagh, $fish, $editor)
    {

        $orders = Order::find($orderId);
        try {

            DB::beginTransaction();
            if ($finallyPrice != 0) {
                $bestankar = $bestankar - $finallyPrice;
                if ($bestankar < 0) {
                    $bestankar = 0;
                }
            }


            $changeStatusmali = Statusmali::where('order_id', $orders->id)->first();
            $changeStatusmali->status = 'c';
            $changeStatusmali->save();
            $orders->status_order_id = 5;
            $orders->ellat = $editor;
            $orders->canceled_at = Date::now();
            $orders->save();
            $order = new Order();
            $order->takht_id = $takhtId;
            $order->user_id = $userId;
            $order->reservetype_id = 1;
            $order->raft = $raft;
            $order->days = $days;
            $order->permonth = $permounth;
            $order->month = $mounth;
            $order->move = '0';

            $order->status_order_id = 1;
            $order->karshenas_id = Auth::id();
            $order->bargasht = $bargasht;
            $contractNum = str_replace('-', '', Verta(Date::now())->formatDate()) . rand(1000000000, 9999999999);
            $conractExist = Order::where('order_number', $contractNum)->exists();
            if ($conractExist) {
                $contractNum = str_replace('-', '', Verta(Date::now())->formatDate()) . rand(1000000000, 9999999999);
                $conractExist = Order::where('order_number', $contractNum)->exists();
            }
            if ($conractExist == false) {
                $order->order_number = $contractNum;
            } else {
                return "contractExist";
            }
            if ($order->save()) {
                $statusMali = new Statusmali();
                $statusMali->order_id = $order->id;
                $statusMali->bedehkar = $finallyPrice;
                $statusMali->bestankar = 0;
                $statusMali->takhfif = $takhfif;
                $statusMali->totalprice = $totalPrice;
                $statusMali->status = 'd';
                $statusMali->paytype = $paytype;
                $statusMali->save();
                if (count($qesttarikh) != 0) {
                    for ($i = 0; $i < count($qesttarikh); $i++) {
                        $qest = new Qest();
                        $qest->statusmali_id = $statusMali->id;
                        $qest->tarikh = $qesttarikh[$i];
                        $qest->amount = $perMonth;
                        $qest->status = 0;
                        $qest->save();
                    }
                    $naqdtypeTitle = [];

                }
                if (count($naqdtypeTitle) != 0) {
                    $statusMali->bestankar = $finallyPrice;
                    $statusMali->status = 'd';
                    $statusMali->save();
                    for ($i = 0; $i < count($naqdtypeTitle); $i++) {
                        $naqdExist = Naqdtype::where('title', $naqdtypeTitle[$i])->exists();
                        $naqdFirst = Naqdtype::where('title', $naqdtypeTitle[$i])->first();
                        if ($finallyPrice != 0) {
                        if ($naqdExist) {
                            if ($naqdtypeMablagh[$i] != null) {
                                $statusMali->naqdtype()->attach($naqdtypeTitle[$i], ['mablagh' => $naqdtypeMablagh[$i], 'path' => $fish[$i]]);
                                $transaction = new Transaction();
                                $transaction->price = $naqdtypeMablagh[$i];
                                $transaction->order_id = $order->id;
                                $transaction->user_id = $order->user_id;
                                if ($fish != null) {
                                    $filename = $fish[$i]->getClientOriginalName();
                                    $path = 'storage/images/fish/' . $filename;
                                    $fish[$i]->storeAs('public/images/fish/', $filename);
                                    $transaction->fish = $path;
                                }
                                $transaction->transactiontype_id = 1;
                                $transaction->save();
                            }

                        } else {

                            $statusMali->naqdtype()->attach($naqdtypeTitle[$i], ['mablagh' => $naqdtypeMablagh[$i], 'path' => $fish[$i]]);
                        }

                    }
                    }
                    $transactionscan = new Transaction();
                    if ($finallyPrice == 0) {
                        $transactionscan->price = $totalPrice;
                    } else {
                        $transactionscan->price = $finallyPrice;
                    }

                    $transactionscan->order_id = $order->id;
                    $transactionscan->transactiontype_id = 5;
                    $transactionscan->save();

                    $transactions = new Transaction();
                    $transactions->price = $bestankar;
                    $transactions->order_id = $order->id;
                    $transactions->transactiontype_id = 4;
                    $transactions->save();

                }
                $wallet = Wallet::where('user_id', $orders->user_id)->first();

                $wallet->bedehkar = $wallet->bedehkar - (intval($orders->statusmali[0]->bedehkar) - intval($orders->statusmali[0]->bestankar));

                $wallet->bedehkar = $wallet->bedehkar + intval($statusMali->bedehkar) - intval($statusMali->bestankar) - $bestankar;

                $wallet->save();
                DB::commit();
                return 'ok';
            }
            DB::commit();
            return 'ok';
        } catch (\Exception $exception) {
            DB::rollBack();
            return 'notfound';
        }
    }

    public function khorujOrderPassById($orderId, $reservetype, $takhtId, $userId, $raft, $bargasht, $days, $price, $takhfif, $paytype, $qesttarikh, $totalPrice, $finallyPrice, $perMonth, $permounth, $mounth, $bestankar, $naqdtypeTitle, $naqdtypeMablagh, $fish)
    {

        $orders = Order::find($orderId);
        try {

            DB::beginTransaction();
            if ($finallyPrice != 0) {
                $bestankar = $bestankar - $finallyPrice;
                if ($bestankar < 0) {
                    $bestankar = 0;
                }
            }


            $changeStatusmali = Statusmali::where('order_id', $orders->id)->first();
            $changeStatusmali->status = 'c';
            $changeStatusmali->save();
            $orders->status_order_id = 6;
            $orders->canceled_at = Date::now();
            $orders->save();
            $order = new Order();
            $order->takht_id = $takhtId;
            $order->user_id = $userId;
            $order->reservetype_id = $reservetype;
            $order->raft = $raft;
            $order->days = $days;
            $order->permonth = $permounth;
            $order->month = $mounth;
            $order->move = '0';

            $order->status_order_id = 1;
            $order->karshenas_id = Auth::id();
            $order->bargasht = $bargasht;
            $contractNum = str_replace('-', '', Verta(Date::now())->formatDate()) . rand(1000000000, 9999999999);
            $conractExist = Order::where('order_number', $contractNum)->exists();
            if ($conractExist) {
                $contractNum = str_replace('-', '', Verta(Date::now())->formatDate()) . rand(1000000000, 9999999999);
                $conractExist = Order::where('order_number', $contractNum)->exists();
            }
            if ($conractExist == false) {
                $order->order_number = $contractNum;
            } else {
                return "contractExist";
            }
            if ($order->save()) {

                $statusMali = new Statusmali();
                $statusMali->order_id = $order->id;
                $statusMali->bedehkar = $finallyPrice;
                $statusMali->bestankar = 0;
                $statusMali->takhfif = $takhfif;
                $statusMali->totalprice = $totalPrice;
                $statusMali->status = 'd';
                $statusMali->paytype = $paytype;
                $statusMali->save();
                if (count($qesttarikh) != 0) {
                    for ($i = 0; $i < count($qesttarikh); $i++) {
                        $qest = new Qest();
                        $qest->statusmali_id = $statusMali->id;
                        $qest->tarikh = $qesttarikh[$i];
                        $qest->amount = $perMonth;
                        $qest->status = 0;
                        $qest->save();

                    }
                    $naqdtypeTitle = [];
                }
                if (count($naqdtypeTitle) != 0) {
                    $statusMali->bestankar = $finallyPrice;
                    $statusMali->status = 'd';
                    $statusMali->save();
                    for ($i = 0; $i < count($naqdtypeTitle); $i++) {
                        $naqdExist = Naqdtype::where('title', $naqdtypeTitle[$i])->exists();
                        $naqdFirst = Naqdtype::where('title', $naqdtypeTitle[$i])->first();
                        if ($finallyPrice != 0) {
                        if ($naqdExist) {
                            if ($naqdtypeMablagh[$i] != null) {
                                $statusMali->naqdtype()->attach($naqdtypeTitle[$i], ['mablagh' => $naqdtypeMablagh[$i], 'path' => $fish[$i]]);
                                $transaction = new Transaction();
                                $transaction->price = $naqdtypeMablagh[$i];
                                $transaction->order_id = $order->id;
                                $transaction->user_id = $order->user_id;
                                if ($fish != null) {
                                    $filename = $fish[$i]->getClientOriginalName();
                                    $path = 'storage/images/fish/' . $filename;
                                    $fish[$i]->storeAs('public/images/fish/', $filename);
                                    $transaction->fish = $path;
                                }
                                $transaction->transactiontype_id = 1;
                                $transaction->save();
                            }

                        } else {

                            $statusMali->naqdtype()->attach($naqdtypeTitle[$i], ['mablagh' => $naqdtypeMablagh[$i], 'path' => $fish[$i]]);
                        }

                    }
                    }
                    $transactionscan = new Transaction();
                    if ($finallyPrice == 0) {
                        $transactionscan->price = $totalPrice;
                    } else {
                        $transactionscan->price = $finallyPrice;
                    }

                    $transactionscan->order_id = $order->id;
                    $transactionscan->transactiontype_id = 5;
                    $transactionscan->save();

                    $transactions = new Transaction();
                    $transactions->price = $bestankar;
                    $transactions->order_id = $order->id;
                    $transactions->transactiontype_id = 4;
                    $transactions->save();

                }
                $wallet = Wallet::where('user_id', $orders->user_id)->first();

                $wallet->bedehkar = $wallet->bedehkar - (intval($orders->statusmali[0]->bedehkar) - intval($orders->statusmali[0]->bestankar));

                $wallet->bedehkar = $wallet->bedehkar + intval($statusMali->bedehkar) - intval($statusMali->bestankar) - $bestankar;

                $wallet->save();
                DB::commit();
                return 'ok';
            }
            DB::commit();
            return 'ok';
        } catch (\Exception $exception) {
            DB::rollBack();
            return 'notfound';
        }
    }


    public function moveOrderPassById($orderId, $reservetype, $prereservetype, $takhtId, $userId, $raft, $bargasht, $days, $daysdovom, $bestankar, $totalsdovom, $price, $takhfif, $paytype, $qesttarikh, $totalPrice, $finallyPrice, $perMonth, $permounth, $mounth, $monthDovom, $naqdtypeMablagh, $naqdtypeTitle, $fish)
    {
        $orders = Order::find($orderId);
//        try {

        DB::beginTransaction();
        if ($qesttarikh==null){
            $qesttarikh=[];
        }

        if ($finallyPrice != 0) {
            $bestankar = $bestankar - $finallyPrice;
            if ($bestankar < 0) {
                $bestankar = 0;
            }
        }


        $changeStatusmali = Statusmali::where('order_id', $orders->id)->first();
        $changeStatusmali->status = 'c';
        $changeStatusmali->save();
//            $orders->canceled_at=Date::now();
        $orders->status_order_id = 4;
        $orders->save();

        $orderDovom = new Order();
        $orderDovom->takht_id = $orders->takht_id;
        $orderDovom->user_id = $orders->user_id;
        $orderDovom->reservetype_id = $prereservetype;
        $orderDovom->raft = $orders->raft;
        $orderDovom->days = $daysdovom;
        $orderDovom->month = $monthDovom;
        $orderDovom->move = '0';
        $orderDovom->status_order_id = 1;
        $orderDovom->karshenas_id = Auth::id();
        $orderDovom->bargasht = $raft;
        $contractNum = str_replace('-', '', Verta(Date::now())->formatDate()) . rand(1000000000, 9999999999);
        $conractExist = Order::where('order_number', $contractNum)->exists();
        if ($conractExist) {
            $contractNum = str_replace('-', '', Verta(Date::now())->formatDate()) . rand(1000000000, 9999999999);
            $conractExist = Order::where('order_number', $contractNum)->exists();
        }
        if ($conractExist == false) {
            $orderDovom->order_number = $contractNum;
        } else {
            return "contractExist";
        }
        if ($orderDovom->save()) {

            $statusMaliDovom = new Statusmali();
            $statusMaliDovom->order_id = $orderDovom->id;
            $statusMaliDovom->bedehkar = $totalsdovom;
            $statusMaliDovom->bestankar = 0;
            $statusMaliDovom->takhfif = '0';
            $statusMaliDovom->totalprice = intval($daysdovom) * intval($orders->takht->price);
            $statusMaliDovom->status = 'd';
            $statusMaliDovom->paytype = 'n';
            $statusMaliDovom->save();
        }
        $order = new Order();
        $order->takht_id = $takhtId;
        $order->user_id = $orders->user_id;
        $order->reservetype_id = $reservetype;
        $order->raft = $raft;
        $order->days = $days;
        $order->month = $mounth;
        $order->permonth = $permounth;
        $order->move = '0';
        $order->status_order_id = 1;
        $order->karshenas_id = Auth::id();
        $order->bargasht = $bargasht;
        $contractNum = str_replace('-', '', Verta(Date::now())->formatDate()) . rand(1000000000, 9999999999);
        $conractExist = Order::where('order_number', $contractNum)->exists();
        if ($conractExist) {
            $contractNum = str_replace('-', '', Verta(Date::now())->formatDate()) . rand(1000000000, 9999999999);
            $conractExist = Order::where('order_number', $contractNum)->exists();
        }
        if ($conractExist == false) {
            $order->order_number = $contractNum;
        } else {
            return "contractExist";
        }
        if ($order->save()) {

            $orders->order_id = $order->id;
            $orders->move = '1';
            $orders->canceled_at = Date::now();
            $orders->moved_at = $raft;
            $orders->status_order_id = '4';
            $orders->save();
            $statusMali = new Statusmali();
            $statusMali->order_id = $order->id;
            $statusMali->bedehkar = $finallyPrice;

            $statusMali->takhfif = $takhfif;
            $statusMali->totalprice = $totalPrice;
            $statusMali->status = 'o';
            $statusMali->paytype = $paytype;

            if (count($qesttarikh) != 0) {
                $statusMali->bestankar = 0;
                $statusMali->save();
                for ($i = 0; $i < count($qesttarikh); $i++) {
                    $qest = new Qest();
                    $qest->statusmali_id = $statusMali->id;
                    $qest->tarikh = $qesttarikh[$i];
                    $qest->amount = $perMonth;
                    $qest->status = '0';
                    $qest->save();
                }

                $naqdtypeTitle = [];
            }

            if (count($naqdtypeTitle) != 0) {
                $statusMali->bestankar = $finallyPrice;
                $statusMali->status = 'd';
                $statusMali->save();
                for ($i = 0; $i < count($naqdtypeTitle); $i++) {
                    $naqdExist = Naqdtype::where('title', $naqdtypeTitle[$i])->exists();
                    $naqdFirst = Naqdtype::where('title', $naqdtypeTitle[$i])->first();

                    if ($finallyPrice != 0) {
                        if ($naqdExist) {
                            if ($naqdtypeMablagh[$i] != null) {
                                $statusMali->naqdtype()->attach($naqdtypeTitle[$i], ['mablagh' => $naqdtypeMablagh[$i], 'path' => $fish[$i]]);
                                $transaction = new Transaction();
                                $transaction->price = $naqdtypeMablagh[$i];
                                $transaction->order_id = $order->id;
                                $transaction->user_id = $order->user_id;
                                if ($fish != null) {
                                    $filename = $fish[$i]->getClientOriginalName();
                                    $path = 'storage/images/fish/' . $filename;
                                    $fish[$i]->storeAs('public/images/fish/', $filename);
                                    $transaction->fish = $path;
                                }

                                $transaction->transactiontype_id = 1;
                                $transaction->save();
                            }

                        } else {

                            $statusMali->naqdtype()->attach($naqdtypeTitle[$i], ['mablagh' => $naqdtypeMablagh[$i], 'path' => $fish[$i]]);
                        }
                    }
                }

                $transactionscan = new Transaction();
                if ($finallyPrice == 0) {
                    $transactionscan->price = $totalPrice;
                } else {
                    $transactionscan->price = $finallyPrice;
                }

                $transactionscan->order_id = $order->id;
                $transactionscan->transactiontype_id = 5;
                $transactionscan->save();

                $transactions = new Transaction();
                $transactions->price = $bestankar;
                $transactions->order_id = $order->id;
                $transactions->transactiontype_id = 4;
                $transactions->save();

            }
            $wallet = Wallet::where('user_id', $orders->user_id)->first();

            $wallet->bedehkar = $wallet->bedehkar - (intval($orders->statusmali[0]->bedehkar) - intval($orders->statusmali[0]->bestankar));

            $wallet->bedehkar = $wallet->bedehkar + intval($statusMali->bedehkar) - intval($statusMali->bestankar) - $bestankar;


            DB::commit();
            return 'ok';
        }
        DB::commit();
        return $order;
//        } catch (\Exception $exception) {
//            DB::rollBack();
//            return 'notfound';
//        }
    }


    public function editOrder($id, $stauts)
    {
        $order = Order::find($id);
        $order->status_order_id = $stauts;
        if ($order->save()) {
            return 'ok';
        } else {
            return 'notfound';
        }
    }

    public function getAllNaqdtypes()
    {
        $naqdtypes = Naqdtype::all();

        return count($naqdtypes) > 0 ? $naqdtypes : 'notfound';
    }

    public function getAllNcodetype()
    {
        $ncode = Ncodetype::all();
        return count($ncode) > 0 ? $ncode : 'notfound';
    }


    public function getReserveOrderByUser()
    {

        $order = Order::with('statusmali')->orderByDesc('id')->where('user_id', Auth::id())->where('status_order_id', 1)->first();

        if (isset($order)) {
            if (count($order->statusmali) != 0) {

                $order['bedehkar'] = $order->statusmali[0]->bedehkar - $order->statusmali[0]->bestankar;
                $order['totalprice'] = $order->statusmali[0]->totalprice;
                $order['takhfif'] = $order->statusmali[0]->takhfif;
                if (count($order->statusmali[0]->qest) != 0) {


                    $order['aqsat'] = $order->statusmali[0]->qest;
                    $recenQest = 0;
                    $pastTarikh = [];

                    foreach ($order->aqsat as $key => $qest) {

                        if (strtotime($qest->tarikh) < $recenQest && $recenQest != 0 && $qest->status != 1) {
                            $recenQest = strtotime($qest->tarikh);
                            $order['recentQest'] = $qest;
                            $splitTarikh = explode('-', $qest->tarikh);

                            $order['recentQest']['jalaliTarikh'] = Verta::create($splitTarikh[0], $splitTarikh[1], $splitTarikh[2], 00, 00, 00)->formatJalaliDate();
                        } elseif ($recenQest == 0 && $qest->status != 1) {
                            $recenQest = strtotime($qest->tarikh);
                            $order['recentQest'] = $qest;

                            $splitTarikh = explode('-', $qest->tarikh);
                            $order['recentQest']['jalaliTarikh'] = Verta::create($splitTarikh[0], $splitTarikh[1], $splitTarikh[2], 00, 00, 00)->formatJalaliDate();
                        }


                        if (strtotime($qest->tarikh) < time() && $qest->status != 1) {
                            $splitTarikh = explode('-', $qest->tarikh);

                            $qest['jalaliTarikh'] = Verta::create($splitTarikh[0], $splitTarikh[1], $splitTarikh[2], 00, 00, 00)->formatJalaliDate();
                            array_push($pastTarikh, $qest);

                        }

                        $splitPaytime = explode('-', $qest->tarikh);
                        $order['aqsat'][$key]['paytime'] = Verta::create($splitPaytime[0], $splitPaytime[1], $splitPaytime[2], 00, 00, 00)->formatJalaliDate();
                        if ($qest->paytarikh != null) {
                            $splitPaytarikh = explode('-', Date::create($qest->paytarikh)->toDateString());
                            $order['aqsat'][$key]['pardakhti'] = Verta::create($splitPaytarikh[0], $splitPaytarikh[1], $splitPaytarikh[2], 00, 00, 00)->formatJalaliDate();
                        }
                        if ($qest->status == '0') {
                            $order['aqsat'][$key]['vaziat'] = 'پرداخت نشده';
                        } elseif ($qest->status == '1') {
                            $order['aqsat'][$key]['vaziat'] = 'پرداخت شده';
                        }
                    }

                    $order['pastTarikh'] = $pastTarikh;


                } elseif ($order->statusmali[0]->naqdtype != null) {

                    $order['naqditype'] = $order->statusmali[0]->naqdtype;
                    foreach ($order->naqditype as $naqd) {
                        $naqd['mablagh'] = $naqd->pivot->mablagh;
                    }
                }
                if ($order->statusmali[0]->status == 'o') {
                    $order['statusmalis'] = 'باز';
                } elseif ($order->statusmali[0]->status == 'd') {
                    $order['statusmalis'] = 'تسویه شده';
                } elseif ($order->statusmali[0]->status == 'c') {
                    $order['statusmalis'] = 'کنسل شده';
                }
            }
            $order['fullname'] = $order->user->name . ' ' . $order->user->family;
            $order['takhtnumber'] = $order->takht->takhtnumber;
              $order['mobilecode'] = $order->user->mobilecode;
                $order['ncode'] = $order->user->ncode;
            $order['roomnumber'] = $order->takht->room->roomnumber;
            $order['karshenasName'] = $order->karshenas->name . ' ' . $order->karshenas->family;
            $order['pansionname'] = $order->takht->room->pansion->name;
            $order['vaziat'] = $order->statusOrder->title;
            $order['pansionname'] = $order->takht->room->pansion->name;
            $splitRaft = explode('-', $order->raft);
            $splitBargasht = explode('-', $order->bargasht);
            $splitRaft = explode('-', $order->raft);
            $splitBargasht = explode('-', $order->bargasht);
            $order['jalaliRaft'] = Verta::create($splitRaft[0], $splitRaft[1], $splitRaft[2], 00, 00, 00)->formatJalaliDate();
            $order['jalaliBargasht'] = Verta::create($splitBargasht[0], $splitBargasht[1], $splitBargasht[2], 00, 00, 00)->formatJalaliDate();
            $order['raftjalali'] = Verta::create($splitRaft[0], $splitRaft[1], $splitRaft[2], 00, 00, 00)->format('Y/m/d');
            $order['bargashtjalali'] = Verta::create($splitBargasht[0], $splitBargasht[1], $splitBargasht[2], 00, 00, 00)->format('Y/m/d');
            if ($order->move == '1') {
                $order['jabjayi'] = 'بله';
            } elseif ($order->move == '0') {
                $order['jabjayi'] = 'خیر';
            }
        }
        return isset($order) > 0 ? $order : 'notfound';
    }

    public function setPorKhaliStatus()
    {
        $orders = Order::with('takht')->orderByDesc('id')->where('status_order_id', 1)->get();

        try {
            if (count($orders) != 0) {
                foreach ($orders as $order) {

                    $unixraft = strtotime($order->getRawOriginal('raft'));
                    $unixbargasht = strtotime($order->getRawOriginal('bargasht'));

                    DB::beginTransaction();
                    if ($unixraft <= time() && $unixbargasht > time()) {   //@beporsam
                        $takht = Takht::find($order->takht_id);
                        $takht->status = 'پر';
                        $takht->save();
                    } elseif ($unixbargasht < time()) {

                        $takht = Takht::find($order->takht_id);
                        $takht->status = 'خالی';
                        $takht->save();
                        $order->status_order_id = 2;
                        $order->save();
                    }
                }
            }
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            return false;
        }
    }


    public function getStatusmaliByOrder($id)
    {
        $status = Statusmali::with(['order', 'qest'])->where('order_id', $id)->first();


        if (count($status->qest) != 0) {
            $status['aqsat'] = $status->qest;
            foreach ($status->aqsat as $key => $qest) {
                $splitPaytime = explode('-', $qest->tarikh);
                $status['aqsat'][$key]['paytime'] = Verta::create($splitPaytime[0], $splitPaytime[1], $splitPaytime[2], 00, 00, 00)->formatJalaliDate();
                if ($qest->paytarikh != null) {
                    $splitPaytarikh = explode('-', Date::create($qest->paytarikh)->toDateString());
                    $status['aqsat'][$key]['pardakhti'] = Verta::create($splitPaytarikh[0], $splitPaytarikh[1], $splitPaytarikh[2], 00, 00, 00)->formatJalaliDate();
                }
                if ($qest->status == '0') {
                    $status['aqsat'][$key]['vaziat'] = 'پرداخت نشده';
                } elseif ($qest->status == '1') {
                    $status['aqsat'][$key]['vaziat'] = 'پرداخت شده';
                }
            }


        } elseif ($status->naqdtype != null) {

            $status['naqditype'] = $status->naqdtype;
            foreach ($status->naqditype as $naqd) {
                $naqd['mablagh'] = $naqd->pivot->mablagh;
            }
        }
        if ($status->status == 'o') {
            $status['statusmalis'] = 'باز';
        } elseif ($status->status == 'd') {
            $status['statusmalis'] = 'تسویه شده';
        } elseif ($status->status == 'c') {
            $status['statusmalis'] = 'کنسل شده';
        }

        $status['fullname'] = $status->order->user->name . ' ' . $status->order->user->family;
        $status['takhtnumber'] = $status->order->takht->takhtnumber;
        $status['roomnumber'] = $status->order->takht->room->roomnumber;
        $status['pansionname'] = $status->order->takht->room->pansion->name;
        $status['bedehi'] = intval($status->bedehkar) - intval($status->bestankar);

        return isset($status) ? $status : 'notfound';
    }


    public function getAllStatusmaliByOrder($id)
    {
        $statuses = Statusmali::with(['order', 'naqdtype'])->whereHas('order', function ($q) use ($id) {
            $q->where('user_id', $id);
        })->get();

        foreach ($statuses as $status) {
            if (count($status->qest) != 0) {
                $status['aqsat'] = $status->qest;
                foreach ($status->aqsat as $key => $qest) {
                    $splitPaytime = explode('-', $qest->tarikh);
                    $status['aqsat'][$key]['paytime'] = Verta::create($splitPaytime[0], $splitPaytime[1], $splitPaytime[2], 00, 00, 00)->formatJalaliDate();
                    if ($qest->paytarikh != null) {
                        $splitPaytarikh = explode('-', Date::create($qest->paytarikh)->toDateString());
                        $status['aqsat'][$key]['pardakhti'] = Verta::create($splitPaytarikh[0], $splitPaytarikh[1], $splitPaytarikh[2], 00, 00, 00)->formatJalaliDate();
                    }
                    if ($qest->status == '0') {
                        $status['aqsat'][$key]['vaziat'] = 'پرداخت نشده';
                    } elseif ($qest->status == '1') {
                        $status['aqsat'][$key]['vaziat'] = 'پرداخت شده';
                    }
                }


            }

            if (count($status->qest) != 0) {
                $status['aqsat'] = $status->qest;
                foreach ($status->aqsat as $key => $qest) {
                    $splitPaytime = explode('-', $qest->tarikh);
                    $status['aqsat'][$key]['paytime'] = Verta::create($splitPaytime[0], $splitPaytime[1], $splitPaytime[2], 00, 00, 00)->formatJalaliDate();
                    if ($qest->paytarikh != null) {
                        $splitPaytarikh = explode('-', Date::create($qest->paytarikh)->toDateString());
                        $status['aqsat'][$key]['pardakhti'] = Verta::create($splitPaytarikh[0], $splitPaytarikh[1], $splitPaytarikh[2], 00, 00, 00)->formatJalaliDate();
                    }
                    if ($qest->status == '0') {
                        $status['aqsat'][$key]['vaziat'] = 'پرداخت نشده';
                    } elseif ($qest->status == '1') {
                        $status['aqsat'][$key]['vaziat'] = 'پرداخت شده';
                    }
                }

            } elseif ($status->naqdtype != null) {

                $status['naqditype'] = $status->naqdtype;
                foreach ($status->naqditype as $naqd) {
                    $naqd['mablagh'] = $naqd->pivot->mablagh;
                }
            }
            if ($status->status == 'o') {
                $status['statusmalis'] = 'باز';
            } elseif ($status->status == 'd') {
                $status['statusmalis'] = 'تسویه شده';
            } elseif ($status->status == 'c') {
                $status['statusmalis'] = 'کنسل شده';
            }

            $status['fullname'] = $status->order->user->name . ' ' . $status->order->user->family;
            $status['takhtnumber'] = $status->order->takht->takhtnumber;
            $status['roomnumber'] = $status->order->takht->room->roomnumber;
            $status['pansionname'] = $status->order->takht->room->pansion->name;
            $splitRaft = explode('-', $status->order->raft);
            $splitBargasht = explode('-', $status->order->bargasht);
            $status['jalaliRaft'] = Verta::create($splitRaft[0], $splitRaft[1], $splitRaft[2], 00, 00, 00)->formatJalaliDate();
            $status['jalaliBargasht'] = Verta::create($splitBargasht[0], $splitBargasht[1], $splitBargasht[2], 00, 00, 00)->formatJalaliDate();
            $status['bedehi'] = intval($status->bedehkar) - intval($status->bestankar);

            $status['status_order'] = $status->order->statusOrder ? $status->order->statusOrder->title : '-';

        }

        return count($statuses) ? $statuses : 'notfound';
    }

    public function getAllOrderLimitOffset($limit, $offset)
    {
        $orders = Order::with(['takht', 'statusmali'])->orderByDesc('id')->limit($limit)->offset($offset)->get();
        if (count($orders) != 0) {
            foreach ($orders as $order) {
                $order['bedehkar'] = $order->statusmali[0]->bedehkar - $order->statusmali[0]->bestankar;
                $order['totalprice'] = $order->statusmali[0]->totalprice;
                $order['takhfif'] = $order->statusmali[0]->takhfif;
                if (count($order->statusmali[0]->qest) != 0) {


                    $order['aqsat'] = $order->statusmali[0]->qest;
                    $recenQest = 0;
                    $pastTarikh = [];
                    foreach ($order->aqsat as $key => $qest) {

                        if (strtotime($qest->tarikh) < $recenQest && $recenQest != 0 && $qest->status != 1) {
                            $recenQest = strtotime($qest->tarikh);
                            $order['recentQest'] = $qest;
                            $splitTarikh = explode('-', $qest->tarikh);
                            $order['recentQest']['jalaliTarikh'] = Verta::create($splitTarikh[0], $splitTarikh[1], $splitTarikh[2], 00, 00, 00)->formatJalaliDate();
                        } elseif ($recenQest == 0 && $qest->status != 1) {
                            $recenQest = strtotime($qest->tarikh);
                            $order['recentQest'] = $qest;
                            $splitTarikh = explode('-', $qest->tarikh);
                            $order['recentQest']['jalaliTarikh'] = Verta::create($splitTarikh[0], $splitTarikh[1], $splitTarikh[2], 00, 00, 00)->formatJalaliDate();
                        }
                        if (strtotime($qest->tarikh) < time() && $qest->status != 1) {
                            $splitTarikh = explode('-', $qest->tarikh);
                            $qest['jalaliTarikh'] = Verta::create($splitTarikh[0], $splitTarikh[1], $splitTarikh[2], 00, 00, 00)->formatJalaliDate();
                            array_push($pastTarikh, $qest);

                        }

                        $splitPaytime = explode('-', $qest->tarikh);
                        $order['aqsat'][$key]['paytime'] = Verta::create($splitPaytime[0], $splitPaytime[1], $splitPaytime[2], 00, 00, 00)->formatJalaliDate();
                        if ($qest->paytarikh != null) {
                            $splitPaytarikh = explode('-', Date::create($qest->paytarikh)->toDateString());
                            $order['aqsat'][$key]['pardakhti'] = Verta::create($splitPaytarikh[0], $splitPaytarikh[1], $splitPaytarikh[2], 00, 00, 00)->formatJalaliDate();
                        }
                        if ($qest->status == '0') {
                            $order['aqsat'][$key]['vaziat'] = 'پرداخت نشده';
                        } elseif ($qest->status == '1') {
                            $order['aqsat'][$key]['vaziat'] = 'پرداخت شده';
                        }
                    }

                    $order['pastTarikh'] = $pastTarikh;


                } elseif ($order->statusmali[0]->naqdtype != null) {

                    $order['naqditype'] = $order->statusmali[0]->naqdtype;
                    foreach ($order->naqditype as $naqd) {
                        $naqd['mablagh'] = $naqd->pivot->mablagh;
                    }
                }
                if ($order->statusmali[0]->status == 'o') {
                    $order['statusmalis'] = 'باز';
                } elseif ($order->statusmali[0]->status == 'd') {
                    $order['statusmalis'] = 'تسویه شده';
                } elseif ($order->statusmali[0]->status == 'c') {
                    $order['statusmalis'] = 'کنسل شده';
                }

                $order['fullname'] = $order->user->name . ' ' . $order->user->family;
                $order['takhtnumber'] = $order->takht->takhtnumber;
                  $order['mobilecode'] = $order->user->mobilecode;
                $order['ncode'] = $order->user->ncode;
                $order['roomnumber'] = $order->takht->room->roomnumber;
                $order['karshenasName'] = $order->karshenas->name . ' ' . $order->karshenas->family;
                $order['pansionname'] = $order->takht->room->pansion->name;
                $order['vaziat'] = $order->statusOrder->title;
                $order['pansionname'] = $order->takht->room->pansion->name;
                $splitRaft = explode('-', $order->raft);
                $splitBargasht = explode('-', $order->bargasht);
                $splitRaft = explode('-', $order->raft);
                $splitBargasht = explode('-', $order->bargasht);
                $order['jalaliRaft'] = Verta::create($splitRaft[0], $splitRaft[1], $splitRaft[2], 00, 00, 00)->formatJalaliDate();
                $order['jalaliBargasht'] = Verta::create($splitBargasht[0], $splitBargasht[1], $splitBargasht[2], 00, 00, 00)->formatJalaliDate();
                $order['raftjalali'] = Verta::create($splitRaft[0], $splitRaft[1], $splitRaft[2], 00, 00, 00)->format('Y/m/d');
                $order['bargashtjalali'] = Verta::create($splitBargasht[0], $splitBargasht[1], $splitBargasht[2], 00, 00, 00)->format('Y/m/d');
            }
        }
        return count($orders) > 0 ? $orders : 'notfound';
    }


    public function getOrderByDates($from, $to, $limit, $offset)
    {

        $orders = Order::with(['takht', 'statusmali'])->orderByDesc('id')->whereDate('raft', '<=', Date::create($from))->whereDate('bargasht', '>=', Date::create($to))->limit($limit)->offset($offset)->get();
        if (count($orders) != 0) {
            foreach ($orders as $order) {
                $order['bedehkar'] = $order->statusmali[0]->bedehkar - $order->statusmali[0]->bestankar;
                $order['totalprice'] = $order->statusmali[0]->totalprice;
                $order['takhfif'] = $order->statusmali[0]->takhfif;
                if (count($order->statusmali[0]->qest) != 0) {


                    $order['aqsat'] = $order->statusmali[0]->qest;
                    $recenQest = 0;
                    $pastTarikh = [];
                    foreach ($order->aqsat as $key => $qest) {

                        if (strtotime($qest->tarikh) < $recenQest && $recenQest != 0 && $qest->status != 1) {
                            $recenQest = strtotime($qest->tarikh);
                            $order['recentQest'] = $qest;
                            $splitTarikh = explode('-', $qest->tarikh);
                            $order['recentQest']['jalaliTarikh'] = Verta::create($splitTarikh[0], $splitTarikh[1], $splitTarikh[2], 00, 00, 00)->formatJalaliDate();
                        } elseif ($recenQest == 0 && $qest->status != 1) {
                            $recenQest = strtotime($qest->tarikh);
                            $order['recentQest'] = $qest;
                            $splitTarikh = explode('-', $qest->tarikh);
                            $order['recentQest']['jalaliTarikh'] = Verta::create($splitTarikh[0], $splitTarikh[1], $splitTarikh[2], 00, 00, 00)->formatJalaliDate();
                        }
                        if (strtotime($qest->tarikh) < time() && $qest->status != 1) {
                            $splitTarikh = explode('-', $qest->tarikh);
                            $qest['jalaliTarikh'] = Verta::create($splitTarikh[0], $splitTarikh[1], $splitTarikh[2], 00, 00, 00)->formatJalaliDate();
                            array_push($pastTarikh, $qest);

                        }

                        $splitPaytime = explode('-', $qest->tarikh);
                        $order['aqsat'][$key]['paytime'] = Verta::create($splitPaytime[0], $splitPaytime[1], $splitPaytime[2], 00, 00, 00)->formatJalaliDate();
                        if ($qest->paytarikh != null) {
                            $splitPaytarikh = explode('-', Date::create($qest->paytarikh)->toDateString());
                            $order['aqsat'][$key]['pardakhti'] = Verta::create($splitPaytarikh[0], $splitPaytarikh[1], $splitPaytarikh[2], 00, 00, 00)->formatJalaliDate();
                        }
                        if ($qest->status == '0') {
                            $order['aqsat'][$key]['vaziat'] = 'پرداخت نشده';
                        } elseif ($qest->status == '1') {
                            $order['aqsat'][$key]['vaziat'] = 'پرداخت شده';
                        }
                    }

                    $order['pastTarikh'] = $pastTarikh;


                } elseif ($order->statusmali[0]->naqdtype != null) {

                    $order['naqditype'] = $order->statusmali[0]->naqdtype;
                    foreach ($order->naqditype as $naqd) {
                        $naqd['mablagh'] = $naqd->pivot->mablagh;
                    }
                }
                if ($order->statusmali[0]->status == 'o') {
                    $order['statusmalis'] = 'باز';
                } elseif ($order->statusmali[0]->status == 'd') {
                    $order['statusmalis'] = 'تسویه شده';
                } elseif ($order->statusmali[0]->status == 'c') {
                    $order['statusmalis'] = 'کنسل شده';
                }

                $order['fullname'] = $order->user->name . ' ' . $order->user->family;
                $order['takhtnumber'] = $order->takht->takhtnumber;
                  $order['mobilecode'] = $order->user->mobilecode;
                $order['ncode'] = $order->user->ncode;
                $order['roomnumber'] = $order->takht->room->roomnumber;
                $order['karshenasName'] = $order->karshenas->name . ' ' . $order->karshenas->family;
                $order['pansionname'] = $order->takht->room->pansion->name;
                $order['vaziat'] = $order->statusOrder->title;
                $order['pansionname'] = $order->takht->room->pansion->name;
                $splitRaft = explode('-', $order->raft);
                $splitBargasht = explode('-', $order->bargasht);
                $splitRaft = explode('-', $order->raft);
                $splitBargasht = explode('-', $order->bargasht);
                $order['jalaliRaft'] = Verta::create($splitRaft[0], $splitRaft[1], $splitRaft[2], 00, 00, 00)->formatJalaliDate();
                $order['jalaliBargasht'] = Verta::create($splitBargasht[0], $splitBargasht[1], $splitBargasht[2], 00, 00, 00)->formatJalaliDate();
                $order['raftjalali'] = Verta::create($splitRaft[0], $splitRaft[1], $splitRaft[2], 00, 00, 00)->format('Y/m/d');
                $order['bargashtjalali'] = Verta::create($splitBargasht[0], $splitBargasht[1], $splitBargasht[2], 00, 00, 00)->format('Y/m/d');
            }
        }

        return count($orders) > 0 ? $orders : 'notfound';
    }


    public function getAllOrderByDates($from, $to)
    {

        $orders = Order::with(['takht', 'statusmali'])->orderByDesc('id')->orderByDesc('id')->whereDate('raft', '<=', Date::create($from))->whereDate('bargasht', '>=', Date::create($to))->get();
        if (count($orders) != 0) {
            foreach ($orders as $order) {
                $order['bedehkar'] = $order->statusmali[0]->bedehkar - $order->statusmali[0]->bestankar;
                $order['totalprice'] = $order->statusmali[0]->totalprice;
                $order['takhfif'] = $order->statusmali[0]->takhfif;
                if (count($order->statusmali[0]->qest) != 0) {


                    $order['aqsat'] = $order->statusmali[0]->qest;
                    $recenQest = 0;
                    $pastTarikh = [];
                    foreach ($order->aqsat as $key => $qest) {

                        if (strtotime($qest->tarikh) < $recenQest && $recenQest != 0 && $qest->status != 1) {
                            $recenQest = strtotime($qest->tarikh);
                            $order['recentQest'] = $qest;
                            $splitTarikh = explode('-', $qest->tarikh);
                            $order['recentQest']['jalaliTarikh'] = Verta::create($splitTarikh[0], $splitTarikh[1], $splitTarikh[2], 00, 00, 00)->formatJalaliDate();
                        } elseif ($recenQest == 0 && $qest->status != 1) {
                            $recenQest = strtotime($qest->tarikh);
                            $order['recentQest'] = $qest;
                            $splitTarikh = explode('-', $qest->tarikh);
                            $order['recentQest']['jalaliTarikh'] = Verta::create($splitTarikh[0], $splitTarikh[1], $splitTarikh[2], 00, 00, 00)->formatJalaliDate();
                        }
                        if (strtotime($qest->tarikh) < time() && $qest->status != 1) {
                            $splitTarikh = explode('-', $qest->tarikh);
                            $qest['jalaliTarikh'] = Verta::create($splitTarikh[0], $splitTarikh[1], $splitTarikh[2], 00, 00, 00)->formatJalaliDate();
                            array_push($pastTarikh, $qest);

                        }

                        $splitPaytime = explode('-', $qest->tarikh);
                        $order['aqsat'][$key]['paytime'] = Verta::create($splitPaytime[0], $splitPaytime[1], $splitPaytime[2], 00, 00, 00)->formatJalaliDate();
                        if ($qest->paytarikh != null) {
                            $splitPaytarikh = explode('-', Date::create($qest->paytarikh)->toDateString());
                            $order['aqsat'][$key]['pardakhti'] = Verta::create($splitPaytarikh[0], $splitPaytarikh[1], $splitPaytarikh[2], 00, 00, 00)->formatJalaliDate();
                        }
                        if ($qest->status == '0') {
                            $order['aqsat'][$key]['vaziat'] = 'پرداخت نشده';
                        } elseif ($qest->status == '1') {
                            $order['aqsat'][$key]['vaziat'] = 'پرداخت شده';
                        }
                    }

                    $order['pastTarikh'] = $pastTarikh;


                } elseif ($order->statusmali[0]->naqdtype != null) {

                    $order['naqditype'] = $order->statusmali[0]->naqdtype;
                    foreach ($order->naqditype as $naqd) {
                        $naqd['mablagh'] = $naqd->pivot->mablagh;
                    }
                }
                if ($order->statusmali[0]->status == 'o') {
                    $order['statusmalis'] = 'باز';
                } elseif ($order->statusmali[0]->status == 'd') {
                    $order['statusmalis'] = 'تسویه شده';
                } elseif ($order->statusmali[0]->status == 'c') {
                    $order['statusmalis'] = 'کنسل شده';
                }

                $order['fullname'] = $order->user->name . ' ' . $order->user->family;
                $order['takhtnumber'] = $order->takht->takhtnumber;
                  $order['mobilecode'] = $order->user->mobilecode;
                $order['ncode'] = $order->user->ncode;
                $order['roomnumber'] = $order->takht->room->roomnumber;
                $order['karshenasName'] = $order->karshenas->name . ' ' . $order->karshenas->family;
                $order['pansionname'] = $order->takht->room->pansion->name;
                $order['vaziat'] = $order->statusOrder->title;
                $order['pansionname'] = $order->takht->room->pansion->name;
                $splitRaft = explode('-', $order->raft);
                $splitBargasht = explode('-', $order->bargasht);
                $splitRaft = explode('-', $order->raft);
                $splitBargasht = explode('-', $order->bargasht);
                $order['jalaliRaft'] = Verta::create($splitRaft[0], $splitRaft[1], $splitRaft[2], 00, 00, 00)->formatJalaliDate();
                $order['jalaliBargasht'] = Verta::create($splitBargasht[0], $splitBargasht[1], $splitBargasht[2], 00, 00, 00)->formatJalaliDate();
                $order['raftjalali'] = Verta::create($splitRaft[0], $splitRaft[1], $splitRaft[2], 00, 00, 00)->format('Y/m/d');
                $order['bargashtjalali'] = Verta::create($splitBargasht[0], $splitBargasht[1], $splitBargasht[2], 00, 00, 00)->format('Y/m/d');
            }
        }

        return count($orders) > 0 ? $orders : 'notfound';
    }


    public function getOrdersNotPay()
    {
        $orders = Order::with(['takht', 'statusmali'])->orderByDesc('id')->whereHas('statusmali', function ($q) {
            $q->where('status', 'o');
        })->get();
        return count($orders) > 0 ? $orders : 'notfound';
    }

    public function getOrdersNotPayLimitOffset($limit, $offset)
    {
        $orders = Order::with(['takht', 'statusmali'])->orderByDesc('id')->whereHas('statusmali', function ($q) {
            $q->where('status', 'o');
        })->limit($limit)->offset($offset)->get();
        if (count($orders) != 0) {
            foreach ($orders as $order) {
                $order['bedehkar'] = $order->statusmali[0]->bedehkar - $order->statusmali[0]->bestankar;
                $order['totalprice'] = $order->statusmali[0]->totalprice;
                $order['takhfif'] = $order->statusmali[0]->takhfif;
                if (count($order->statusmali[0]->qest) != 0) {


                    $order['aqsat'] = $order->statusmali[0]->qest;
                    $recenQest = 0;
                    $pastTarikh = [];
                    foreach ($order->aqsat as $key => $qest) {

                        if (strtotime($qest->tarikh) < $recenQest && $recenQest != 0 && $qest->status != 1) {
                            $recenQest = strtotime($qest->tarikh);
                            $order['recentQest'] = $qest;
                            $splitTarikh = explode('-', $qest->tarikh);
                            $order['recentQest']['jalaliTarikh'] = Verta::create($splitTarikh[0], $splitTarikh[1], $splitTarikh[2], 00, 00, 00)->formatJalaliDate();
                        } elseif ($recenQest == 0 && $qest->status != 1) {
                            $recenQest = strtotime($qest->tarikh);
                            $order['recentQest'] = $qest;
                            $splitTarikh = explode('-', $qest->tarikh);
                            $order['recentQest']['jalaliTarikh'] = Verta::create($splitTarikh[0], $splitTarikh[1], $splitTarikh[2], 00, 00, 00)->formatJalaliDate();
                        }
                        if (strtotime($qest->tarikh) < time() && $qest->status != 1) {
                            $splitTarikh = explode('-', $qest->tarikh);
                            $qest['jalaliTarikh'] = Verta::create($splitTarikh[0], $splitTarikh[1], $splitTarikh[2], 00, 00, 00)->formatJalaliDate();
                            array_push($pastTarikh, $qest);

                        }

                        $splitPaytime = explode('-', $qest->tarikh);
                        $order['aqsat'][$key]['paytime'] = Verta::create($splitPaytime[0], $splitPaytime[1], $splitPaytime[2], 00, 00, 00)->formatJalaliDate();
                        if ($qest->paytarikh != null) {
                            $splitPaytarikh = explode('-', Date::create($qest->paytarikh)->toDateString());
                            $order['aqsat'][$key]['pardakhti'] = Verta::create($splitPaytarikh[0], $splitPaytarikh[1], $splitPaytarikh[2], 00, 00, 00)->formatJalaliDate();
                        }
                        if ($qest->status == '0') {
                            $order['aqsat'][$key]['vaziat'] = 'پرداخت نشده';
                        } elseif ($qest->status == '1') {
                            $order['aqsat'][$key]['vaziat'] = 'پرداخت شده';
                        }
                    }

                    $order['pastTarikh'] = $pastTarikh;


                } elseif ($order->statusmali[0]->naqdtype != null) {

                    $order['naqditype'] = $order->statusmali[0]->naqdtype;
                    foreach ($order->naqditype as $naqd) {
                        $naqd['mablagh'] = $naqd->pivot->mablagh;
                    }
                }
                if ($order->statusmali[0]->status == 'o') {
                    $order['statusmalis'] = 'باز';
                } elseif ($order->statusmali[0]->status == 'd') {
                    $order['statusmalis'] = 'تسویه شده';
                } elseif ($order->statusmali[0]->status == 'c') {
                    $order['statusmalis'] = 'کنسل شده';
                }

                $order['fullname'] = $order->user->name . ' ' . $order->user->family;
                $order['takhtnumber'] = $order->takht->takhtnumber;
                  $order['mobilecode'] = $order->user->mobilecode;
                $order['ncode'] = $order->user->ncode;
                $order['roomnumber'] = $order->takht->room->roomnumber;
                $order['karshenasName'] = $order->karshenas->name . ' ' . $order->karshenas->family;
                $order['pansionname'] = $order->takht->room->pansion->name;
                $order['vaziat'] = $order->statusOrder->title;
                $order['pansionname'] = $order->takht->room->pansion->name;
                $splitRaft = explode('-', $order->raft);
                $splitBargasht = explode('-', $order->bargasht);
                $splitRaft = explode('-', $order->raft);
                $splitBargasht = explode('-', $order->bargasht);
                $order['jalaliRaft'] = Verta::create($splitRaft[0], $splitRaft[1], $splitRaft[2], 00, 00, 00)->formatJalaliDate();
                $order['jalaliBargasht'] = Verta::create($splitBargasht[0], $splitBargasht[1], $splitBargasht[2], 00, 00, 00)->formatJalaliDate();
                $order['raftjalali'] = Verta::create($splitRaft[0], $splitRaft[1], $splitRaft[2], 00, 00, 00)->format('Y/m/d');
                $order['bargashtjalali'] = Verta::create($splitBargasht[0], $splitBargasht[1], $splitBargasht[2], 00, 00, 00)->format('Y/m/d');
            }
        }
        return count($orders) > 0 ? $orders : 'notfound';
    }


    public function getOrdersNotPayDateLimitOffset($from, $to, $limit, $offset)
    {

        $orders = Order::with(['takht', 'statusmali'])->orderByDesc('id')->whereHas('statusmali', function ($q) {
            $q->where('status', 'o');
        })->whereDate('raft', '<=', Date::create($from))->whereDate('bargasht', '>=', Date::create($to))->limit($limit)->offset($offset)->get();
        if (count($orders) != 0) {
            foreach ($orders as $order) {
                $order['bedehkar'] = $order->statusmali[0]->bedehkar - $order->statusmali[0]->bestankar;
                $order['totalprice'] = $order->statusmali[0]->totalprice;
                $order['takhfif'] = $order->statusmali[0]->takhfif;
                if (count($order->statusmali[0]->qest) != 0) {


                    $order['aqsat'] = $order->statusmali[0]->qest;
                    $recenQest = 0;
                    $pastTarikh = [];
                    foreach ($order->aqsat as $key => $qest) {

                        if (strtotime($qest->tarikh) < $recenQest && $recenQest != 0 && $qest->status != 1) {
                            $recenQest = strtotime($qest->tarikh);
                            $order['recentQest'] = $qest;
                            $splitTarikh = explode('-', $qest->tarikh);
                            $order['recentQest']['jalaliTarikh'] = Verta::create($splitTarikh[0], $splitTarikh[1], $splitTarikh[2], 00, 00, 00)->formatJalaliDate();
                        } elseif ($recenQest == 0 && $qest->status != 1) {
                            $recenQest = strtotime($qest->tarikh);
                            $order['recentQest'] = $qest;
                            $splitTarikh = explode('-', $qest->tarikh);
                            $order['recentQest']['jalaliTarikh'] = Verta::create($splitTarikh[0], $splitTarikh[1], $splitTarikh[2], 00, 00, 00)->formatJalaliDate();
                        }
                        if (strtotime($qest->tarikh) < time() && $qest->status != 1) {
                            $splitTarikh = explode('-', $qest->tarikh);
                            $qest['jalaliTarikh'] = Verta::create($splitTarikh[0], $splitTarikh[1], $splitTarikh[2], 00, 00, 00)->formatJalaliDate();
                            array_push($pastTarikh, $qest);

                        }

                        $splitPaytime = explode('-', $qest->tarikh);
                        $order['aqsat'][$key]['paytime'] = Verta::create($splitPaytime[0], $splitPaytime[1], $splitPaytime[2], 00, 00, 00)->formatJalaliDate();
                        if ($qest->paytarikh != null) {
                            $splitPaytarikh = explode('-', Date::create($qest->paytarikh)->toDateString());
                            $order['aqsat'][$key]['pardakhti'] = Verta::create($splitPaytarikh[0], $splitPaytarikh[1], $splitPaytarikh[2], 00, 00, 00)->formatJalaliDate();
                        }
                        if ($qest->status == '0') {
                            $order['aqsat'][$key]['vaziat'] = 'پرداخت نشده';
                        } elseif ($qest->status == '1') {
                            $order['aqsat'][$key]['vaziat'] = 'پرداخت شده';
                        }
                    }

                    $order['pastTarikh'] = $pastTarikh;


                } elseif ($order->statusmali[0]->naqdtype != null) {

                    $order['naqditype'] = $order->statusmali[0]->naqdtype;
                    foreach ($order->naqditype as $naqd) {
                        $naqd['mablagh'] = $naqd->pivot->mablagh;
                    }
                }
                if ($order->statusmali[0]->status == 'o') {
                    $order['statusmalis'] = 'باز';
                } elseif ($order->statusmali[0]->status == 'd') {
                    $order['statusmalis'] = 'تسویه شده';
                } elseif ($order->statusmali[0]->status == 'c') {
                    $order['statusmalis'] = 'کنسل شده';
                }

                $order['fullname'] = $order->user->name . ' ' . $order->user->family;
                $order['takhtnumber'] = $order->takht->takhtnumber;
                  $order['mobilecode'] = $order->user->mobilecode;
                $order['ncode'] = $order->user->ncode;
                $order['roomnumber'] = $order->takht->room->roomnumber;
                $order['karshenasName'] = $order->karshenas->name . ' ' . $order->karshenas->family;
                $order['pansionname'] = $order->takht->room->pansion->name;
                $order['vaziat'] = $order->statusOrder->title;
                $order['pansionname'] = $order->takht->room->pansion->name;
                $splitRaft = explode('-', $order->raft);
                $splitBargasht = explode('-', $order->bargasht);
                $splitRaft = explode('-', $order->raft);
                $splitBargasht = explode('-', $order->bargasht);
                $order['jalaliRaft'] = Verta::create($splitRaft[0], $splitRaft[1], $splitRaft[2], 00, 00, 00)->formatJalaliDate();
                $order['jalaliBargasht'] = Verta::create($splitBargasht[0], $splitBargasht[1], $splitBargasht[2], 00, 00, 00)->formatJalaliDate();
                $order['raftjalali'] = Verta::create($splitRaft[0], $splitRaft[1], $splitRaft[2], 00, 00, 00)->format('Y/m/d');
                $order['bargashtjalali'] = Verta::create($splitBargasht[0], $splitBargasht[1], $splitBargasht[2], 00, 00, 00)->format('Y/m/d');
            }
        }
        return count($orders) > 0 ? $orders : 'notfound';
    }



    public function getOrdersNotPayDate($from, $to)
    {

        $orders = Order::with(['takht', 'statusmali'])->orderByDesc('id')->whereHas('statusmali', function ($q) {
            $q->where('status', 'o');
        })->whereDate('raft', '<=', Date::create($from))->whereDate('bargasht', '>=', Date::create($to))->get();
        if (count($orders) != 0) {
            foreach ($orders as $order) {
                $order['bedehkar'] = $order->statusmali[0]->bedehkar - $order->statusmali[0]->bestankar;
                $order['totalprice'] = $order->statusmali[0]->totalprice;
                $order['takhfif'] = $order->statusmali[0]->takhfif;
                if (count($order->statusmali[0]->qest) != 0) {


                    $order['aqsat'] = $order->statusmali[0]->qest;
                    $recenQest = 0;
                    $pastTarikh = [];
                    foreach ($order->aqsat as $key => $qest) {

                        if (strtotime($qest->tarikh) < $recenQest && $recenQest != 0 && $qest->status != 1) {
                            $recenQest = strtotime($qest->tarikh);
                            $order['recentQest'] = $qest;
                            $splitTarikh = explode('-', $qest->tarikh);
                            $order['recentQest']['jalaliTarikh'] = Verta::create($splitTarikh[0], $splitTarikh[1], $splitTarikh[2], 00, 00, 00)->formatJalaliDate();
                        } elseif ($recenQest == 0 && $qest->status != 1) {
                            $recenQest = strtotime($qest->tarikh);
                            $order['recentQest'] = $qest;
                            $splitTarikh = explode('-', $qest->tarikh);
                            $order['recentQest']['jalaliTarikh'] = Verta::create($splitTarikh[0], $splitTarikh[1], $splitTarikh[2], 00, 00, 00)->formatJalaliDate();
                        }
                        if (strtotime($qest->tarikh) < time() && $qest->status != 1) {
                            $splitTarikh = explode('-', $qest->tarikh);
                            $qest['jalaliTarikh'] = Verta::create($splitTarikh[0], $splitTarikh[1], $splitTarikh[2], 00, 00, 00)->formatJalaliDate();
                            array_push($pastTarikh, $qest);

                        }

                        $splitPaytime = explode('-', $qest->tarikh);
                        $order['aqsat'][$key]['paytime'] = Verta::create($splitPaytime[0], $splitPaytime[1], $splitPaytime[2], 00, 00, 00)->formatJalaliDate();
                        if ($qest->paytarikh != null) {
                            $splitPaytarikh = explode('-', Date::create($qest->paytarikh)->toDateString());
                            $order['aqsat'][$key]['pardakhti'] = Verta::create($splitPaytarikh[0], $splitPaytarikh[1], $splitPaytarikh[2], 00, 00, 00)->formatJalaliDate();
                        }
                        if ($qest->status == '0') {
                            $order['aqsat'][$key]['vaziat'] = 'پرداخت نشده';
                        } elseif ($qest->status == '1') {
                            $order['aqsat'][$key]['vaziat'] = 'پرداخت شده';
                        }
                    }

                    $order['pastTarikh'] = $pastTarikh;


                } elseif ($order->statusmali[0]->naqdtype != null) {

                    $order['naqditype'] = $order->statusmali[0]->naqdtype;
                    foreach ($order->naqditype as $naqd) {
                        $naqd['mablagh'] = $naqd->pivot->mablagh;
                    }
                }
                if ($order->statusmali[0]->status == 'o') {
                    $order['statusmalis'] = 'باز';
                } elseif ($order->statusmali[0]->status == 'd') {
                    $order['statusmalis'] = 'تسویه شده';
                } elseif ($order->statusmali[0]->status == 'c') {
                    $order['statusmalis'] = 'کنسل شده';
                }

                $order['fullname'] = $order->user->name . ' ' . $order->user->family;
                $order['takhtnumber'] = $order->takht->takhtnumber;
                  $order['mobilecode'] = $order->user->mobilecode;
                $order['ncode'] = $order->user->ncode;
                $order['roomnumber'] = $order->takht->room->roomnumber;
                $order['karshenasName'] = $order->karshenas->name . ' ' . $order->karshenas->family;
                $order['pansionname'] = $order->takht->room->pansion->name;
                $order['vaziat'] = $order->statusOrder->title;
                $order['pansionname'] = $order->takht->room->pansion->name;
                $splitRaft = explode('-', $order->raft);
                $splitBargasht = explode('-', $order->bargasht);
                $splitRaft = explode('-', $order->raft);
                $splitBargasht = explode('-', $order->bargasht);
                $order['jalaliRaft'] = Verta::create($splitRaft[0], $splitRaft[1], $splitRaft[2], 00, 00, 00)->formatJalaliDate();
                $order['jalaliBargasht'] = Verta::create($splitBargasht[0], $splitBargasht[1], $splitBargasht[2], 00, 00, 00)->formatJalaliDate();
                $order['raftjalali'] = Verta::create($splitRaft[0], $splitRaft[1], $splitRaft[2], 00, 00, 00)->format('Y/m/d');
                $order['bargashtjalali'] = Verta::create($splitBargasht[0], $splitBargasht[1], $splitBargasht[2], 00, 00, 00)->format('Y/m/d');
            }
        }
        return count($orders) > 0 ? $orders : 'notfound';
    }


    public function getAqsatByOrder($id)
    {

        $aqsat = Qest::with('statusmali')->whereHas('statusmali', function ($q) use ($id) {
            $q->where('order_id', $id);
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

        return count($aqsat) > 0 ? $aqsat : 'notfound';
    }

    public function payQest($id, $paytarikh, $naqdtype, $fish)
    {
        $qest = Qest::with('statusmali')->find($id);
        $qest->status = '1';
        $qest->paytarikh = $paytarikh;
        $qest->naqdtype_id = $naqdtype;
        DB::beginTransaction();
        if ($fish != null) {

            $filename = $fish->getClientOriginalName();
            $path = 'storage/images/aqsat/' . $filename;
            $fish->storeAs('public/images/aqsat/', $filename);
            $qest->fish = $path;
            $transaction = new Transaction();
            $transaction->transactiontype_id = '2';
            $transaction->price = $qest->amount;
            $transaction->fish = $path;
            $transaction->order_id = $qest->statusmali->order->id;
            $transaction->user_id = $qest->statusmali->order->user_id;
        }
        if ($qest->save()) {

            $transaction->save();

            $others = Qest::with('statusmali')->where('statusmali_id', $qest->statusmali_id)->where('status', '0')->exists();
            $statusmali = Statusmali::with(['qest', 'order'])->find($qest->statusmali_id);
            $wallet = Wallet::with('user')->where('user_id', $statusmali->order->user->id)->first();
            if ($others == false) {
                $statusmali->status = 'd';

            }
            $statusmali->bestankar = $statusmali->bestankar + $qest->amount;
            $statusmali->save();
            $wallet->bedehkar = $wallet->bedehkar - $qest->amount;
            $wallet->save();
            DB::commit();
            return 'ok';
        } else {
            DB::rollBack();
            return 'nofound';
        }
    }


    public function getReserveforTakhtBetween2Dates($id, $raft, $bargasht, $reserveType, $thisId)
    {

        $orders = Order::with(['reservetype', 'takht'])
            ->orderByDesc('id')
            ->whereHas('takht', function ($q) use ($reserveType) {
                $q->where('reservetype_id', $reserveType)
                    ->orWhere('reservetype_id', 3);
            })
            ->where(function ($q) use ($raft, $bargasht, $id) {
                $q->whereDate('raft', '>=', Date::create($raft))
                    ->whereDate('raft', '<=', Date::create($bargasht))->where('takht_id', $id)->where('status_order_id', '1');

            })
            ->orWhere(function ($q) use ($raft, $bargasht, $id) {
                $q->whereDate('bargasht', '<=', Date::create($bargasht))
                    ->whereDate('bargasht', '>=', Date::create($raft))->where('takht_id', $id)->where('status_order_id', '1');

            })
            ->get()->except($thisId);
        foreach ($orders as $order) {
            $order['fullname'] = $order->user->name . ' ' . $order->user->family;
            if ($order->statusmali[0]->status == 'o') {
                $order['statusmalis'] = 'باز';
            } elseif ($order->statusmali[0]->status == 'd') {
                $order['statusmalis'] = 'تسویه شده';
            } elseif ($order->statusmali[0]->status == 'c') {
                $order['statusmalis'] = 'کنسل شده';
            }
            $splitRaft = explode('-', $order->raft);
            $splitBargasht = explode('-', $order->bargasht);
            $order['raftjalali'] = Verta::create($splitRaft[0], $splitRaft[1], $splitRaft[2], 00, 00, 00)->format('Y/m/d');
            $order['bargashtjalali'] = Verta::create($splitBargasht[0], $splitBargasht[1], $splitBargasht[2], 00, 00, 00)->format('Y/m/d');
        }

        return count($orders) != 0 ? $orders : 'notfound';
    }


    public function getOrders5DaysLeft()
    {

        $fivedays = 5 * 24 * 60 * 60;
        $fiveDaysLeft = gmdate("Y-m-d", strtotime(Date::now()) + $fivedays);
        $fiveDaysLeftTimeStamp = Date::create($fiveDaysLeft);

        $orders = Order::with(['takht', 'statusmali'])->orderByDesc('id')->where('status_order_id', '1')->whereDate('bargasht', $fiveDaysLeftTimeStamp)->get();
        if (count($orders) != 0) {

            foreach ($orders as $order) {

//            $this->smsService->send($order->user->mobilecode,'بیا پول بده.');
            }
        }
        return count($orders) != 0 ? $orders : 'notfound';
    }


    public function getQests3Dayleft()
    {
        $threedays = 3 * 24 * 60 * 60;
        $threeDaysLeft = gmdate("Y-m-d", strtotime(Date::now()) + $threedays);
        $threeDaysLeftTimeStamp = Date::create($threeDaysLeft);
        $aqsat = Qest::with('statusmali')->whereDate('tarikh', $threeDaysLeftTimeStamp)->get();
        if (count($aqsat) != 0){
            foreach ($aqsat as $qest) {
                $qest['user'] = $qest->statusmali->order->user_id;
    //                        $this->smsService->send($qest->statusmali->order->user->mobilecode,'بیا پول بده.');

            }
        }

        return count($aqsat) != 0 ? $aqsat : 'notfound';
    }


    public function getOrders5DaysSoon()
    {

        $fivedays = 5 * 24 * 60 * 60;
        $fiveDaysLeft = gmdate("Y-m-d", strtotime(Date::now()) - $fivedays);
        $fiveDaysLeftTimeStamp = Date::create($fiveDaysLeft);

        $orders = Order::with(['takht', 'statusmali'])->orderByDesc('id')->where('status_order_id', '1')->whereDate('raft', $fiveDaysLeftTimeStamp)->get();
        if (count($orders) != 0){
            foreach ($orders as $order) {

//            $this->smsService->send($order->user->mobilecode,'بیا پول بده.');
            }
    }
        return count($orders) != 0 ? $orders : 'notfound';
    }


    public function setFullEmptyOrders()
    {

        $orders=Order::with('takht')->orderByDesc('id')->where('status_order_id','1')->get();
        foreach ($orders as $order) {

            $unixraft = strtotime($order->getRawOriginal('raft'));
            $unixbargasht = strtotime($order->getRawOriginal('bargasht'));

            if ($unixraft <= time() && $unixbargasht > time()) {

                $takht = Takht::find($order->takht_id);
                if($takht->status != 'پر') {
                    $takht->status = 'پر';
                    $takht->save();
                    $room=Room::find($takht->room_id);
                    $room->capacity=$room->capacity-1;
                    $room->save();
                }

            } elseif ($unixbargasht < time()) {

                $takht = Takht::find($order->takht_id);
                if($takht->status != 'خالی') {
                    $takht->status = 'خالی';
                    $takht->save();
                    $order->status_order_id = '2';
                    $order->save();
                    $room=Room::find($takht->room_id);
                    $room->capacity=$room->capacity+1;
                    $room->save();
                }

            }
        }

    }


    public function setMoalaghOrders()
    {
        $orders = Order::with(['user','statusmali'])->orderByDesc('id')->where('status_order_id', '7')->get();
        foreach ($orders as $order) {
            $quarter = strtotime($order->created_at) + 900;
            DB::beginTransaction();
            if ($quarter <= strtotime(Date::now())) {

                if($order->transaction()->where('transactiontype_id','8')->exists()) {
                    $price= $order->transaction()->where('transactiontype_id','8')->first()->price;
                    $user=$order->user()->first();
                    $wallet=  $user->wallet()->first();
                    $wallet->bedehkar=$wallet->bedehkar-$price;
                    $wallet->save();
                    $order->statusmali()->forceDelete();
                    $order->transaction()->where('transactiontype_id','8')->forceDelete();
                    $order->forceDelete();
                }
            }
            DB::commit();
        }
    }


    public function tamdid($orderId)
    {
        $lastOrder = Order::with('statusmali')->find($orderId);
        dd($lastOrder);
        if ($lastOrder->reservetype_id == 1) {
            $cal = 60 * 60 * 24 * $lastOrder->days;
        } elseif ($lastOrder->reservetype_id == 2) {
            $cal = 60 * 60 * 24 * 30 * $lastOrder->month;
        }

        $bargashtUnix = strtotime($lastOrder->bargasht) + $cal;
        $bargasht = Date("Y-m-d", $bargashtUnix);
        $order = new Order();
        $order->takht_id = $lastOrder->takht_id;
        $order->raft = $lastOrder->bargasht;
        $order->bargasht = $bargasht;
        $order->month = $lastOrder->month;
        $order->days = $lastOrder->month;
        $order->user_id = $lastOrder->user_id;
        $contractNum = str_replace('-', '', Verta(Date::now())->formatDate()) . rand(1000000000, 9999999999);
        $conractExist = Order::where('order_number', $contractNum)->exists();
        if ($conractExist) {
            $contractNum = str_replace('-', '', Verta(Date::now())->formatDate()) . rand(1000000000, 9999999999);
            $conractExist = Order::where('order_number', $contractNum)->exists();
        }
        if ($conractExist == false) {
            $order->order_number = $contractNum;
        } else {
            return "contractExist";
        }
//        if ($order->save()){
//            $statusmali=new Statusmali();
//            $statusmali->
//        }
    }


    public function fullForTamdid($raft, $bargasht, $takhtId)
    {
        $orders = Order::with(['takht', 'user'])
            ->orderByDesc('id')
            ->where('takht_id', $takhtId)
            ->where(function ($q) use ($raft, $bargasht) {
                $q->whereDate('bargasht', '<', Date::create($bargasht))
                    ->whereDate('bargasht', '>', Date::create($raft))->where('status_order_id', '1');

            })
            ->orWhere(function ($q) use ($raft, $bargasht) {
                $q->whereDate('raft', '>=', Date::create($raft))
                    ->whereDate('raft', '<=', Date::create($bargasht))->where('status_order_id', '1');

            })
            ->orWhere(function ($q) use ($raft, $bargasht) {
                $q->whereDate('bargasht', '>', Date::create($bargasht))
                    ->whereDate('bargasht', '>', Date::create($raft))
                    ->whereDate('raft', '<=', Date::create($raft))
                    ->whereDate('raft', '<=', Date::create($bargasht))
                    ->where('status_order_id', '1');

            })
            ->get();
        return count($orders) ? 'found' : 'notfound';
    }



    public function getOderBySearch($column,$output)
    {
        if ($column=='mobilecode' || $column=='name' || $column=='ncode'){
            $orders=Order::with(['user','statusmali','takht'])->orderByDesc('id')->whereHas('user',function ($that) use ($column,$output){
                if ($column=='name'){
                    $seprateName=explode(' ',$output);
                    if (count($seprateName)==1){
                        $that->where('name','regexp',$seprateName[0])->orWhere('family','regexp',$seprateName[0]);
                    }
                    elseif (count($seprateName)==2){
                        $that->where('name','regexp',$seprateName[0])->where('family','regexp',$seprateName[1]);
                    }
                    else{
                        for ($i=0;$i<count($seprateName);$i++){
                            $that->where('name','regexp',$seprateName[$i])->where('family','regexp',$seprateName[$i+1]);
                        }

                    }
                } else {
                    $that->where($column,'regexp',$output);
                }

            })->get();
        } elseif($column=='pansion'){
            $orders=Order::with(['user','statusmali','takht'])->orderByDesc('id')->whereHas('takht',function ($that) use ($column,$output){
                    $that->with('room')->whereHas('room',function ($these) use($column,$output){
                    $these->whereHas('pansion',function ($those) use($column,$output){
                        $those->where('name','regexp',$output);
                    });
                    });
                    })->get();

        } elseif ($column=='karshenas'){
            $orders=Order::with(['user','statusmali','takht','karshenas'])->orderByDesc('id')->whereHas('karshenas',function ($that) use ($column,$output){
                $karshesSerprate=explode(' ',$output);

                if (count($karshesSerprate)==1){
                    $that->where('name','regexp',$karshesSerprate[0])->orWhere('family','regexp',$karshesSerprate[0]);
                }
                elseif (count($karshesSerprate)==2){
                    $that->where(function ($q) use ($karshesSerprate){
                        $q->where('name','regexp',$karshesSerprate[0].' '.$karshesSerprate[1]);})->orWhere(function ($q) use ($karshesSerprate){
                        $q->where('name','regexp',$karshesSerprate[0])->where('family','regexp',$karshesSerprate[1]);});
                }
                else{
                    for ($i=0;$i<count($karshesSerprate);$i++){
                        $that->where(function ($q) use ($karshesSerprate,$i){
                            if (isset($karshesSerprate[$i+1])){
                            $q->where('name','regexp',$karshesSerprate[$i].' '.$karshesSerprate[$i+1]);
                            }
                        })->orWhere(function ($q) use ($karshesSerprate,$i){
                                if (isset($karshesSerprate[$i+1]) && isset($karshesSerprate[$i+2])){
                                    $q->where('name','regexp',$karshesSerprate[$i].' '.$karshesSerprate[$i+1])->where('family','regexp',$karshesSerprate[$i+2]);
                                }
                           });
                    }

                }
            })->get();
        }else{
            $orders=Order::with(['user','statusmali','takht'])->orderByDesc('id')->where($column,'regexp',$output)->get();
        }
        if (count($orders) != 0) {
            foreach ($orders as $order) {
                $order['bedehkar'] = $order->statusmali[0]->bedehkar - $order->statusmali[0]->bestankar;
                $order['totalprice'] = $order->statusmali[0]->totalprice;
                $order['takhfif'] = $order->statusmali[0]->takhfif;
                if (count($order->statusmali[0]->qest) != 0) {


                    $order['aqsat'] = $order->statusmali[0]->qest;
                    $recenQest = 0;
                    $pastTarikh = [];
                    foreach ($order->aqsat as $key => $qest) {

                        if (strtotime($qest->tarikh) < $recenQest && $recenQest != 0 && $qest->status != 1) {
                            $recenQest = strtotime($qest->tarikh);
                            $order['recentQest'] = $qest;
                            $splitTarikh = explode('-', $qest->tarikh);
                            $order['recentQest']['jalaliTarikh'] = Verta::create($splitTarikh[0], $splitTarikh[1], $splitTarikh[2], 00, 00, 00)->formatJalaliDate();
                        } elseif ($recenQest == 0 && $qest->status != 1) {
                            $recenQest = strtotime($qest->tarikh);
                            $order['recentQest'] = $qest;
                            $splitTarikh = explode('-', $qest->tarikh);
                            $order['recentQest']['jalaliTarikh'] = Verta::create($splitTarikh[0], $splitTarikh[1], $splitTarikh[2], 00, 00, 00)->formatJalaliDate();
                        }
                        if (strtotime($qest->tarikh) < time() && $qest->status != 1) {
                            $splitTarikh = explode('-', $qest->tarikh);
                            $qest['jalaliTarikh'] = Verta::create($splitTarikh[0], $splitTarikh[1], $splitTarikh[2], 00, 00, 00)->formatJalaliDate();
                            array_push($pastTarikh, $qest);

                        }

                        $splitPaytime = explode('-', $qest->tarikh);
                        $order['aqsat'][$key]['paytime'] = Verta::create($splitPaytime[0], $splitPaytime[1], $splitPaytime[2], 00, 00, 00)->formatJalaliDate();
                        if ($qest->paytarikh != null) {
                            $splitPaytarikh = explode('-', Date::create($qest->paytarikh)->toDateString());
                            $order['aqsat'][$key]['pardakhti'] = Verta::create($splitPaytarikh[0], $splitPaytarikh[1], $splitPaytarikh[2], 00, 00, 00)->formatJalaliDate();
                        }
                        if ($qest->status == '0') {
                            $order['aqsat'][$key]['vaziat'] = 'پرداخت نشده';
                        } elseif ($qest->status == '1') {
                            $order['aqsat'][$key]['vaziat'] = 'پرداخت شده';
                        }
                    }

                    $order['pastTarikh'] = $pastTarikh;


                } elseif ($order->statusmali[0]->naqdtype != null) {

                    $order['naqditype'] = $order->statusmali[0]->naqdtype;
                    foreach ($order->naqditype as $naqd) {
                        $naqd['mablagh'] = $naqd->pivot->mablagh;
                    }
                }
                if ($order->statusmali[0]->status == 'o') {
                    $order['statusmalis'] = 'باز';
                } elseif ($order->statusmali[0]->status == 'd') {
                    $order['statusmalis'] = 'تسویه شده';
                } elseif ($order->statusmali[0]->status == 'c') {
                    $order['statusmalis'] = 'کنسل شده';
                }

                $order['fullname'] = $order->user->name . ' ' . $order->user->family;
                $order['takhtnumber'] = $order->takht->takhtnumber;
                $order['mobilecode'] = $order->user->mobilecode;
                $order['ncode'] = $order->user->ncode;
                $order['roomnumber'] = $order->takht->room->roomnumber;
                $order['karshenasName'] = $order->karshenas->name . ' ' . $order->karshenas->family;
                $order['pansionname'] = $order->takht->room->pansion->name;
                $order['vaziat'] = $order->statusOrder->title;
                $order['pansionname'] = $order->takht->room->pansion->name;
                $splitRaft = explode('-', $order->raft);
                $splitBargasht = explode('-', $order->bargasht);
                $splitRaft = explode('-', $order->raft);
                $splitBargasht = explode('-', $order->bargasht);
                $order['jalaliRaft'] = Verta::create($splitRaft[0], $splitRaft[1], $splitRaft[2], 00, 00, 00)->formatJalaliDate();
                $order['jalaliBargasht'] = Verta::create($splitBargasht[0], $splitBargasht[1], $splitBargasht[2], 00, 00, 00)->formatJalaliDate();
                $order['raftjalali'] = Verta::create($splitRaft[0], $splitRaft[1], $splitRaft[2], 00, 00, 00)->format('Y/m/d');
                $order['bargashtjalali'] = Verta::create($splitBargasht[0], $splitBargasht[1], $splitBargasht[2], 00, 00, 00)->format('Y/m/d');
            }
        }
        return count($orders) != 0 ? $orders : 'notfound';
    }


    public function getOderBySearchLimitOffset($column,$output,$limit,$offset)
    {
        if ($column=='mobilecode' || $column=='name' || $column=='ncode'){
            $orders=Order::with(['user','statusmali','takht'])->orderByDesc('id')->whereHas('user',function ($that) use ($column,$output){
                if ($column=='name'){
                    $seprateName=explode(' ',$output);

                    if (count($seprateName)==1){
                        $that->where('name','regexp',$seprateName[0])->orWhere('family','regexp',$seprateName[0]);
                    }
                    elseif (count($seprateName)==2){
                        $that->where('name','regexp',$seprateName[0])->where('family','regexp',$seprateName[1]);
                    }
                    else{
                        for ($i=0;$i<count($seprateName);$i++){
                            $that->where('name','regexp',$seprateName[$i])->where('family','regexp',$seprateName[$i+1]);
                        }

                    }
                }
                else{
                    $that->where($column,'regexp',$output);
                }

            })->limit($limit)->offset($offset)->get();
        }
        elseif($column=='pansion'){
            $orders=Order::with(['user','statusmali','takht'])->orderByDesc('id')->whereHas('takht',function ($that) use ($column,$output){
                $that->with('room')->whereHas('room',function ($these) use($column,$output){
                    $these->whereHas('pansion',function ($those) use($column,$output){
                        $those->where('name','regexp',$output);
                    });
                });
            })->limit($limit)->offset($offset)->get();

        }
        elseif ($column=='karshenas'){

            $orders=Order::with(['user','statusmali','takht','karshenas'])->orderByDesc('id')->whereHas('karshenas',function ($that) use ($column,$output){
                $karshesSerprate=explode(' ',$output);

                if (count($karshesSerprate)==1){
                    $that->where('name','regexp',$karshesSerprate[0])->orWhere('family','regexp',$karshesSerprate[0]);
                }
                elseif (count($karshesSerprate)==2){
                    $that->where(function ($q) use ($karshesSerprate){
                        $q->where('name','regexp',$karshesSerprate[0].' '.$karshesSerprate[1]);})->orWhere(function ($q) use ($karshesSerprate){
                        $q->where('name','regexp',$karshesSerprate[0])->where('family','regexp',$karshesSerprate[1]);});
                }
                else{
                    for ($i=0;$i<count($karshesSerprate);$i++){
                        $that->where(function ($q) use ($karshesSerprate,$i){
                            $q->where('name','regexp',$karshesSerprate[$i].' '.$karshesSerprate[$i+1]);})->orWhere(function ($q) use ($karshesSerprate,$i){
                            $q->where('name','regexp',$karshesSerprate[$i].' '.$karshesSerprate[$i+1])->where('family','regexp',$karshesSerprate[$i+2]);});
                    }

                }

            })->limit($limit)->offset($offset)->get();
        }
        else{
            $orders=Order::with(['user','statusmali','takht'])->orderByDesc('id')->where($column,'regexp',$output)->limit($limit)->offset($offset)->get();
        }
        if (count($orders) != 0) {
            foreach ($orders as $order) {
                $order['bedehkar'] = $order->statusmali[0]->bedehkar - $order->statusmali[0]->bestankar;
                $order['totalprice'] = $order->statusmali[0]->totalprice;
                $order['takhfif'] = $order->statusmali[0]->takhfif;
                if (count($order->statusmali[0]->qest) != 0) {


                    $order['aqsat'] = $order->statusmali[0]->qest;
                    $recenQest = 0;
                    $pastTarikh = [];
                    foreach ($order->aqsat as $key => $qest) {

                        if (strtotime($qest->tarikh) < $recenQest && $recenQest != 0 && $qest->status != 1) {
                            $recenQest = strtotime($qest->tarikh);
                            $order['recentQest'] = $qest;
                            $splitTarikh = explode('-', $qest->tarikh);
                            $order['recentQest']['jalaliTarikh'] = Verta::create($splitTarikh[0], $splitTarikh[1], $splitTarikh[2], 00, 00, 00)->formatJalaliDate();
                        } elseif ($recenQest == 0 && $qest->status != 1) {
                            $recenQest = strtotime($qest->tarikh);
                            $order['recentQest'] = $qest;
                            $splitTarikh = explode('-', $qest->tarikh);
                            $order['recentQest']['jalaliTarikh'] = Verta::create($splitTarikh[0], $splitTarikh[1], $splitTarikh[2], 00, 00, 00)->formatJalaliDate();
                        }
                        if (strtotime($qest->tarikh) < time() && $qest->status != 1) {
                            $splitTarikh = explode('-', $qest->tarikh);
                            $qest['jalaliTarikh'] = Verta::create($splitTarikh[0], $splitTarikh[1], $splitTarikh[2], 00, 00, 00)->formatJalaliDate();
                            array_push($pastTarikh, $qest);

                        }

                        $splitPaytime = explode('-', $qest->tarikh);
                        $order['aqsat'][$key]['paytime'] = Verta::create($splitPaytime[0], $splitPaytime[1], $splitPaytime[2], 00, 00, 00)->formatJalaliDate();
                        if ($qest->paytarikh != null) {
                            $splitPaytarikh = explode('-', Date::create($qest->paytarikh)->toDateString());
                            $order['aqsat'][$key]['pardakhti'] = Verta::create($splitPaytarikh[0], $splitPaytarikh[1], $splitPaytarikh[2], 00, 00, 00)->formatJalaliDate();
                        }
                        if ($qest->status == '0') {
                            $order['aqsat'][$key]['vaziat'] = 'پرداخت نشده';
                        } elseif ($qest->status == '1') {
                            $order['aqsat'][$key]['vaziat'] = 'پرداخت شده';
                        }
                    }

                    $order['pastTarikh'] = $pastTarikh;


                } elseif ($order->statusmali[0]->naqdtype != null) {

                    $order['naqditype'] = $order->statusmali[0]->naqdtype;
                    foreach ($order->naqditype as $naqd) {
                        $naqd['mablagh'] = $naqd->pivot->mablagh;
                    }
                }
                if ($order->statusmali[0]->status == 'o') {
                    $order['statusmalis'] = 'باز';
                } elseif ($order->statusmali[0]->status == 'd') {
                    $order['statusmalis'] = 'تسویه شده';
                } elseif ($order->statusmali[0]->status == 'c') {
                    $order['statusmalis'] = 'کنسل شده';
                }

                $order['fullname'] = $order->user->name . ' ' . $order->user->family;
                $order['takhtnumber'] = $order->takht->takhtnumber;
                $order['mobilecode'] = $order->user->mobilecode;
                $order['ncode'] = $order->user->ncode;
                $order['roomnumber'] = $order->takht->room->roomnumber;
                $order['karshenasName'] = $order->karshenas->name . ' ' . $order->karshenas->family;
                $order['pansionname'] = $order->takht->room->pansion->name;
                $order['vaziat'] = $order->statusOrder->title;
                $order['pansionname'] = $order->takht->room->pansion->name;
                $splitRaft = explode('-', $order->raft);
                $splitBargasht = explode('-', $order->bargasht);
                $splitRaft = explode('-', $order->raft);
                $splitBargasht = explode('-', $order->bargasht);
                $order['jalaliRaft'] = Verta::create($splitRaft[0], $splitRaft[1], $splitRaft[2], 00, 00, 00)->formatJalaliDate();
                $order['jalaliBargasht'] = Verta::create($splitBargasht[0], $splitBargasht[1], $splitBargasht[2], 00, 00, 00)->formatJalaliDate();
                $order['raftjalali'] = Verta::create($splitRaft[0], $splitRaft[1], $splitRaft[2], 00, 00, 00)->format('Y/m/d');
                $order['bargashtjalali'] = Verta::create($splitBargasht[0], $splitBargasht[1], $splitBargasht[2], 00, 00, 00)->format('Y/m/d');
            }
        }
        return count($orders) != 0 ? $orders : 'notfound';
    }

//    =================== zizi
    public function getOrdersByActiveInTakhtArray($takhtArray)
    {
        return $orders = Order::where('status_order_id', 1)->whereIn('takht_id', $takhtArray)->pluck('takht_id');
    }


    // دریافت وضعیت سفارش: کل مبلغ سفارش پس از کسر تخفیف + کل مبلغ پرداخت شده توسط مشتری
    public function getOrderTotalPrice($orderId)
    {
        $order = Order::FindOrFail($orderId);
        $order_total_price = intval($order->statusmali->order_finally_price);     // order price that customer must pay
        $paid_amount = intval($order->statusmali->total_wallet_amount_paid +
                       $order->statusmali->total_dargah_amount_paid +
                       $order->statusmali->total_naghdi_amount_paid +
                       $order->statusmali->total_qest_amount_paid);

        return [
            'totalprice' => $order_total_price,
            'paid_amount' => $paid_amount
        ];
    }



    // لغو یک سفارش
    public function cancelorder($data)
    {

       // initial data
        $orderId = $data['orderId'];
        $paid_amount = $data['paid_amount'];
        $returnVajhToCustomer = $data['returnVajhToCustomer'];
        $jarime = $data['jarime'] ?? 0;
        $jarime_pay_way = $data['jarime_pay_way'];
        $returningfish = $data['returningfish'];
        $jarimefish = $data['jarimefish'];


        DB::beginTransaction();
    //================ ORDER TABLE START=====
        $order = Order::FindOrFail($orderId);                  // 1. find order
        $order->status_order_id = Statusorder::CANCELLED;      // change status_order_id to `cancelled` state
        $order->canceled_at = Carbon::now();                   // save cancel time

        if($order->save()) {

        //============ ORDERARCHIVE TABLE  ======
            // save current order status to orderarchive table
            $orderArchive = new Orderarchive(array('status_order_id' => Statusorder::CANCELLED));
            $order->orderarchives()->save($orderArchive);

        //=========== QEST TABLE ========
            // if cutomer has any qest for this order, update all qest statuses to `-1` -> means order is cancelled.
            if($order->qests()->count() > 0) {
                foreach($order->qests as $qest) {
                    $qest->status = -1;   // update status to cancel
                    $qest->save();
                }
            }
        //================ STATUSMALI TABLE =======
            $statusmali = Statusmali::FindOrFail($orderId);
            ($jarime > 0)  ?  $statusmali->financial_status = 'vajh_returned_jarime' : 'vajh_returned';
            $statusmali->status_order_id = Statusorder::CANCELLED;
            $statusmali->save();


        //================ JARIME TABLE =======
            // jarimeId is equal to orderId
            if($jarime > 0) {
                $jarimeTransactionId = $this->jarimeService->createNewJarime([
                    'id' => $order->id,
                    'tarikh' => Date::now(),     // تاریخ دریافت جریمه
                    'amount' => $jarime,     // مقدار جریمه
                    'status' => $jarime_pay_way == '4' ? '0' : '1',
                    'title' => 'دریافت جریمه بابت کنسلی رزرو',
                    'jarime_pay_type' => $jarime_pay_way,
                    'user_id' => $order->user_id,
                    'fish_path' => $jarimefish,
                ]);
            }



        // transactions for wallet/or /returned amount to customer and jarime
            if( ($paid_amount > 0)  &&  ($returnVajhToCustomer > 0) ) {    // بازگشت وجه به مشتری

                $returnVajhToCustomerTransactionId = $this->transactionService->createTransaction([
                    'order_id' => $order->id,
                    'user_id' => $order->user_id,
                    'karshenas_id' => Auth::id(),
                    'transactiontype_id' => Transactiontype::BAZGASHT_VAJH_BE_CUSTOMER,
                    'price' => $returnVajhToCustomer,
                    'fish_path' => $returningfish ?? '',
                    'status' => 'success',
                    'type' => 'bardasht',    // برداشت از حساب پانسیون
                ]);

                // statusmalichangedorders
                $this->statusmalichangedorderService->createStatusmalichanedorder([
                    'id' => $order->id,
                    'status_order_id' => Statusorder::CANCELLED,
                    'order_finally_price' => $statusmali->order_finally_price,
                    'total_paid_amount' => intval($statusmali->total_wallet_amount_paid) + intval($statusmali->total_dargah_amount_paid) + intval($statusmali->total_naghdi_amount_paid) + intval($statusmali->total_qest_amount_paid),
                    'returntocustom_tranaction_id' => $returnVajhToCustomerTransactionId,
                    'returned_to_customer_amount' => $returnVajhToCustomer,
                    'returned_to_wallet_amount' => 0,
                    'returntowallet_tranaction_id' => null,
                    'returned_type' => 'naqd',
                    'has_jarime' => $jarime > 0 ? '1' : '0',
                    'jarime_amount' => $jarime > 0 ?: 0,
                    'jarime_is_paid' => $jarime_pay_way == 4 ? '0' : '1',
                    'jarime_tranaction_id' => $jarime > 0 ? $jarimeTransactionId : null,
                ]);



                // usertotalstatusmali -> return_vajh to customer, bedehi, pardakhti
                // kole mablaghe sefaresh az `bedehi` va `pardakhti` kasr shod. agar jarime vojood dasht, dar bakhshe jarime be
                // mablaghe bedehi va pardakhti ezafe mishe.
                $bedehiChangeAmount = -1 * $orderId->statusmali->order_finally_price;   // decrease bedehi
                $pardakhtiChangeAmount = -1 * $orderId->statusmali->order_finally_price;   // decrease pardakhti
                $this->usertotalstatusmaliService->updateUsertotalstatusmali([
                                                                                $order->user_id,
                                                                                $walletUsedAmount = 0,
                                                                                $walletChangeAmount = 0,
                                                                                $bedehiChangeAmount = intval($bedehiChangeAmount),
                                                                                $pardakhtiChangeAmount = intval($pardakhtiChangeAmount),
                                                                                $jarimeBedehkarChangeAmount = 0,
                                                                                $jarimePardakhtiChangeAmount = 0,
                                                                                $returnedAmountChanged = $returnVajhToCustomer
                                                                            ]);

                // usertotalstatusmalitransaction -> return_To_Customer,  bedehi, pardakhti
                $this->usertotalstatusmalitransactionsService->createUsertotalstatusmalitransaction([
                    'usertotalstatusmalis_id' => $order->user_id,
                    'transaction_id' => $returnVajhToCustomerTransactionId,
                    'order_id' => $order->id,
                    'bedehi_changed_amount' => intval($bedehiChangeAmount),
                    'bedehi_change_type' => '-1',
                    'pardakhti_changed_amount' => intval($bedehiChangeAmount),
                    'pardakhti_change_type' => '-1',
                    'returned_amount_to_customer' => $returnVajhToCustomer,
                    'returned_amount_to_customer_type' => 'naqd',
                ]);


            } elseif ( ($paid_amount > 0)  &&  ($returnVajhToCustomer == 0) ) {   // بازگشت وجه به کیف پول مشتری

                 // wallet mojoodi update
                // transaction for wallet
                // new wallettransaction record
                // usertotalstatusmali -> walletmojoodi, return_vajh to customer, ..
                // usertotalstatusmalitransaction -> wallet
                $increaseWalletTransactionId = $this->walletService->walletIncreaseForReturningVajh($order->user_id, $orderId->statusmali->order_finally_price, $order->id, 'بازگشت وجه به کیف پول');

                // statusmalichangedorders
                $this->statusmalichangedorderService->createStatusmalichanedorder([
                    'id' => $order->id,
                    'status_order_id' => Statusorder::CANCELLED,
                    'order_finally_price' => $statusmali->order_finally_price,
                    'total_paid_amount' => intval($statusmali->total_wallet_amount_paid) + intval($statusmali->total_dargah_amount_paid) + intval($statusmali->total_naghdi_amount_paid) + intval($statusmali->total_qest_amount_paid),
                    'returned_to_wallet_amount' => $statusmali->order_finally_price,
                    'returntowallet_tranaction_id' => $increaseWalletTransactionId,
                    'returned_type' => 'wallet',
                    'has_jarime' => $jarime > 0 ? '1' : '0',
                    'jarime_amount' => $jarime > 0 ?: 0,
                    'jarime_is_paid' => $jarime_pay_way == 4 ? '0' : '1',
                    'jarime_tranaction_id' => $jarime > 0 ? $jarimeTransactionId : null,
                ]);

                $bedehiChangeAmount = -1 * $orderId->statusmali->order_finally_price;   // decrease bedehi
                $pardakhtiChangeAmount = -1 * $orderId->statusmali->order_finally_price;   // decrease pardakhti
                $this->usertotalstatusmaliService->updateUsertotalstatusmali([
                    $order->user_id,
                    $walletUsedAmount = 0,
                    $walletChangeAmount = 0,
                    $bedehiChangeAmount = intval($bedehiChangeAmount),
                    $pardakhtiChangeAmount = intval($pardakhtiChangeAmount),
                    $jarimeBedehkarChangeAmount = 0,
                    $jarimePardakhtiChangeAmount = 0,
                    $returnedAmountChanged = $returnVajhToCustomer
                ]);

                // usertotalstatusmalitransaction -> return_To_Customer,  bedehi, pardakhti
                $this->usertotalstatusmalitransactionsService->createUsertotalstatusmalitransaction([
                    'usertotalstatusmalis_id' => $order->user_id,
                    'transaction_id' => $increaseWalletTransactionId,
                    'order_id' => $order->id,
                    'bedehi_changed_amount' => intval($bedehiChangeAmount),
                    'bedehi_change_type' => '-1',
                    'pardakhti_changed_amount' => intval($bedehiChangeAmount),
                    'pardakhti_change_type' => '-1',
                    'returned_amount_to_customer' => $returnVajhToCustomer,
                    'returned_amount_to_customer_type' => 'wallet',
                ]);

            }

            DB::commit();
            return true;

        } else {
            DB::rollBack();
            throw new ModelNotSavedException('Order model not saved successfully in Class: ' . get_class($this) . ' Method: '  . __FUNCTION__ );

        }

    }


} // end of class
