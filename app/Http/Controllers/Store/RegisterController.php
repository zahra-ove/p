<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Services\Admin\Cities\CityService;
use App\Services\Admin\User\UserService;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    private $cityService;
    private $userService;

    /**
     * RegisterController constructor.
     * @param $cityService
     */
    public function __construct(UserService $userService,CityService $cityService)
    {
        $this->cityService = $cityService;
        $this->userService = $userService;
    }


    protected function create()
    {

        $cities=$this->cityService->getAllCities();
        if (Auth::check()){

            return view('store.auth.registerd',compact('cities'));
        }
        else{
            return view('store.auth.register',compact('cities'));
        }

    }


    public function edit($id)
    {
        $cities=$this->cityService->getAllCities();
        $user=$this->userService->getUserById($id);
        if (Auth::check()){

            return view('store.auth.edit',compact(['cities','user']));
        }
        else{
            return view('store.auth.register',compact('cities'));
        }
    }


    protected function store(Request $request)
    {

    }

}
