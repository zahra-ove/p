<?php


namespace App\Services\Admin\Wallet;


use App\Exceptions\WalletException;
use App\Models\Statusmalistransaction;
use App\Models\Transaction;
use App\Models\Transactiontype;
use App\Models\Usertotalstatusmalitransaction;
use App\Models\Wallet;
use App\Models\wallettransaction;
use App\Services\Admin\Statusmali\StatusmalitransactionService;
use App\Services\Admin\Statusmali\UsertotalstatusmaliService;
use App\Services\Admin\Statusmali\UsertotalstatusmalitransactionsService;
use App\Services\Admin\Transaction\TransactionService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class WalletService
{


    private $transactionService;
    private $statusmalitransactionService;
    private $usertotalstatusmaliService;
    private $usertotalstatusmalitransactionsService;

    /**
     * WalletService constructor.
     */
    public function __construct(StatusmalitransactionService $statusmalitransactionservice,
                                UsertotalstatusmaliService $usertotalstatusmaliService,
                                UsertotalstatusmalitransactionsService $usertotalstatusmalitransactionsService,
                                TransactionService $transactionService
    )
    {
        $this->statusmalitransactionService = $statusmalitransactionservice;
        $this->usertotalstatusmaliService = $usertotalstatusmaliService;
        $this->usertotalstatusmalitransactionsService = $usertotalstatusmalitransactionsService;
        $this->transactionService = $transactionService;
    }

    public function cash($userId, $price, $fish)
    {
        $wallet=Wallet::with('user')->where('user_id',$userId)->first();
        $wallet->bedehkar=$wallet->bedehkar+$price;
        $transaction=new Transaction();
        $transaction->price=$price;
        $transaction->user_id=$userId;
        $transaction->transactiontype_id=6;
        if ($fish!=null){
            $filename = $fish->getClientOriginalName();
            $path = 'storage/images/fish/' . $filename;
            $fish->storeAs('public/images/fish/', $filename);
            $transaction->fish = $path;
        }
        DB::beginTransaction();
        if ($wallet->save()){
            $transaction->save();
            DB::commit();
            return 'ok';
        }
        else{
            DB::rollBack();
            return 'notfound';
        }

    }

    public function deposite($userId,$price,$fish)
    {

        $wallet=Wallet::with('user')->where('user_id',$userId)->first();

        $wallet->bedehkar=$wallet->bedehkar-$price;
        $transaction=new Transaction();
        $transaction->price=$price;
        $transaction->user_id=$userId;
        $transaction->transactiontype_id=7;
        if ($fish!=null){
            $filename = $fish->getClientOriginalName();
            $path = 'storage/images/fish/' . $filename;
            $fish->storeAs('public/images/fish/', $filename);
            $transaction->fish = $path;
        }

        DB::beginTransaction();
        if ($wallet->save()){
            $transaction->save();
            DB::commit();
            return 'ok';
        }
        else{
            DB::rollBack();
            return 'notfound';
        }

    }



    //=====

// برداشت از کیف پول برای پرداخت هزینه رزرو
    public function walletDecreaseForReservation($userId, $amount, $order_id, $status_order_id,$description='')
    {
        // wallet changes
        $wallet = Wallet::findOrFail($userId);   // wallet has one to one relation with user
        if($wallet->mojoodi < $amount) {
            throw new WalletException("موجودی کیف پول کافی نیست!");
        }
        $wallet->mojoodi = intval($wallet->mojoodi) - intval($amount);      // کاهش مقدار کیف پول

        DB::beginTransaction();
        if ($wallet->save()) {
            // save record for transaction related to this wallet
            $transaction = new Transaction();
            $transaction->order_id = $order_id;
            $transaction->user_id = $userId;
            $transaction->karshenas_id = Auth::id();
            $transaction->wallet_id = $wallet->id;
            $transaction->transactiontype_id = Transactiontype::BARDASHT_WALLET_FOR_RESERVE;
            $transaction->price = $amount;
            $transaction->status = 'success';
            $transaction->type = 'variz';         // تراکنش از نوع واریز به حساب پانسیون

            if($transaction->save()) {
                // archive wallettransaction
                $wallettransaction = new Wallettransaction();
                $wallettransaction->wallet_id = $wallet->id;
                $wallettransaction->amount = $amount;                       // مبلغ برداشت شده از کیف پول
                $wallettransaction->description = $description;
                $wallettransaction->transaction_type = 'bardasht';     // برداشت
                $wallettransaction->tarikh = Carbon::now();

                //one to one relation bw `transaction` and `wallettransactions` table
                $transaction->wallettransaction()->save($wallettransaction);



                // add record to statusmalitransaction
                $this->statusmalitransactionService->createStatusmalitransaction([
                    'statusmali_id' => $order_id,
                    'transaction_id' => $transaction->id,
                    'order_id' => $order_id,
                    'wallet_amount_paid' => $amount,
                    'status_order_id' => $status_order_id,
                ]);


                // update usertotalstatusmali(totalfins)
                $walletChangeAmount = -1 * abs($amount);
                $this->usertotalstatusmaliService->updateUsertotalstatusmali($userId, $amount, $walletChangeAmount, );



                // update wallet column  in usertotalstatusmalitransactions for this order
                $data = [
                    'usertotalstatusmalis_id' => $userId,
                    'transaction_id' => $transaction->id,
                    'order_id' => $order_id,
                    'pardakhti_changed_amount' => $amount,
                    'pardakhti_change_type' => '1',
                    'wallet_changed_amount' => $amount,
                    'wallet_change_type' => '-1',
                ];
                $this->usertotalstatusmalitransactionsService->createUsertotalstatusmalitransaction($data);

            }

            DB::commit();
            return true;

        } else {
            DB::rollBack();
            return false;
        }


    }

    public function getWalletMojoodiForSpecifcUser($userId)
    {
        $wallet = Wallet::findOrFail($userId);
        return $wallet->mojoodi;
    }


    public function walletDecreaseForJarime($userId, $amount, $order_id, $description='')
    {
        // wallet changes
        $wallet = Wallet::findOrFail($userId);   // wallet has one to one relation with user
        if($wallet->mojoodi < $amount) {
            throw new WalletException("موجودی کیف پول کافی نیست!");
        }
        $wallet->mojoodi = intval($wallet->mojoodi) - intval($amount);      // کاهش مقدار کیف پول

        DB::beginTransaction();
        if ($wallet->save()) {
            // save record for transaction related to this wallet
            $transaction = new Transaction();
            $transaction->order_id = $order_id;
            $transaction->user_id = $userId;
            $transaction->karshenas_id = Auth::id();
            $transaction->wallet_id = $wallet->id;
            $transaction->transactiontype_id = Transactiontype::JARIME_WALLET;       // کسر از کیف پول بابت جریمه
            $transaction->price = $amount;
            $transaction->status = 'success';
            $transaction->type = 'variz';                                 // تراکنش از نوع واریز به حساب پانسیون

            if($transaction->save()) {
                // archive wallettransaction
                $wallettransaction = new Wallettransaction();
                $wallettransaction->wallet_id = $wallet->id;
                $wallettransaction->amount = $amount;                       // مبلغ برداشت شده از کیف پول
                $wallettransaction->description = $description;
                $wallettransaction->transaction_type = 'bardasht';     // برداشت
                $wallettransaction->tarikh = Carbon::now();

                //one to one relation bw `transaction` and `wallettransactions` table
                $transaction->wallettransaction()->save($wallettransaction);


                // update usertotalstatusmali(totalfins)
                $walletChangeAmount = -1 * abs($amount);
                $this->usertotalstatusmaliService->updateUsertotalstatusmali($userId, $amount, $walletChangeAmount);



                // update wallet column  in usertotalstatusmalitransactions for this order
                $data = [
                    'usertotalstatusmalis_id' => $userId,
                    'transaction_id' => $transaction->id,
                    'order_id' => $order_id,
                    'wallet_changed_amount' => $amount,
                    'wallet_change_type' => '-1',
                ];
                $this->usertotalstatusmalitransactionsService->createUsertotalstatusmalitransaction($data);

            }

            DB::commit();
            return true;

        } else {
            DB::rollBack();
            return false;
        }

    }


    // واریز وجه پرداختی مربوط به رزرو کنسل شده به کیف پول کاربر
    public function walletIncreaseForReturningVajh($userId, $amount, $order_id, $description='')
    {
        // wallet changes
        $wallet = Wallet::findOrFail($userId);   // wallet has one to one relation with user
        $wallet->mojoodi = intval($wallet->mojoodi) + intval($amount);      // افزایش موجودی کیف پول

        DB::beginTransaction();
        if ($wallet->save()) {

            // save record for transaction related to this wallet
            $increaseWalletTransactionId = $this->transactionService->createTransaction([
                'order_id' => $order_id,
                'user_id' => $userId,
                'karshenas_id' => Auth::id(),
                'wallet_id' => $wallet->id,
                'transactiontype_id' => Transactiontype::BAZGASHT_TO_WALLET,
                'price' => $amount,
                'status' => 'success',
                'type' => 'bardasht',    // تراکنش از نوع برداشت از حساب پانسیون
            ]);


            // archive wallettransaction
            //one to one relation bw `transaction` and `wallettransactions` table
            $wallettransaction = new Wallettransaction();
            $wallettransaction->id = $increaseWalletTransactionId;
            $wallettransaction->wallet_id = $wallet->id;
            $wallettransaction->amount = $amount;                       // مبلغ برداشت شده از کیف پول
            $wallettransaction->description = $description;
            $wallettransaction->transaction_type = 'variz';     // واریز به کیف پول
            $wallettransaction->tarikh = Carbon::now();
            $wallettransaction->save();



            // update usertotalstatusmali(totalfins)
            $walletChangeAmount =  abs($amount);
            $this->usertotalstatusmaliService->updateUsertotalstatusmali($userId, $amount, $walletChangeAmount);



            // update wallet column  in usertotalstatusmalitransactions for this order
            $data = [
                'usertotalstatusmalis_id' => $userId,
                'transaction_id' => $increaseWalletTransactionId,
                'order_id' => $order_id,
                'wallet_changed_amount' => $amount,
                'wallet_change_type' => '1',
            ];
            $this->usertotalstatusmalitransactionsService->createUsertotalstatusmalitransaction($data);



            DB::commit();
            return $increaseWalletTransactionId;

        } else {
            DB::rollBack();
            return false;
        }

    }

}
