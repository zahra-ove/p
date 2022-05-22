<?php


namespace App\Services\Admin\Jarime;


use App\Models\Jarime;
use App\Models\Transactiontype;
use App\Services\Admin\Statusmali\StatusmalichangedorderService;
use App\Services\Admin\Statusmali\StatusmalitransactionService;
use App\Services\Admin\Statusmali\UsertotalstatusmaliService;
use App\Services\Admin\Statusmali\UsertotalstatusmalitransactionsService;
use App\Services\Admin\Transaction\TransactionService;
use App\Services\Admin\Wallet\WalletService;
use App\Services\Sms\Sms;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class JarimeService
{

    public function __construct(
                                WalletService $walletService,
                                TransactionService $transactionService,
                                StatusmalitransactionService $statusmalitransactionService,
                                UsertotalstatusmaliService $usertotalstatusmaliService,
                                UsertotalstatusmalitransactionsService $usertotalstatusmalitransactionsService,
                                StatusmalichangedorderService $statusmalichangedorderService
    )
    {
        $this->walletService = $walletService;
        $this->transactionService = $transactionService;
        $this->statusmalitransactionService = $statusmalitransactionService;
        $this->usertotalstatusmaliService = $usertotalstatusmaliService;
        $this->usertotalstatusmalitransactionsService = $usertotalstatusmalitransactionsService;
        $this->statusmalichangedorderService = $statusmalichangedorderService;
    }

    public function createNewJarime($data)
    {
        $defaultData = [
            'id' => null,           // one to one relation bw `jarime` and `order` table
            'tarikh' => null,     // تاریخ دریافت جریمه
            'amount' => null,     // مقدار جریمه
            'status' => null,
            'title' => null,
            'jarime_pay_type' => null,
            'user_id' => null,
            'fish_path' => null,
        ];

        $mainData = array_merge($defaultData, $data);


        // create new record in jarime table
        $jarime = new Jarime();
        $jarime->id = $mainData['id'];   // one to one relation bw `jarime` and `order` table
        $jarime->tarikh = $mainData['tarikh'];
        $jarime->amount = $mainData['amount'];
        $jarime->status = $mainData['status'];
        $jarime->title = $mainData['title'];
        $jarime->jarime_pay_type = $mainData['jarime_pay_type'];
        $result = $jarime->save();


        // jarime transaction in transaction table
        $jarimeTransactionId = $this->transactionService->createTransaction([
            'order_id' => $mainData['id'],
            'user_id' => $mainData['user_id'],
            'karshenas_id' => Auth::id(),
            'jarime_id' => $jarime->id,
            'transactiontype_id' => Transactiontype::DARYAFTE_JARIME_AZ_CUSTOMER,
            'price' => $mainData['amount'],
            'fish_path' => $mainData['fish_path'],
            'status' => 'success',
            'type' => 'variz',     // واریز به حساب پانسیون
        ]);



        //@todo: jarime mitoone ham az wallet kasr beshe, ham bakhshish naqdi pardakht beshe, ham az bestankari kasr beshe
        //@todo: momkene mablaghe jarime bishtar az mojoodie wallet bashe -> in 2 meghdar bayad check beshe
        // if jarime is paid from wallet ->
           // transaction for wallet
           // wallet mojoodi update
           // wallettransactions
           // usertotalstatusmali > wallet_mojoodi, total_wallet_used
           // usertotalstatusmalitransaction > wallet
        if($mainData['jarime_pay_type'] == 'wallet_kasr') {

            $this->walletService->walletDecreaseForJarime($mainData['user_id'], $mainData['amount'], $mainData['id'], $description='کسر از کیف پول بابت جریمه');
        }



        // usertotalstatusmali -> bakhshe jarime
        $jarimePardakhtiChangeAmount = ($mainData['jarime_pay_type'] != '4')
                                    ?  $mainData['amount']
                                    : 0;

        // jarime bakhshi az bedehi ast ke be soorate jodagane niz dar table nemood peida karde.
        $this->usertotalstatusmaliService->updateUsertotalstatusmali($mainData['user_id'], $walletUsedAmount = 0,
                                                                        $walletChangeAmount = 0,
                                                                        $bedehiChangeAmount = $mainData['amount'],
                                                                        $pardakhtiChangeAmount = $jarimePardakhtiChangeAmount,
                                                                        $jarimeBedehkarChangeAmount = $mainData['amount'],
                                                                        $jarimePardakhtiChangeAmount = $jarimePardakhtiChangeAmount,
                                                                        $returnedAmountChanged = 0);


        // usertoalstatusmalitransaction -> for jarime
        $this->usertotalstatusmalitransactionsService->createUsertotalstatusmalitransaction([
            'usertotalstatusmalis_id' => $mainData['user_id'],
            'transaction_id' => $jarimeTransactionId,
            'order_id' => $mainData['id'],
            'jarime_amount' => $mainData['amount'],
            'jarime_paid' => $mainData['jarime_pay_type'] == '4' ? 0 : 1,
            'bedehi_changed_amount' => $mainData['amount'],
            'bedehi_change_type' => '1',
            'pardakhti_changed_amount' => $jarimePardakhtiChangeAmount,
            'pardakhti_change_type' => $mainData['jarime_pay_type'] == '4' ? '' : '1',
        ]);

        if($result){
            return $jarimeTransactionId;    // return jarime transaction ID
        }
        return false;
    }
}
