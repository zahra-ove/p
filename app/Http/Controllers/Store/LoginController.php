<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{


    public function logins()
    {

        if (Auth::check()){
            return redirect(route('recentreserve'));
        }
        else{
            return view('store.auth.login');
        }

    }
}
