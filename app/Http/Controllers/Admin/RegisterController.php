<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Admin\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    private $userService;

    /**
     * RegisterController constructor.
     * @param $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    public function create(Request $request)
    {
        $user=$this->userService->registers($request->name,$request->family,$request->mobilecode,$request->gender,$request->ncode,$request->email,
            $request->birthday,$request->password,$request->city_id);

        if ($user=="ok"){
            toastr()->success("تبریک می گویم اطلاعات شما با موفقیت ثبت شد.","موفق");

          return redirect(asset('/'));

        }
        elseif($user == "notfound"){
            toastr()->error("خطای سیستمی.","خطا");
            return redirect()->back();
        }
    }
}
