<?php

namespace App\Services\Admin\Statusmali;

use App\Models\Usertotalstatusmalitransaction;

class UsertotalstatusmalitransactionsService
{


    public function createUsertotalstatusmalitransaction($data)
    {
        // Notes:
        // there is one to one relation bw user and usertotalstatusmali

        $defaultData = [
            'usertotalstatusmalis_id' => '',
            'transaction_id' => null,
            'order_id' => null,
            'wallet_changed_amount' => null,
            'wallet_change_type' => null,
            'jarime_amount' => null,
            'jarime_paid' => null,
            'bedehi_changed_amount' => null,
            'bedehi_change_type' => null,
            'pardakhti_changed_amount' => null,
            'pardakhti_change_type' => null,
            'returned_amount_to_customer' => null,
            'returned_amount_to_customer_type' => null,
        ];

        $mainData = array_merge($defaultData, $data);

        $usertotalstatusmalitransactions = new Usertotalstatusmalitransaction();
        $usertotalstatusmalitransactions->usertotalstatusmalis_id = $mainData['usertotalstatusmalis_id'];
        $usertotalstatusmalitransactions->transaction_id = $mainData['transaction_id'];
        $usertotalstatusmalitransactions->order_id = $mainData['order_id'];
        $usertotalstatusmalitransactions->wallet_changed_amount = $mainData['wallet_changed_amount'];
        $usertotalstatusmalitransactions->wallet_change_type = $mainData['wallet_change_type'];
        $usertotalstatusmalitransactions->jarime_amount = $mainData['jarime_amount'];
        $usertotalstatusmalitransactions->jarime_paid = $mainData['jarime_paid'];
        $usertotalstatusmalitransactions->bedehi_changed_amount = $mainData['bedehi_changed_amount'];
        $usertotalstatusmalitransactions->bedehi_change_type = $mainData['bedehi_change_type'];
        $usertotalstatusmalitransactions->pardakhti_changed_amount = $mainData['pardakhti_changed_amount'];
        $usertotalstatusmalitransactions->pardakhti_change_type = $mainData['pardakhti_change_type'];
        $usertotalstatusmalitransactions->returned_amount_to_customer = $mainData['returned_amount_to_customer'];
        $usertotalstatusmalitransactions->returned_amount_to_customer_type = $mainData['returned_amount_to_customer_type'];

        if($usertotalstatusmalitransactions->save()) {
            return true;
        }

        return false;

    }
}
