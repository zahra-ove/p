<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\Permission\PermissioonService;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    private $permissionService;

    /**
     * PermissionController constructor.
     * @param $permissionService
     */
    public function __construct(PermissioonService $permissionService)
    {
        $this->permissionService = $permissionService;
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
        $permissions=$this->permissionService->getAllPermissions();
        return view('admin.permissions.create',compact(['permissions']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $permission= $this->permissionService->insertPermission($request->name,$request->name_en);
        if ($permission=="ok"){
            toastr()->success("دسترسی برای خدمات دهنده با موفقیت ثبت شد.","موفق");
            return $permission;
        }
        elseif($permission == "notfound"){
            toastr()->error("خطای سیستمی.","خطا");
            return $permission;
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
        $permission=$this->permissionService->editPermission($id,$request->name,$request->name_en);
        if ($permission=="ok"){
            toastr()->success('ویرایش با موفقیت ثبت شد.', 'ویرایش');
            return redirect()->back();

        }
        elseif ($permission=="notfound"){
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
        $permission=$this->permissionService->deletePermission($id);
        if ($permission=="ok"){
            return "ok";
        }
        elseif ($permission=="notfound"){
            return "notfound";
        }
    }
}
