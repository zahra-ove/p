<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\Groups\GroupService;
use App\Services\Admin\Permission\PermissioonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    private $groupService;
    private $permissionService;

    /**
     * GroupController constructor.
     * @param $groupService
     */
    public function __construct(PermissioonService $permissionService,GroupService $groupService)
    {
        $this->groupService = $groupService;
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

        $groups=$this->groupService->getAllGroups();
        return view('admin.groups.create',compact(['groups']));


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $group= $this->groupService->insertGroup($request->name,$request->name_en);
        if ($group=="ok"){
    toastr()->success("سمت برای خدمات دهنده با موفقیت ثبت شد.","موفق");
            return $group;
        }
        elseif($group == "notfound"){
            toastr()->error("خطای سیستمی.","خطا");
            return $group;
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
        $group=$this->groupService->editGroup($id,$request->name,$request->name_en);
        if ($group=="ok"){
            toastr()->success('ویرایش با موفقیت ثبت شد.', 'ویرایش');
            return redirect()->back();

        }
        elseif ($group=="notfound"){
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
        $group=$this->groupService->deleteGroup($id);
        if ($group=="ok"){
            return "ok";
        }
        elseif ($group=="notfound"){
            return "notfound";
        }
    }

    public function setPermission($id)
    {
        $group=$this->groupService->getGroupById($id);
        $permissions=$this->permissionService->getAllPermissions();
        return view('admin.groups.setpermission',compact(['group','permissions']));
    }

    public function setPermissions(Request $request)
    {

        for ($i=0;$i<count($request->pId);$i++){

        $group=$this->groupService->setPermission($request->gId,$request->pId[$i]);
    }

        if ($group=="ok"){
            toastr()->success('دسترسی ها برای سمت با موفقیت ثبت شد.', 'موفق');
            return redirect(route('group.create'));

        }
        elseif ($group=="notfound"){
            toastr()->error('خطای سیستمی');
            return redirect()->back();

        }
        elseif ($group=="exist"){
            toastr()->error('دسترسی انتخاب شده قبلا برای این سمت ثبت شده.');
            return redirect()->back();
        }
    }

    public function dettachPermissioonGroup(Request $request)
    {
        $group=$this->groupService->dettachPermissioonGroup($request->gId,$request->pId);
        if ($group=="ok")
        {
            return "ok";
        }
        elseif ($group=="notfound"){
            return "notfound";
        }
    }
}
