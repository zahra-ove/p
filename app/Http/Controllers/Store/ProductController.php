<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Services\Admin\Cities\CityService;
use App\Services\Admin\Cities\OstanService;
use App\Services\Admin\Providers\CategoryService;
use App\Services\Admin\Providers\ProductService;
use App\Services\Admin\Providers\ProviderService;
use App\Services\Admin\Room\RoomService;
use App\Services\Admin\Takht\TakhtService;
use App\Services\Admin\User\UserService;
use App\Services\FirstPage\FirstpageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Object_;
use function MongoDB\BSON\fromJSON;

class ProductController extends Controller
{
    private $providerService;
    private $productService;
    private $cityService;
    private $roomService;
    private $takhtService;
    private $userService;
    private $firstpageService;


    /**
     * ProductController constructor.
     * @param $providerService
     */
    public function __construct(FirstpageService $firstpageService, TakhtService $takhtService,RoomService $roomService,UserService $userService,OstanService $ostanService,CityService $cityService)
    {
        $this->cityService = $cityService;
        $this->ostanService = $ostanService;
        $this->userService = $userService;
        $this->roomService = $roomService;
        $this->takhtService = $takhtService;
        $this->firstpageService = $firstpageService;
    }


    public function about()
    {
        $about=$this->firstpageService->getFirstAbout();
        return view('store.menu.about',compact('about'));
    }

    public function contact()
    {
        $contact=$this->firstpageService->getFirstContact();
        return view('store.menu.contact',compact('contact'));
    }


    public function detailRoom($id)
    {
        $room=$this->roomService->getRoomById($id);
        return view('store.products.detailroom',compact('room'));
    }


    public function roomList($id)
    {
        $rooms=$this->roomService->getRoomByPansionByUniqueFloor($id);
        return view('store.products.roomlist',compact('rooms'));
    }


    public function getTakhtByRoomOrderPrice($floor,Request $request)
    {
        $takhts=$this->takhtService->getTakhtByRoomOrderPrice($floor,$request->raft,$request->bargasht);

        if ($takhts!='notfound'){
            $countTakht=intval(ceil(count($takhts)/10));
        }
        else{
            $countTakht=0;
        }

        $floors=$floor;
        return view('store.products.takhtlist',compact(['countTakht','floors']));
    }


    public function getTakhtByRoomOrderPriceLimitOffsset($floor,$raft,$bargasht,$limit,$offset)
    {
        return $this->takhtService->getTakhtByRoomOrderPriceLimitOffsset($floor,$raft,$bargasht,$limit,$offset);
    }


    public function detailTakht($id)
    {
        $takht=$this->takhtService->getTakhtById($id);

        return view('store.products.detailtakht',compact('takht'));
    }

}
