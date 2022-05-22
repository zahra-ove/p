<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Services\Admin\Cities\CityService;
use App\Services\Admin\Cities\OstanService;
use App\Services\Admin\Pansion\PansionService;
use App\Services\Admin\Room\RoomService;
use App\Services\Admin\Takht\TakhtService;
use App\Services\Admin\User\UserService;
use App\Services\FirstPage\FirstpageService;
use App\Services\FirstPage\PhotoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    private $cityService;
    private $photoService;
    private $userService;
    private $pansionService;
    private $roomService;
    private $firstpageService;
    private $ostanService;
    private $takhtService;
    /**
     * HomeController constructor.
     * @param $cittService
     * @param $photoService
     */
    public function __construct(FirstpageService $firstpageService,TakhtService $takhtService,RoomService $roomService,PansionService $pansionService,OstanService $ostanService,UserService $userService,CityService $cityService,PhotoService $photoService)
    {
        $this->cityService = $cityService;
        $this->photoService = $photoService;
        $this->userService = $userService;
        $this->pansionService = $pansionService;
        $this->firstpageService = $firstpageService;
        $this->ostanService = $ostanService;
        $this->roomService = $roomService;
        $this->takhtService = $takhtService;
    }


    public function index()
    {
            $pansions=$this->pansionService->getAllPansions();
            $countRoom=$this->roomService->totalRoom();
            $countTakht=$this->takhtService->totalTakht();
            $countMoshtari=$this->userService->totalCustomers();
        $cities=$this->cityService->getAllCities();
        $ostans=$this->ostanService->getAllOstans();
        $photoSearch=$this->photoService->photoSearch();
        $roompicks=$this->firstpageService->getAllRoomPick();
        $slider=$this->firstpageService->getFirstSlider();
        $about=$this->firstpageService->getFirstAbout();
        return view('store.master.index',compact(['cities','photoSearch','ostans','pansions','countRoom','countTakht','countMoshtari','roompicks','slider','about']));
    }

    public function account($id)
    {
        $cities=$this->cityService->getAllCities();
        $user=$this->userService->getUserById($id);

        return view('store.auth.account',compact('user','cities'));
    }

    public function editAccount($id,Request $request)
    {
        $user=$this->userService->editCustumer($id,$request->name,$request->family,$request->ncode,$request->birthday,$request->mobilecode,$request->password,
            $request->gender,$request->email,$request->addr,$request->isTrue);
        if ($user=='ok'){
            toastr()->success('شهر با موفقیت ثبت شد.', 'ثبت');
            return redirect()->back();
        }
        elseif ($user=="notfound"){
            toastr()->error('خطای سیستمی');
            return redirect()->back();

        }
        elseif ($user=="wrongpass"){
            toastr()->error('رمزی قبلی وارد شده درست نمی باشد.');
//            return redirect()->back();
            return $user;
        }
    }
}
