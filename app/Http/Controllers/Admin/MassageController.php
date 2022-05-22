<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Massage\MassageService;
use Illuminate\Http\Request;

class MassageController extends Controller
{
    private $massageService;

    /**
     * MassageController constructor.
     * @param $massageService
     */
    public function __construct(MassageService $massageService)
    {
        $this->massageService = $massageService;
    }

    public function fivedaysorderSetting(Request $request)
    {

        $massage=$this->massageService->fivedaysorderSetting($request->fivedaysorderSetting);
        if ($massage=='ok'){
            toastr()->success('تغییر پیامک انجام گردید.', 'موفق');
            return redirect()->back();
        }
        elseif ($massage=='notfound'){
            toastr()->error('خطای سیستمی');
            return redirect()->back();
        }
    }

    public function threedaysqestSetting(Request $request)
    {
        $massage=$this->massageService->threedaysqestSetting($request->threedaysqestSetting);
        if ($massage=='ok'){
            toastr()->success('تغییر پیامک انجام گردید.', 'موفق');
            return redirect()->back();
        }
        elseif ($massage=='notfound'){
            toastr()->error('خطای سیستمی');
            return redirect()->back();
        }
    }

    public function fivedayssoonSetting(Request $request)
    {
        $massage=$this->massageService->fivedayssoonSetting($request->fivedayssoonSetting);
        if ($massage=='ok'){
            toastr()->success('تغییر پیامک انجام گردید.', 'موفق');
            return redirect()->back();
        }
        elseif ($massage=='notfound'){
            toastr()->error('خطای سیستمی');
            return redirect()->back();
        }
    }

    public function massages()
    {
        $massage=$this->massageService->getFirstMassage();
        return view('admin.massage.create',compact('massage'));
    }
}
