<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\Pansion\PansionService;
use App\Services\Admin\Room\pubService;
use App\Services\Admin\Room\PvService;
use App\Services\Admin\Room\RoomService;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    private $roomService;
    private $pansionService;
    private $pubService;
    private $pvService;

    /**
     * RoomController constructor.
     * @param $roomService
     */
    public function __construct(PvService $pvService,pubService $pubService,PansionService $pansionService, RoomService $roomService)
    {
        $this->roomService = $roomService;
        $this->pansionService = $pansionService;
        $this->pubService = $pubService;
        $this->pvService = $pvService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms=$this->roomService->getAllRooms();
        return view('admin.room.index',compact('rooms'));
    }

    public function roomsOfPansion($id)
    {
        $rooms=$this->roomService->getRoomByPansion($id);
        $pansion=$this->pansionService->getPansionById($id);
        return view('admin.room.index',compact(['rooms','pansion']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pansions=$this->pansionService->getAllPansions();
        $pubs=$this->pubService->getAllPubemkanats();

        return view('admin.room.create',compact(['pansions','pubs']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = $request->file('attach');
        $room = $this->roomService->insertroom($request->roomnumber, $request->counttakht, $request->floor, $request->pansionId, $request->show,$request->pubcheck,$request->privateTitle, $file);
        if ($room == 'ok') {

            toastr()->success('اتاق با موفقیت ثبت شد.', 'ثبت');
            return redirect(route('pansion.index'));
        } elseif ($room == 'notfound') {
            toastr()->error('خطای سیستمی');
            return redirect()->back();        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pansions=$this->pansionService->getAllPansions();
        $pubs=$this->pubService->getAllPubemkanats();
        $room=$this->roomService->getRoomById($id);
        return view('admin.room.edit',compact(['pansions','pubs','room']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $file = $request->file('attach');
        $room = $this->roomService->editRoom($id,$request->roomnumber, $request->show, $request->counttakht, $request->floor, $request->pansionId,$request->pubcheck,$request->privateTitle,$file,$request->pick);
        if ($room == 'ok') {
            toastr()->success('اتاق با موفقیت ویرایش شد.', 'ثبت');
            return redirect(route('pansion.index'));
        } elseif ($room == 'notfound') {
            toastr()->error('خطای سیستمی');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $room = $this->roomService->deleteRoomById($id);
        if ($room == 'ok') {
            toastr()->success('اتاق با موفقیت حذف شد.', 'ثبت');
            return "ok";
        } elseif ($room == 'notfound') {
            toastr()->error('خطای سیستمی');
            return redirect()->back();

        }
    }
    public function insertPubemkanat(Request $request)
    {
        $pubemkanat=$this->pubService->insertPubemkanat($request->title);
        $allpubemkanat=$this->pubService->getAllPubemkanats();
        if ($pubemkanat=='ok'){
            return $allpubemkanat;
        }
        elseif ($pubemkanat=='notfound'){
            toastr()->error('خطای سیستمی');
            return redirect()->back();
        }
    }

    public function deletePubemkanat(Request $request)
    {
        $pubemkanat=$this->pubService->deletePubemkanat($request->id);
        if ($pubemkanat=='ok'){
            return 'ok';
        }
        elseif ($pubemkanat=='notfound'){
            toastr()->error('خطای سیستمی');
            return redirect()->back();
        }
    }

    public function getRoomByPansion($id)
    {
        $rooms=$this->roomService->getRoomByPansion($id);
        return $rooms;
    }

    public function getRoomById($id)
    {
        $rooms=$this->roomService->getRoomById($id);
        return $rooms;
    }

    public function getAllRooms()
    {
        $rooms=$this->roomService->getAllRooms();
        return view('admin.room.allrooms',compact(['rooms']));
    }

}
