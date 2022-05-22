<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use App\Services\Admin\User\UserService;
use App\Services\Admin\Wallet\WalletService;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    private $walletService;
    private $userService;

    /**
     * WalletController constructor.
     * @param $walletService
     */
    public function __construct(WalletService $walletService,UserService $userService)
    {
        $this->walletService = $walletService;
        $this->userService = $userService;
    }


    public function wallet()
    {
        $users=$this->userService->getAllCustomers();
        return view('admin.customs.wallet',compact('users'));
    }


    public function cash(Request $request)
    {
        $wallet=$this->walletService->cash($request->user_id,$request->price,$request->fish);
        if ($wallet=='ok'){
            toastr()->success('برداشت از کیف پول مشترک انجام شد.','موفق');
            return redirect()->back();
        }
        elseif ($wallet=='notfound'){
            toastr()->warning('خطای سیستمی','موفق');
            return redirect()->back();
        }
    }

    public function deposite(Request $request)
    {

        $wallet=$this->walletService->deposite($request->user_id,$request->price,$request->fish);
        if ($wallet=='ok'){
            toastr()->success('شارژ کیف پول مشترک انجام شد.','موفق');
            return redirect()->back();
        }
        elseif ($wallet=='notfound'){
            toastr()->warning('خطای سیستمی','موفق');
            return redirect()->back();
        }
    }

    public function getWalletMojoodiForSpecifcUser($userId)
    {
        return $this->walletService->getWalletMojoodiForSpecifcUser($userId);   // return wallet mojoodi
    }


}
