<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Services\Admin\Cities\CityService;
use App\Services\Admin\User\UserService;
use App\Traits\CustomRegistersUsers;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */


    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
//    protected $redirectTo = RouteServiceProvider::HOME;
//    protected $redirectTo = '/admin/s';

    protected function redirectTo()
    {
        $user_id = Auth::id();   // get registered user id
        return '/verify-mobile-form/' . $user_id;
    }

    /**
     * @var UserService
     */
    private $userService;




    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserService $userService, CityService $cityService)
    {
        $this->middleware('guest');
        $this->userService = $userService;
        $this->cityService = $cityService;
    }


    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        $cities=$this->cityService->getAllCities();   //list of all cities
        return view('store.auth.register', compact('cities'));
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        return Validator::make($data, [
            'name'      => 'required|string|max:100',
            'family'    => 'required|string|max:100',
            'email'     => 'required|email:rfc,dns|unique:users',     //@todo: The dns and spoof validators require the PHP intl extension.
            'ncode'     => 'required|numeric|digits:10|unique:users',
            'mobilecode'=> 'required|numeric|digits:11|unique:users',
            'city_id'   => 'required|integer|max:200',
            'birthday'  => 'required|string|max:10',
            'password'  => ['required', 'confirmed',Password::min(8)
                                ->letters()
                                ->mixedCase()
                                ->numbers()
                                ->symbols()
                                ->uncompromised()
                            ],
            'gender'    => ['required', Rule::in(['female', 'male'])],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return $user=$this->userService->registers($data);
    }
}
