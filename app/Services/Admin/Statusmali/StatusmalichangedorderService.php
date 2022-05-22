<?php


namespace App\Services\Admin\Statusmali;


use App\Models\Statusmalichangedorder;
use App\Models\Statusorder;
use Illuminate\Database\Eloquent\Model;

class StatusmalichangedorderService
{
    public function createStatusmalichanedorder($data)
    {
        $defaultData = [
            'id' => null,
            'status_order_id' => null,
            'order_finally_price' => null,
            'total_paid_amount' => null,
            'returntocustom_tranaction_id' => null,
            'returned_to_customer_amount' => null,
            'returned_to_wallet_amount' => null,
            'returntowallet_tranaction_id' => null,
            'returned_type' => null,
            'has_jarime' => null,
            'jarime_amount' => null,
            'jarime_is_paid' => null,
            'jarime_tranaction_id' => null,
        ];

        $mainData = array_merge($defaultData, $data);

        $statusmaliChangedOrders = new Statusmalichangedorder();
        $statusmaliChangedOrders->id = $mainData['id'];
        $statusmaliChangedOrders->status_order_id = $mainData['status_order_id'];

        $statusmaliChangedOrders->returntocustom_tranaction_id = $mainData['returntocustom_tranaction_id'];
        $statusmaliChangedOrders->returntowallet_tranaction_id = $mainData['returntowallet_tranaction_id'];
        $statusmaliChangedOrders->jarime_tranaction_id = $mainData['jarime_tranaction_id'];

        $statusmaliChangedOrders->order_finally_price = $mainData['order_finally_price'];
        $statusmaliChangedOrders->total_paid_amount = $mainData['total_paid_amount'];
//        $statusmaliChangedOrders->total_paid_amount = intval($statusmali->total_wallet_amount_paid) + intval($statusmali->total_dargah_amount_paid) + intval($statusmali->total_naghdi_amount_paid) + intval($statusmali->total_qest_amount_paid);


        $statusmaliChangedOrders->returned_to_customer_amount = $mainData['returned_to_customer_amount'];
        $statusmaliChangedOrders->returned_to_wallet_amount = $mainData['returned_to_wallet_amount'];
        $statusmaliChangedOrders->returned_type = $mainData['returned_type'];

        $statusmaliChangedOrders->has_jarime = $mainData['has_jarime'];
        $statusmaliChangedOrders->jarime_amount = $mainData['jarime_amount'];
        $statusmaliChangedOrders->jarime_is_paid = $mainData['jarime_is_paid'];

//        if($jarime > 0) { // کنسلی شامل جریمه شده
//            $statusmaliChangedOrders->has_jarime = $mainData['has_jarime'];
//            $statusmaliChangedOrders->jarime_amount = $mainData['jarime_amount'];
//            $statusmaliChangedOrders->jarime_is_paid = $mainData['jarime_is_paid'];
//        } else {  // کنسلی شامل جریمه نشده
//            $statusmaliChangedOrders->has_jarime = '0';
//            $statusmaliChangedOrders->jarime_amount = 0;
//            $statusmaliChangedOrders->jarime_is_paid = '0';
//        }



        if($statusmaliChangedOrders->save()) {
            return true;
        }

        return false;

    }
}
