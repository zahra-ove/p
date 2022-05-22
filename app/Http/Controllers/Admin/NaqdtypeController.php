<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\Naqdtype\NaqdtypeService;
use Illuminate\Http\Request;

class NaqdtypeController extends Controller
{
    private $naqdtypeService;

    /**
     * NaqdtypeController constructor.
     * @param $naqdtypeService
     */
    public function __construct(NaqdtypeService $naqdtypeService)
    {
        $this->naqdtypeService = $naqdtypeService;
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
        $naqds =$this->naqdtypeService->getAllNaqdtypes();
        return view('admin.naghdtype.create',compact('naqds'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $naqd=$this->naqdtypeService->insertNaqdtype($request->title);
        if ($naqd=="ok"){
            toastr()->success('نوع پرداخت با موفقیت ثبت شد.', 'ثبت');
            return $naqd;
        }
        elseif ($naqd=="notfound"){
            toastr()->error('خطای سیستمی');
            return $naqd;
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
        $naqd =$this->naqdtypeService->editNaqdtype($id,$request->title);
        if ($naqd=='ok'){
            toastr()->success('ویرایش با موفقیت ثبت شد.', 'ویرایش');
            return redirect()->back();
        }
        elseif($naqd=="notfound"){
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
        $naqd=$this->naqdtypeService->deleteNaqdType($id);
        if ($naqd=="ok"){
            return 'ok';
        }
        elseif ($naqd=="notfound"){
            return 'notfound';
        }
    }
}
