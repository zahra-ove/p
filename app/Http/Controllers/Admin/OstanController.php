<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\Cities\OstanService;
use Illuminate\Http\Request;

class OstanController extends Controller
{
    private $ostanService;

    /**
     * OstanController constructor.
     * @param $ostanService
     */
    public function __construct(OstanService $ostanService)
    {
        $this->ostanService = $ostanService;
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
        $ostans =$this->ostanService->getAllOstans();
        return view('admin.ostan.create',compact('ostans'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ostan=$this->ostanService->insertOstan($request->name);
        if ($ostan=="ok"){
            toastr()->success('استان با موفقیت ثبت شد.', 'ثبت');
            return $ostan;
        }
        elseif ($ostan=="notfound"){
            toastr()->error('خطای سیستمی');
            return $ostan;
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
        $ostan =$this->ostanService->editOstan($id,$request->name);
        if ($ostan=='ok'){
            toastr()->success('ویرایش با موفقیت ثبت شد.', 'ویرایش');
            return redirect()->back();
        }
        elseif($ostan=="notfound"){
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
       $ostan=$this->ostanService->deleteCityById($id);
       if ($ostan){
           return 'ok';
       }
        return 'notfound';
    }
}
