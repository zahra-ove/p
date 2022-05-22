<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\Cities\CityService;
use App\Services\Admin\Pansion\PansionService;
use App\Services\FirstPage\FirstpageService;
use Illuminate\Http\Request;

class FirstpageController extends Controller
{
private $firstpageService;
private $cityService;
private $pansionService;

    /**
     * FirstpageController constructor.
     * @param $categoryService
     */
    public function __construct(PansionService $pansionService,CityService $cityService,FirstpageService $firstpageService)
    {
        $this->firstpageService = $firstpageService;
        $this->cityService = $cityService;
        $this->pansionService = $pansionService;
    }

    public function createRoomPick()
    {
       $pansions= $this->pansionService->getAllPansions();
       return view('admin.firstPageSetting.roompick.create',compact('pansions'));
}

    public function storeRoomPick(Request $request)
    {

        $roomPick = $this->firstpageService->setRoomPick($request->order, $request->roomId, $request->path);
        if ($roomPick == 'ok') {
            toastr()->success('اتاق مدنظر برای اتاق منتخب ثبت  شد.');
            return redirect()->back();
        } elseif ($roomPick == 'notfound') {
            toastr()->error('خطای سیستمی.');
            return redirect()->back();
        }
    }


    public function getAllRoomPick()
    {
        $room=$this->firstpageService->getAllRoomPick();
        return $room;
}

    public function createSlider()
    {
        $slider=$this->firstpageService->getFirstSlider();
        return view('admin.firstPageSetting.slider.create',compact('slider'));
    }

    public function storeSlider(Request $request)
    {

        $roomPick = $this->firstpageService->setSlider($request->title, $request->passage, $request->file);
        if ($roomPick == 'ok') {
            toastr()->success('بنر صفحه اصلی ویرایش شد.');
            return redirect()->back();
        } elseif ($roomPick == 'notfound') {
            toastr()->error('خطای سیستمی.');
            return redirect()->back();
        }
    }

    public function createAbout()
    {
        $about=$this->firstpageService->getFirstAbout();
        return view('admin.firstPageSetting.aboutus.create',compact('about'));
    }
    public function storeAbout(Request $request)
    {

        $roomPick = $this->firstpageService->setAbout($request->about_us, $request->about_boss,$request->boss_name, $request->file);
        if ($roomPick == 'ok') {
            toastr()->success('صفحه درباره ویرایش شد.');
            return redirect()->back();
        } elseif ($roomPick == 'notfound') {
            toastr()->error('خطای سیستمی.');
            return redirect()->back();
        }
    }
    public function storeContact(Request $request)
    {

        $roomPick = $this->firstpageService->setContact($request->phone, $request->address,$request->email);
        if ($roomPick == 'ok') {
            toastr()->success('صفحه تماس با ما ویرایش شد.');
            return redirect()->back();
        } elseif ($roomPick == 'notfound') {
            toastr()->error('خطای سیستمی.');
            return redirect()->back();
        }
    }
    public function createContact()
    {
        $contact=$this->firstpageService->getFirstContact();
        return view('admin.firstPageSetting.contact.create',compact('contact'));
    }
}
