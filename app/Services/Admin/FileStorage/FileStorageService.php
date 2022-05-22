<?php

namespace App\Services\Admin\FileStorage;


use App\Services\Admin\Transaction\TransactionService;
use App\Services\Admin\Wallet\WalletService;
use App\Services\Sms\Sms;

class FileStorageService
{


    //save fish to storage
    //@todo: save file secure ---> should improve it
    public function saveFishToStorage($fish)
    {
        $filename = $fish->getClientOriginalName();
        $path = 'storage/images/fish/' . $filename;
        $fish->storeAs('public/images/fish/', $filename);
        return $path;
    }
}
