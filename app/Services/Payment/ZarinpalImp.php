<?php

namespace App\Services\Payment;

use App\Exceptions\CurlErrorException;
use App\Exceptions\UserNotFoundException;
use App\Models\Order;
use App\Models\Transaction;
use App\Services\Admin\Transaction\TransactionService;
use App\Services\Payment\Contracts\Payment;
use App\Services\Admin\User\UserService;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class ZarinpalImp implements Payment
{

    public function pay($takhtId, $userId, $description, $amount, $raft, $bargasht)
    {
        //find user
        $user = UserService::getUserService()->getUserById($userId);
        if($user == 'notfound')
            throw new UserNotFoundException('user with id: '. $userId . ' not found');

        $data = array(
            "merchant_id" => config('payment.zarinpal.merchant'),
            "amount" => $amount,
            "callback_url" => "/varify",
            "description" => $description,
            "metadata" => [ "email" => $user->email,"mobile" => $user->mobileCode],
        );

        $jsonData = json_encode($data);

//        $ch = curl_init('https://api.zarinpal.com/pg/v4/payment/request.json');
        $ch = curl_init('https://sandbox.zarinpal.com/pg/v4/payment/request.json');

        curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v1');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        ));

        $result = curl_exec($ch);
        $err = curl_error($ch);
        $result = json_decode($result, true, JSON_PRETTY_PRINT);
        curl_close($ch);



        if ($err) {
            throw new CurlErrorException("zarinpal payment exception in curl with error " . $err);
        } else {
            if (empty($result['errors'])) {
                dd($result);
                if ($result['data']['code'] == 100) {

                    $order = Order::create([
                        'user_id' => $user->id,
                        'takht_id' => $takhtId,
                        'raft' => $raft,
                        'bargasht' => $bargasht,
                    ]);

                    if($order) {
                        $transaction = Transaction::create([
                            'order_id' => $order->id,
                            'user_id'  => $user->id,
                            'price'    => $amount,
                            'transactiontype_id' => 1,
                            'authority' => $result['data']["authority"],
                        ]);
                    }
                    if($transaction)
//                        return redirect('https://www.zarinpal.com/pg/StartPay/' . $result['data']["authority"]);
                        return redirect('https://sandbox.zarinpal.com/pg/StartPay/' . $result['data']["authority"]);
                }

            } else {
                throw new CurlErrorException("zarinpal payment exception in curl with error " . $result['errors']);
            }
        }
    }



    public function verify($authority)
    {
        //find transaction
        $transaction = TransactionService::getTransactionService()->getTransactionByAuthority($authority);

        $data = array(
            "merchant_id" => config('payment.zarinpal.merchant'),
            "authority" => $authority,
            "amount" => $transaction->price,
        );

        $jsonData = json_encode($data);
//        $ch = curl_init('https://api.zarinpal.com/pg/v4/payment/verify.json');
        $ch = curl_init('https://sandbox.zarinpal.com/pg/v4/payment/verify.json');
        curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v4');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        ));

//        $result = curl_exec($ch);
//        curl_close($ch);
//        $result = json_decode($result, true);



        $result = curl_exec($ch);
        $err = curl_error($ch);
        $result = json_decode($result, true, JSON_PRETTY_PRINT);
        curl_close($ch);


        if ($err) {
            throw new CurlErrorException("zarinpal payment verification exception in curl with error " . $err);
        } else {
            if ($result['data']['code'] == 100) {
                $transaction->ref_id = $result['data']['ref_id'];
                if($transaction->save()) {
                    return  $result['data']['ref_id'];
                }
            } else {
                throw new CurlErrorException("zarinpal payment verification exception in curl with error " . $result['errors']);
            }
        }
    }
}
