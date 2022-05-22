<?php


namespace App\Services\Admin\Statusmali;


use App\Models\Statusmalistransaction;
use Illuminate\Database\Eloquent\Model;

class StatusmalitransactionService
{

    // create new statusmalitransaction
    public function createStatusmalitransaction($data)
    {

        $defaultData = [
            'statusmali_id' => '',
            'transaction_id' => null,
            'order_id' => null,
            'status_order_id' => null,
            'order_total_price_before_takhfif' => null,
            'takhfif' => null,
            'order_finally_price' => null,
            'wallet_amount_paid' => null,
            'dargah_amount_paid' => null,
            'naghdi_amount_paid' => null,
            'qest_amount_paid' => null,
            'maande_amount' => null,
            'financial_status' => null
        ];

        $mainData = array_merge($defaultData, $data);

        $statusmalistransaction = new Statusmalistransaction();
        $statusmalistransaction->statusmali_id = $mainData['statusmali_id'];
        $statusmalistransaction->transaction_id = $mainData['transaction_id'];
        $statusmalistransaction->order_id = $mainData['order_id'];
        $statusmalistransaction->status_order_id = $mainData['status_order_id'];
        $statusmalistransaction->order_total_price_before_takhfif = $mainData['order_total_price_before_takhfif'];
        $statusmalistransaction->takhfif = $mainData['takhfif'];
        $statusmalistransaction->order_finally_price = $mainData['order_finally_price'];
        $statusmalistransaction->wallet_amount_paid = $mainData['wallet_amount_paid'];
        $statusmalistransaction->dargah_amount_paid = $mainData['dargah_amount_paid'];
        $statusmalistransaction->naghdi_amount_paid = $mainData['naghdi_amount_paid'];
        $statusmalistransaction->qest_amount_paid = $mainData['qest_amount_paid'];
        $statusmalistransaction->maande_amount = $mainData['maande_amount'];
        $statusmalistransaction->financial_status = $mainData['financial_status'];

        if($statusmalistransaction->save()) {
            return true;
        }

        return false;

    }
}
