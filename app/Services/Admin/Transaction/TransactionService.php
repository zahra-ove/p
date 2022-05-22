<?php


namespace App\Services\Admin\Transaction;




use App\Models\Transaction;
use App\Services\Admin\FileStorage\FileStorageService;
use Illuminate\Database\Eloquent\Model;

class TransactionService
{

    private $fileStorageService;



    public function __construct(FileStorageService $fileStorageService)
    {
        $this->fileStorageService = $fileStorageService;
    }

    public function getTransactionByUser($id)
    {
        $transaction=Transaction::with(['order','transaction_type'])->where('user_id',$id)->orderByDesc('created_at')->get();

        foreach ($transaction as $t){
            $splitTarikh = explode('-', $t->created_at);
            $t['type']=$t->transaction_type->title;
            $t['tarikh']=Verta::create($splitTarikh[0],$splitTarikh[1],substr($splitTarikh[2],0,2),00,00,00)->formatJalaliDate();;
        }
        return count($transaction)!=0?$transaction:'notfound';
    }


    public function getTransactionByAuthority($authority)
    {
        $transaction=Transaction::where('authority',$authority)->first();
        return count($transaction)!=0?$transaction:'notfound';
    }



    public function createTransaction($data)
    {
        $defaultData = [
            'order_id' => '',
            'user_id' => '',
            'karshenas_id' => null,
            'jarime_id' => null,
            'qest_id' => null,
            'wallet_id' => null,
            'transactiontype_id' => null,
            'naqdtype_id' => null,
            'price' => '',
            'fish_path' => '',
            'status' => '',
            'ref_id' => '',
            'authority' => '',
            'type' => '',
        ];

        $mainData = array_merge($defaultData, $data);


        $newTransaction = new Transaction();
        $newTransaction->order_id = $mainData['order_id'];
        $newTransaction->user_id = $mainData['user_id'];
        $newTransaction->karshenas_id = $mainData['karshenas_id'];
        $newTransaction->jarime_id = $mainData['jarime_id'];
        $newTransaction->qest_id = $mainData['qest_id'];
        $newTransaction->wallet_id = $mainData['wallet_id'];
        $newTransaction->transactiontype_id = $mainData['transactiontype_id'];
        $newTransaction->naqdtype_id = $mainData['naqdtype_id'];
        $newTransaction->price = $mainData['price'];
        $newTransaction->status = $mainData['status'];
        $newTransaction->ref_id = $mainData['ref_id'];
        $newTransaction->authority = $mainData['authority'];
        $newTransaction->type = $mainData['type'];


        if($mainData['fish_path']) {   // if there is any fish for transaction, then save it.
            $newTransaction->fish_path = $this->fileStorageService->saveFishToStorage($mainData['fish_path']);         // path of saved fish
        }

        if($newTransaction->save()){
            return $newTransaction->id;
        }

        return false;
    }

}
