<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\Cities\CityService;
use App\Services\Admin\Pansion\PansionService;
use Illuminate\Http\Request;

class PansionController extends Controller
{
    private $pansionService;
    private $cityService;

    /**
     * PansionController constructor.
     * @param $pansionService
     */
    public function __construct(PansionService $pansionService,CityService $cityService)
    {
        $this->pansionService = $pansionService;
        $this->cityService = $cityService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pansions=$this->pansionService->getAllPansions();
        return view('admin.pansion.index',compact('pansions'));
    }


    public function getAllPansionWithAjax()
    {
        $pansions=$this->pansionService->getAllPansions();
        return $pansions;
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $cities=$this->cityService->getAllCities();

        return view('admin.pansion.create',compact('cities'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $file=$request->file('attach');
        $video=$request->file('video');
        $pansion=$this->pansionService->insertPansion($request->countrooms,$request->counttakhts,$request->cityId,$request->name,$request->show,$request->addr,$request->title,$request->vorud,$request->khoruj,$request->floors,$request->gender,$file,$video);
        if ($pansion=='ok'){
            toastr()->success('خوابگاه با موفقیت ثبت شد.', 'ثبت');

            return redirect(route('pansion.index'));
        }elseif ($pansion=='notfound'){
            toastr()->error('خطای سیستمی');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cities=$this->cityService->getAllCities();
        $pansion=$this->pansionService->getPansionById($id);

        return view('admin.pansion.edit',compact(['cities','pansion']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $pansion=$this->pansionService->editPansion($id,$request->counttakhts,$request->name,$request->cityId,$request->countrooms,$request->show,$request->addr,$request->vorud,$request->khoruj,$request->floors,$request->gender,$request->title,$request->attach,$request->file('video'),$request->isvideo,$request->pick);

        if ($pansion=='ok'){
            toastr()->success('خوابگاه با موفقیت ویرایش شد.', 'ثبت');
            return redirect(route('pansion.index'));
        }elseif ($pansion=='notfound'){
            toastr()->error('خطای سیستمی');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pansion=$this->pansionService->deletePansionById($id);
        if ($pansion=='ok'){
            return "ok";
        }
        elseif ($pansion=='notfound'){
            return "notfound";
        }
    }


    public function deletePhoto($id)
    {
        $photo=$this->pansionService->deletePhoto($id);
        if ($photo=='ok'){
            return 'ok';
        }
        elseif($photo=='notfound'){
            return 'notfound';
        }
    }

    public function getPansionByIdAjax($id)
    {
        $pansion=$this->pansionService->getPansionById($id);
        return $pansion;
    }
}
