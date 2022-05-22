<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Services\Admin\Cities\CityService;
use App\Services\Admin\Cities\OstanService;
use App\Services\Admin\Groups\GroupService;

use App\Services\Admin\Ncodetype\NcodeService;
use App\Services\Admin\Permission\PermissioonService;
use App\Services\Admin\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    private $cityService;
    private $userService;
    private $groupService;
    private $permissionService;
    private $ncodetypeService;
    private $ostanService;
    /**
     * UserController constructor.
     * @param $cityService
     * @param $userService
     */
    public function __construct(PermissioonService $permissionService,OstanService $ostanService,NcodeService $ncodetypeService,GroupService $groupService,CityService $cityService,UserService $userService)
    {
        $this->cityService = $cityService;
        $this->userService = $userService;
        $this->groupService = $groupService;
        $this->ncodetypeService = $ncodetypeService;
        $this->ostanService = $ostanService;
        $this->permissionService = $permissionService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $personals=$this->userService->getAllPersonal();
        return view('admin.personals.index',compact(['personals']));
    }

    public function indexCustoms()
    {

        $personals=$this->userService->getAllCustom();
        return view('admin.customs.indexcustom',compact(['personals']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ostans = $this->ostanService->getAllOstans();
        $ncodetypes=$this->ncodetypeService->getAllNcodetype();
        return view('admin.personals.create',compact(['ostans','ncodetypes']));
    }
    public function createCustomer()
    {
        $cities = $this->cityService->getAllCities();
        $ostans = $this->ostanService->getAllOstans();
        $ncodetypes=$this->ncodetypeService->getAllNcodetype();
        return view('admin.customs.create',compact(['cities','ncodetypes','ostans']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {

        $ncodetype=explode(',',$request->ncodetype);


        $file=$request->file('attach');
        $user=$this->userService->insertPersonal($request->name,$request->family,$request->birthday,$request->ncode,$request->gender,
            $request->phone,$request->mobilecode,$request->email,$request->city_id,$request->cardnumber,$file,$request->addrTitle,$request->addr,$ncodetype,$request->mobiles);

        if ($user == "ok"){
            toastr()->success("خدمات دهنده با موفقیت ثبت شد.","موفق");
            return redirect(route('personal.index'));
        }
        elseif($user == "notfound"){
            toastr()->error("خطای سیستمی.","خطا");
            return redirect()->back();
        }
        elseif($user == "ncodeExist"){
            toastr()->warning("کدملی قبلا ثبت شده است.","خطا");
            return redirect()->back();
        }
        elseif($user == "mobileExist"){
            toastr()->warning("موبایل قبلا ثبت شده است.","خطا");
            return redirect()->back();
        }
        elseif($user == "contractExist"){
            return redirect()->back();
        }

    }
    public function storeCustomer(UserRequest $request)
    {
        $ncodetype=explode(',',$request->ncodetype);

        $file=$request->file('attach');
        $user=$this->userService->insertCustomer($request->name,$request->family,$request->birthday,$request->ncode,$request->gender,
            $request->phone,$request->mobilecode,$request->email,$request->city_id,$request->cardnumber,$file,$request->addrTitle,$request->addr,$ncodetype,$request->mobiles);
        if ($user == "ok"){
            toastr()->success("کاربر با موفقیت ثبت شد.","موفق");
            return redirect(route('indexcustom'));
        }
        elseif($user == "notfound"){
            toastr()->error("خطای سیستمی.","خطا");
            return redirect()->back();
        }
        elseif($user == "contractExist"){
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
        $ncodetypes=$this->ncodetypeService->getAllNcodetype();
        $user=$this->userService->getUserById($id);
        $cities=$this->cityService->getAllCities();

        return view('admin.personals.edit',compact(['user','cities','ncodetypes']));
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

        if ($request->ncodetype!=null){
            $ncodetype=explode(',',$request->ncodetype);
        }
        else{
            $ncodetype=null;
        }
        $file=[];
        if ($request->attach!=null){
            foreach ($request->attach as $attach){
                array_push($file,$attach);
            }
        }


        $user=$this->userService->editPersonal($id,$request->name,$request->family,$request->birthday,$request->ncode,$request->gender,
            $request->phone,$request->mobilecode,$request->email,$request->city_id,$request->cardnumber,$request->password,$file,$request->addrTitle,$request->addr,$ncodetype);
        if ($user=="ok"){
            toastr()->success('ویرایش با موفقیت ثبت شد.', 'ویرایش');
            return redirect(route('personal.index'));

        }
        elseif ($user=="notfound"){
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
        $provider=$this->userService->deleteUserById($id);
        if ($provider=='ok')
        {
            return 'ok';
        }
        elseif ($provider=='notfound')
        {
            return 'notfound';
        }
    }

    public function setGroup($id)
    {
        $personal=$this->userService->getUserById($id);
        $groups=$this->groupService->getAllGroups();
        return view('admin.personals.setgroup',compact(['groups','personal']));
    }

    public function setPermission($id)
    {
        $personal=$this->userService->getUserById($id);
        $permissions=$this->permissionService->getAllPermissions();
        return view('admin.personals.setpermission',compact(['permissions','personal']));
    }

    public function setGroups(Request $request)
    {

        for ($i=0;$i<count($request->gId);$i++){

            $user=$this->userService->setPersonal($request->uId,$request->gId[$i]);
        }

        if ($user=="ok"){
            toastr()->success('سمت ها برای پرسنل با موفقیت ثبت شد.', 'موفق');
            return redirect(route('personal.index'));

        }
        elseif ($user=="notfound"){
            toastr()->error('خطای سیستمی');
            return redirect()->back();

        }
        elseif ($user=="exist"){
            toastr()->error('سمت انتخاب شده قبلا برای این سمت ثبت شده.');
            return redirect()->back();
        }
    }


    public function setPermissions(Request $request)
    {

        for ($i=0;$i<count($request->pId);$i++){

            $user=$this->userService->setPermission($request->uId,$request->pId[$i]);
        }

        if ($user=="ok"){
            toastr()->success('دسترسی ها برای پرسنل با موفقیت ثبت شد.', 'موفق');
            return redirect(route('personal.index'));

        }
        elseif ($user=="notfound"){
            toastr()->error('خطای سیستمی');
            return redirect()->back();

        }
        elseif ($user=="exist"){
            toastr()->error('دسترسی انتخاب شده قبلا برای این سمت ثبت شده.');
            return redirect()->back();
        }
    }


    public function dettachGroupUser(Request $request)
    {
        $group=$this->userService->dettachGroupUser($request->uId,$request->gId);
        if ($group=="ok")
        {
            return "ok";
        }
        elseif ($group=="notfound"){
            return "notfound";
        }
    }
    public function dettachPermissionUser(Request $request)
    {
        $group=$this->userService->dettachPermissionUser($request->uId,$request->pId);
        if ($group=="ok")
        {
            return "ok";
        }
        elseif ($group=="notfound"){
            return "notfound";
        }
    }

    public function getAllCustoms()
    {
        if ($this->userService->getAllCustoms()!='notfound'){
            $pages=intval(ceil(count($this->userService->getAllCustoms())/10));
        }
        else{
            $pages=0;
        }

        return view('admin.customs.index',compact('pages'));
    }

    public function getAllCustomers()
    {
        $users=$this->userService->getAllCustoms();
        return $users;
    }


    public function getAllCustomsLimitOffset($limit,$offset)
    {
        $users=$this->userService->getAllCustomsLimitOffset($limit,$offset);
        return $users;
    }



    public function getAllCustomsByNcodeLimitOffset($column,$data,$limit,$offset)
    {
        $users=$this->userService->getCustomsByNcodeLimitOffset($column,$data,$limit,$offset);
        return $users;
    }


    public function getAllCustomsGone()
    {

        $users=$this->userService->getAllCustomsGone();
        if ($users!='notfound'){
            foreach ($users as $user){
                if ($user->wallet[0]->bedehkar<0){
                    $user['mali']='طلب';
                }
                else{
                    $user['mali']='بدهی';
                }
            }
        }

        return view('admin.customs.gone',compact('users'));
    }

    public function getCustomsByNcode($column,$data)
    {
        $users=$this->userService->getCustomsByNcode($column,$data);
        if ($users!='notfound'){
        foreach ($users as $user){
            if ($user->wallet[0]->bedehkar<0){
                $user['mali']='طلب';
            }
            else{
                $user['mali']='بدهی';
            }
            $user['bedehi']=abs($user->wallet[0]->bedehkar);
        }

            return $users;
        }else{
            return 'notfound';
        }

    }


    public function getUserByTakht($takhtId)
    {
        $users=$this->userService->getUserByTakht($takhtId);
        if ($users!='notfound'){


            return $users;
        }
        else{
            return 'notfound';
        }
    }


    public function getUserByTakhtLimitOffset($takhtId,$limit,$offset)
    {
        $users=$this->userService->getUserByTakhtLimitOffset($takhtId,$limit,$offset);
        if ($users!='notfound'){


            return $users;
        }
        else{
            return 'notfound';
        }
    }



    public function bladeChangePassword($id)
    {
        $user=$this->userService->getUserById($id);
        return view('admin.customs.changepass',compact('user'));
    }

    public function changePassword($id,Request $request)
    {

        $user=$this->userService->changePass($id,$request->oldPass,$request->newPass);

        if ($user=='ok'){
            toastr()->success('رمز عبور تغییر نمود.', 'موفق');
            return redirect(route('recentreserve'));
        }elseif ($user=='notfound'){
            toastr()->error('رمز قبلی اشتباه است.', 'موفق');
            return redirect()->back();
        }

    }


    public function usersPhoto($id)
    {
        $user=$this->userService->getUserById($id);
        return view('admin.personals.ncards',compact('user'));
    }

    public function detachUserPhoto($id,$photoId)
    {
        $user=$this->userService->detachUserPhoto($id,$photoId);
        return $user;
    }


    public function contarctPersonal($id)
    {
       $user=$this->userService->getUserById($id);
       return view('admin.personals.contract',compact('user'));
    }

    public function payQest($id)
    {
        $user=$this->userService->getUserById($id);
        $aqsat=$this->userService->payQest($id);
        return view('admin.mali.payQest',compact(['aqsat','user']));
    }

    //================= added by zizi =================//
    public function showVerificationCodeForm($id)
    {
        $user_id = $id;
        return view('store.auth.confirmMobile', compact('user_id'));
    }


    public function generateActivationCodeForSpecificUser($id)
    {
        // if user is not logged in or if logged in user is not requested this route, then return
        $user_id = (int)$id;
        if(!Auth::check() || Auth::id() !== $user_id)
            return;

        return $this->userService->setActiveCodeForUser($user_id);
    }


    public function showDashboard()
    {
        if(!Auth::check())
            return;


        // if mobile verification is not done, then redirect user to verify his mobile before accessing to the dashboard
        if(!Auth::user()->active_code_verify) {
            $user_id = Auth::id();
            return view('store.auth.confirmMobile', compact('user_id'));
        }
        return view('admin.master.index');
    }

    public function checkActivationCodeForSpecificUser(Request $request)
    {
        $active_code = (int)$request->input('active_code');
        $user_id = (int)$request->input('user_id');

        $result = $this->userService->checkActivationCodeForSpecificUser($active_code, $user_id);

        if($result)
            return redirect()->route('admin');

        return Redirect::back()->withErrors(['msg' => 'کد تایید وارد شده صحیح نیست!']);
    }


    public function createNewUser()
    {
        $cities = $this->cityService->getAllCities();
        $ostans = $this->ostanService->getAllOstans();
        $ncodetypes=$this->ncodetypeService->getAllNcodetype();
        return view('admin.customs.create2',compact(['cities','ncodetypes','ostans']));
    }


    public function storeUser(UserRequest $request)
    {
        $ncodetype=explode(',',$request->ncodetype);

        $file=$request->file('attach');
        $user=$this->userService->insertCustomer($request->name,$request->family,$request->birthday,$request->ncode,$request->gender,
            $request->phone,$request->mobilecode,$request->email,$request->city_id,$request->cardnumber,$file,$request->addrTitle,$request->addr,$ncodetype,$request->mobiles);
        if ($user == "ok"){
            toastr()->success("کاربر جدید با موفقیت ثبت شد.","موفق");
            return redirect(route('order.create'));
        }
        elseif($user == "notfound"){
            toastr()->error("خطای سیستمی.","خطا");
            return redirect()->back();
        }
        elseif($user == "contractExist"){
            return redirect()->back();
        }
    }
}
