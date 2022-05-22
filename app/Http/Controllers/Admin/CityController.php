<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\Cities\CityService;
use App\Services\Admin\Cities\OstanService;
use Illuminate\Http\Request;

class CityController extends Controller
{
    private $cityService;
    private $ostanService;
    /**
     * CityController constructor.
     */
    public function __construct(CityService $cityService,OstanService $ostanService)
    {
        $this->cityService=$cityService;
        $this->ostanService=$ostanService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ostans=$this->ostanService->getAllOstans();
        $cities=$this->cityService->getAllCities();
        return view('admin.cities.create',compact(['ostans','cities']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file=null;
        if ($request->attach!=null){
            $file=$request->file('attach');
        }

        $city=$this->cityService->insertCity($request->name,$request->ostan_id,$file);
        if ($city=="ok"){
            toastr()->success('شهر با موفقیت ثبت شد.', 'ثبت');
          return $city;

        }
        elseif ($city=="notfound"){
            toastr()->error('خطای سیستمی');
            return $city;

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $file=$request->file('attach');

        $city = $this->cityService->editCity($id,$request->name,$request->ostan_id,$file);
        if ($city=="ok"){
            toastr()->success('ویرایش با موفقیت ثبت شد.', 'ویرایش');
            return redirect()->back();

        }
        elseif ($city=="notfound"){
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
        $city=$this->cityService->deleteCityById($id);

        return $city;
    }

    public function insertOstan(Request $request)
    {
        $ostan=$this->cityService->insertOstan($request->name);
        if ($ostan=="ok"){
            toastr()->success('استان با موفقیت ثبت شد.', 'ثبت');
            return $ostan;
        }
        elseif ($ostan=="notfound"){
            toastr()->error('خطای سیستمی');
            return $ostan;
        }
    }

    public function getCityByCategory($id)
    {
        return $this->cityService->getCityByCategory($id);
    }


    public function deleteOstan($id)
    {
        $ostan=$this->cityService->deleteOstan($id);
        if ($ostan=="ok"){
            return 'ok';
        }
        elseif ($ostan=="notfound"){
            return 'notfound';
        }
    }

    public function getCityByOstan($id)
    {
        $ostan=$this->cityService->getCityByOstan($id);
        return $ostan;
    }
}
