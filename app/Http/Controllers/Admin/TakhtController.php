<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\Orders\OrderService;
use App\Services\Admin\Pansion\PansionService;
use App\Services\Admin\Room\RoomService;
use App\Services\Admin\Takht\TakhtService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TakhtController extends Controller
{

    private $takhtService;
    private $roomservice;
    private $pansionService;

    /**
     * TakhtController constructor.
     * @param $takhtService
     * @param $roomservice
     */
    public function __construct(PansionService $pansionService,TakhtService $takhtService,RoomService $roomservice, OrderService $orderService)
    {
        $this->takhtService = $takhtService;
        $this->roomservice = $roomservice;
        $this->pansionService = $pansionService;
        $this->orderService = $orderService;
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

        $pansions=$this->pansionService->getAllPansions();
        $reservetypes=$this->takhtService->getAllReservetype();
        return view('admin.takht.create',compact(['pansions','reservetypes']));
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
        $takht=$this->takhtService->insertTakht($request->takhtnumber,$request->floor,$request->roomId,$request->show,$request->price,$request->pricemonth,$request->reservetypeId,$file);
        if ($takht=='ok'){
            toastr()->success('تخت با موفقیت ثبت شد.', 'ثبت');
            return redirect(route('pansion.index'));
        }elseif ($takht=='notfound'){
            toastr()->error('خطای سیستمی');
            return 'notfound';
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
        $pansions=$this->pansionService->getAllPansions();
        $takht=$this->takhtService->getTakhtById($id);
        $rooms=$this->roomservice->getAllRooms();
        $reservetypes=$this->takhtService->getAllReservetype();

        return view('admin.takht.edit',compact(['pansions','takht','rooms','reservetypes']));
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
        $takht=$this->takhtService->editTakht($id,$request->takhtnumber,$request->status,$request->floor,$request->show,$request->roomId,$request->price,$request->pricemonth,$request->reservetypeId,$file,$request->pick);
        if ($takht=='ok'){
            toastr()->success('تخت با موفقیت ویرایش شد.', 'ثبت');
            return redirect(route('pansion.index'));
        }elseif ($takht=='notfound'){
            toastr()->error('خطای سیستمی');
            return 'notfound';
        }
    }


    public function takhtsOfRoom($id)
    {

        $takhts=$this->takhtService->getTakhtByRoom($id);
        $room=$this->roomservice->getRoomById($id);
        return view('admin.takht.index',compact(['takhts','room']));
    }


    public function getTakhtByRoom($id)
    {
        $takhts=$this->takhtService->getTakhtByRoom($id);
        return $takhts;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $takht = $this->takhtService->deleteTakhtById($id);
        if ($takht == 'ok') {
            toastr()->success('تخت با موفقیت حذف شد.', 'ثبت');
            return "ok";
        } elseif ($takht == 'notfound') {
            toastr()->error('خطای سیستمی');
            return "notfound";

        }
    }
    public function fullTakht()
    {
        $pansions=$this->pansionService->getAllPansions();
        return view('admin.reports.full',compact(['pansions']));
    }

    public function getFullTakhtsByPansion($id)
    {
        return $this->takhtService->getFullTakhtsByPansion($id);
    }

    public function getEmptyTakhtByDateInPansion(Request $request, $pansionId,$reserveType)
    {
        $data = json_decode($request->getContent(), true);

        $raft = $data['data']['raft'];
        $bargasht = $data['data']['bargasht'];

        $takht=$this->takhtService->getEmptyTakhtByDateInPansion($pansionId,$reserveType,$raft,$bargasht);
        return $takht;

    }

    public function getEmptyTakhtByDateInRoom($roomId,$raft,$bargasht,$reserveType)
    {
        $takht=$this->takhtService->getEmptyTakhtByDateInRoom($roomId,$raft,$bargasht,$reserveType);

        return $takht;
    }

    public function getEmptyTakhtByPansionRoom($pansionId, $reserveType, $raft, $bargasht)
    {

//        $allTakhtsRelatedToThisPansion = $this->takhtService->getRelatedTakhtToPansion($pansionId,$reserveType);
//        $this->orderService->getOrdersByActiveInTakhtArray($allTakhtsRelatedToThisPansion);   // takht haye mored dar

        return $this->takhtService->getEmptyTakhtByDateInPansion($pansionId, $reserveType, $raft, $bargasht);
    }


}
