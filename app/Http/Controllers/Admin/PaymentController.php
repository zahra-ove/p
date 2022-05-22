<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
//use App\Services\Payment\Contracts\Payment;
use App\Models\Order;
use App\Models\Takht;
use App\Models\Transaction;
use App\Models\Transactiontype;
use App\Services\Payment\ZarinpalImp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;

class PaymentController extends Controller
{

    public function getpayform()
    {
        return view('payform');
    }


    public function pay(Request $request)
    {
        $takhtId = (int)$request->input('takht_id');
        $userId = (int)$request->input('user_id');
        $description = $request->input('description');
        $amount = $request->input('amount');
        $raft = $request->input('raft');
        $bargasht = $request->input('bargasht');


        $takht = Takht::findOrFail($takhtId);
        $takhtNumber = $takht->takhtnumber;              // takht number
        $roomNumber = $takht->room->roomnumber;        // room number
        $pansionName = $takht->room->pansion->name;   //pansion name

        //@todo : اتاق قبلا رزرو شده و اردر اون ایجاد شده، باید اوردر رو پیدا کنم
        $newOrder = new Order();
        $newOrder->takht_id = $takhtId;
        $newOrder->user_id = $userId;
        $newOrder->raft = $raft;
        $newOrder->bargasht = $bargasht;
        $newOrder->karshenas_id = Auth::id();
        $newOrder->save();


        $invoice = new Invoice();
        $invoice->amount($amount);
        $invoice->detail(['detailName' =>  " تخت با شماره $takhtNumber اتاق $roomNumber از پانسیون $pansionName"]);


        $newTransaction = new Transaction();
        $newTransaction->order_id = $newOrder->id;
        $newTransaction->user_id = $userId;
        $newTransaction->price = $amount;
        $newTransaction->transactiontype_id = Transactiontype::PARDAKHT;
        $newTransaction->dargah_name = $invoice->getDriver();

        $payment = Payment::callbackUrl(route('pay.verify'));   //verify link

        return $payment->purchase($invoice, function($driver, $transactionId) use ($newTransaction){
            $newTransaction->authority = $transactionId;
            $newTransaction->save();

        })->pay()->render();
    }


    public function verify(Request $request)
    {
        $authority = $request->Authority;
        $transation = Transaction::where('authority', $authority)->first();
        $price = $transation->price;

        $receipt = Payment::amount($price)
            ->transactionId($authority)
            ->verify();

        $transation->ref_id = $receipt->getReferenceId();
        $transation->dargah_name = $receipt->getDriver();
        $transation->save();


        if($receipt->getReferenceId()) {
            return back()->with('status', 'successful');
        }
    }


}
