<?php

namespace App\Services\Admin\Statusmali;

use App\Models\Usertotalstatusmali;

class UsertotalstatusmaliService
{

    public function updateUsertotalstatusmali($userId, $walletUsedAmount = 0,
                                              $walletChangeAmount = 0,
                                              $bedehiChangeAmount = 0,
                                              $pardakhtiChangeAmount = 0,
                                              $jarimeBedehkarChangeAmount = 0,
                                              $jarimePardakhtiChangeAmount = 0,
                                              $returnedAmountChanged = 0
    )
    {

        if(Usertotalstatusmali::where('id', $userId)->exists()) {
            $usertotalstatusmali = Usertotalstatusmali::where('id', $userId)->first();
        } else {
            $usertotalstatusmali = new Usertotalstatusmali();
            $usertotalstatusmali->id = $userId;

        }

        $usertotalstatusmali->total_wallet_used_amount +=  intval($walletUsedAmount);
        $usertotalstatusmali->total_wallet_mojoodi += intval($walletChangeAmount);
        $usertotalstatusmali->total_user_bedehi += intval($bedehiChangeAmount);
        $usertotalstatusmali->total_user_pardakhti += intval($pardakhtiChangeAmount);
        $usertotalstatusmali->total_jarime_bedehkar += intval($jarimeBedehkarChangeAmount);
        $usertotalstatusmali->total_jarime_pardakhti += intval($jarimePardakhtiChangeAmount);
        $usertotalstatusmali->total_returned_amount_to_customer += intval($returnedAmountChanged);


        if($usertotalstatusmali->save()){
            return true;
        }
        return false;
    }
}
