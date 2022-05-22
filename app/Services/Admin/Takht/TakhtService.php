<?php


namespace App\Services\Admin\Takht;


use App\Models\Photo;
use App\Models\Reservetype;
use App\Models\Room;
use App\Models\Takht;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class TakhtService
{
    public function getAllTakhts()
    {
        $takhts=Takht::all();

        return count($takhts)>0?$takhts:'notfound';

    }


    public function getTakhtById($id)
    {
        $takhts=Takht::with(['room'])->find($id);

//        $takhts['showphoto']=$takhts->photo->first();
        return isset($takhts)?$takhts:'notfound';
    }

    public function insertTakht($takhtnumber,$floor,$roomId,$show,$price,$pricemonth,$reservetypeId,$file)
    {

        $takht= new Takht();
        $takht->takhtnumber=$takhtnumber;
        $takht->floor=$floor;
        $takht->room_id=$roomId;
        $takht->show=$show;
        $takht->price=$price;
        $takht->status='خالی';
        $takht->pricemonth=$pricemonth;
        $takht->reservetype_id=$reservetypeId;
        DB::beginTransaction();
        if ($takht->save()){
            if ($file!=null) {
                for ($i = 0; $i < count($file); $i++) {
                    $photo = new Photo();
                    $photo->picable_id = $takht->id;
                    $photo->picable_type = "App\Models\Takht";
                    $filename = $file[$i]->getClientOriginalName();
                    $path = 'storage/images/takht/' . $filename;
                    $photo->path = $path;
                    if ($i==0){
                        $photo->pick = '1';
                    }
                    else{
                        $photo->pick = '0';
                    }
                    $photo->save();
                    $file[$i]->storeAs('public/images/takht/', $filename);
                }
            }
            DB::commit();
            return "ok";
        }
        else{
            DB::rollback();
            return "notfound";
        }


    }


    public function getTakhtByRoom($id)
    {
        $rooms=Takht::where('room_id',$id)->get();
        return count($rooms)>0?$rooms:'notfound';
    }


    public function deleteTakhtById($id)
    {
        $takht=$this->getTakhtById($id);

        if ($takht->delete()){

            return 'ok';
        }
        else{

            return 'notfound';
        }
    }


    public function editTakht($id,$takhtnumber,$status,$floor,$show,$roomId,$price,$pricemonth,$reservetypeId,$file,$pick)
    {

        $takht=$this->getTakhtById($id);
        $takht->takhtnumber=$takhtnumber;
        $takht->floor=$floor;
        $takht->status=$status;
        $takht->show=$show;
        $takht->price=$price;
        $takht->room_id=$roomId;
        $takht->pricemonth=$pricemonth;
        $takht->reservetype_id=$reservetypeId;
        DB::beginTransaction();
        if ($takht->save()){
            if ($file!=null) {
                for ($i = 0; $i < count($file); $i++) {
                    $photo = new Photo();
                    $photo->picable_id = $takht->id;
                    $photo->picable_type = "App\Models\Takht";
                    $filename = $file[$i]->getClientOriginalName();
                    $path = 'storage/images/takht/' . $filename;
                    $photo->path = $path;
                    if ($filename==$pick){
                        foreach ($takht->photo as $p) {
                            $p->pick = '0';
                            $p->save();
                        }
                        $photo->pick='1';

                    }
                    else{

                        $photo->pick='0';
                    }
                    $photo->save();
                    $file[$i]->storeAs('public/images/takht/', $filename);
                }
            }
            if (is_numeric($pick)==true){
                foreach ($takht->photo as $p){
                    $p->pick='0';
                    $p->save();
                    if ($pick==$p->id){
                        $p->pick='1';
                        $p->save();
                    }
                }
            }
            DB::commit();
            return 'ok';
        }
        else{
            DB::rollback();
            return 'notfound';
        }
    }
    public function getFullTakhtsByPansion($id)
    {
//        $takht=Takht::with(['room','order'])->whereHas('order',function ($order) {
//            $order->where('status_order_id','1')->whereDate('raft','<',Date::now())->whereDate('bargasht','>',Date::now());
//        })->whereHas('room',function ($room) use ($id){
//            $room->where('pansion_id',$id);
//        })->get();
        $takht=Takht::with(['room','order'])->where('status','پر')->get();

        if (count($takht)!=0){


                foreach ($takht as $t){
                    if (count($t->order)!=0){
                        $orders=$t->order->where('status_order_id','1')->first();

                    $t['pansion']=$t->room->pansion->name;
                    $t['takhtnumber']=$t->takhtnumber;
                    $t['roomnumber']=$t->room->roomnumber;
                    $t['price']=$t->price;
                    $t['karshenasName']=$orders->karshenas->name.' '.$orders->karshenas->family;
                    $t['fullname']=$orders->user->name.' '.$orders->user->family;
                    $t['order_number']=$orders->order_number;
                    $splitRaft=explode('-',$orders->raft);
                    $splitBargasht=explode('-',$orders->bargasht);
                    $t['jalaliRaft']=Verta::create($splitRaft[0],$splitRaft[1],$splitRaft[2],00,00,00)->formatJalaliDate();
                    $t['jalaliBargasht']=Verta::create($splitBargasht[0],$splitBargasht[1],$splitBargasht[2],00,00,00)->formatJalaliDate();
                }
            }
        }


        return count($takht)>0?$takht:'notfound';
    }



    public function getEmptyTakhtsByPansion($id)
    {
        $takht=Takht::with(['room','order'])->where('status','خالی')->get();


        if (count($takht)!=0){


            foreach ($takht as $t){
                if (count($t->order)!=0){
                    $orders=$t->order->whereIn('status_order_id', ['1','7'])->first();

                    $t['pansion']=$t->room->pansion->name;
                    $t['takhtnumber']=$t->takhtnumber;
                    $t['roomnumber']=$t->room->roomnumber;
                    $t['price']=$t->price;
                    $t['karshenasName']=$orders->karshenas->name.' '.$orders->karshenas->family;
                    $t['fullname']=$orders->user->name.' '.$orders->user->family;
                    $t['order_number']=$orders->order_number;
                    $splitRaft=explode('-',$orders->raft);
                    $splitBargasht=explode('-',$orders->bargasht);
                    $t['jalaliRaft']=Verta::create($splitRaft[0],$splitRaft[1],$splitRaft[2],00,00,00)->formatJalaliDate();
                    $t['jalaliBargasht']=Verta::create($splitBargasht[0],$splitBargasht[1],$splitBargasht[2],00,00,00)->formatJalaliDate();
                }
            }
        }


        return count($takht)>0?$takht:'notfound';
    }

    public function totalTakht()
    {
        $takht=Takht::all();
        return count($takht)!=0?count($takht):0;
    }


    public function getEmptyTakhtByDateInPansion($pansionId, $reserveType, $raft, $bargasht)
    {
        $existTakht=[];

        $raftMiladiCarbon     = Carbon::createFromDate($raft['year'], $raft['month'], $raft['day'], 'Asia/Tehran');
        $bargashtMiladiCarbon = Carbon::createFromDate($bargasht['year'], $bargasht['month'], $bargasht['day'], 'Asia/Tehran');



        //===============================================================
        $takhtss=Takht::with(['reservetype','room','order'])
            ->whereHas('room',function ($req) use ($pansionId){
                $req->where('pansion_id',$pansionId);
            })
            ->where(function ($reserve) use ($reserveType){
                $reserve->where('reservetype_id',$reserveType)
                    ->orWhere('reservetype_id',3);
            })
            ->whereHas('order',function ($qe) use ($raftMiladiCarbon,$bargashtMiladiCarbon){
                $qe->where(function ($q) use ($raftMiladiCarbon, $bargashtMiladiCarbon) {
                    $q->whereDate('raft', '>=', $raftMiladiCarbon)
                        ->whereDate('raft', '<=', $bargashtMiladiCarbon)->whereIn('status_order_id', ['1','7']);

                })
                ->orWhere(function ($q) use ($raftMiladiCarbon, $bargashtMiladiCarbon) {
                    $q->whereDate('bargasht', '<=', Date::create($bargashtMiladiCarbon))
                        ->whereDate('bargasht', '>=', Date::create($raftMiladiCarbon))->whereIn('status_order_id', ['1','7']);

                })
                ->orWhere(function ($q) use ($raftMiladiCarbon, $bargashtMiladiCarbon) {
                    $q->whereDate('bargasht', '>=', Date::create($bargashtMiladiCarbon))
                        ->whereDate('bargasht', '>=', Date::create($raftMiladiCarbon))
                        ->whereDate('raft', '<=', Date::create($raftMiladiCarbon))
                        ->whereDate('raft', '<=', Date::create($bargashtMiladiCarbon))
                        ->where('status_order_id', '1');
                });
            })
            ->get();

        foreach ($takhtss as $takhte) {
            array_push($existTakht,$takhte->id);
        }

        $takhts=Takht::with(['reservetype','room','order'])
            ->whereHas('room',function ($req) use ($pansionId){
                $req->where('pansion_id',$pansionId);
            })
            ->where(function ($reserve) use ($reserveType){
                $reserve->where('reservetype_id',$reserveType)
                    ->orWhere('reservetype_id',3);
            })
            ->whereNotIn('id',$existTakht)
            ->get();

        foreach ($takhts as $takht){
            $takht['roomnumber']=$takht->room->roomnumber;
        }
        return count($takhts)!=0?$takhts:'notfound';
        //===============================================================
//        $takhtss=Takht::with(['reservetype','room','order'])
//            ->whereHas('room',function ($req) use ($pansionId){
//                $req->where('pansion_id',$pansionId);
//            })
//            ->where(function ($reserve) use ($reserveType){
//                $reserve->where('reservetype_id',$reserveType)
//                    ->orWhere('reservetype_id',3);
//            })
//            ->whereHas('order',function ($qe) use ($raft,$bargasht){
//                $qe->where(function ($q) use ($raft, $bargasht) {
//                $q->whereDate('raft', '>=', Date::create($raft))
//                    ->whereDate('raft', '<=', Date::create($bargasht))->whereIn('status_order_id', ['1','7']);
//
//            })
//            ->orWhere(function ($q) use ($raft, $bargasht) {
//                $q->whereDate('bargasht', '<=', Date::create($bargasht))
//                    ->whereDate('bargasht', '>=', Date::create($raft))->whereIn('status_order_id', ['1','7']);
//
//            })
//            ->orWhere(function ($q) use ($raft, $bargasht) {
//                $q->whereDate('bargasht', '>=', Date::create($bargasht))
//                    ->whereDate('bargasht', '>=', Date::create($raft))
//                    ->whereDate('raft', '<=', Date::create($raft))
//                    ->whereDate('raft', '<=', Date::create($bargasht))
//                    ->where('status_order_id', '1');
//            });
//              })
//            ->get();
//
//        foreach ($takhtss as $takhte) {
//            array_push($existTakht,$takhte->id);
//        }
//
//        $takhts=Takht::with(['reservetype','room','order'])
//            ->whereHas('room',function ($req) use ($pansionId){
//                $req->where('pansion_id',$pansionId);
//            })
//            ->where(function ($reserve) use ($reserveType){
//                $reserve->where('reservetype_id',$reserveType)
//            ->orWhere('reservetype_id',3);
//            })
//            ->whereNotIn('id',$existTakht)
//            ->get();
//
//        foreach ($takhts as $takht){
//            $takht['roomnumber']=$takht->room->roomnumber;
//        }
//        return count($takhts)!=0?$takhts:'notfound';
    }


    public function getEmptyTakhtByDateInRoom($roomId,$raft,$bargasht,$reserveType){
        $existTakht=[];
        $takhtss=Takht::with(['reservetype','room','order'])
            ->where('room_id',$roomId)
            ->where(function ($reserve) use ($reserveType){
                $reserve->where('reservetype_id',$reserveType)
                    ->orWhere('reservetype_id',3);
            })
            ->whereHas('order',function ($qe) use ($raft,$bargasht){
                $qe->where(function ($q) use ($raft, $bargasht) {
                    $q->whereDate('raft', '>=', Date::create($raft))
                        ->whereDate('raft', '<=', Date::create($bargasht))->where('status_order_id', '1');

                })
                    ->orWhere(function ($q) use ($raft, $bargasht) {
                        $q->whereDate('bargasht', '<=', Date::create($bargasht))
                            ->whereDate('bargasht', '>=', Date::create($raft))->where('status_order_id', '1');

                    })
                    ->orWhere(function ($q) use ($raft, $bargasht) {
                        $q->whereDate('bargasht', '>=', Date::create($bargasht))
                            ->whereDate('bargasht', '>=', Date::create($raft))
                            ->whereDate('raft', '<=', Date::create($raft))
                            ->whereDate('raft', '<=', Date::create($bargasht))
                            ->where('status_order_id', '1');

                    });
            })


            ->get();

        foreach ($takhtss as $takhte) {
            array_push($existTakht,$takhte->id);
        }

        $takhts=Takht::with(['reservetype','room','order'])
            ->where('room_id',$roomId)
            ->where(function ($reserve) use ($reserveType){
                $reserve->where('reservetype_id',$reserveType)
                    ->orWhere('reservetype_id',3);
            })
            ->whereNotIn('id',$existTakht)


            ->get();

        foreach ($takhts as $takht){

            $takht['roomnumber']=$takht->room->roomnumber;
        }
        return count($takhts)!=0?$takhts:'notfound';
    }

    public function getAllReservetype()
    {
        $reservetype=Reservetype::all();
        return count($reservetype)!=0?$reservetype:'notfound';
    }


    public function getTakhtByRoomOrderPrice($floor,$raft,$bargasht)
    {
        $existTakht=[];
        $takhtss=Takht::with(['reservetype','room','order'])
            ->whereHas('room',function ($q) use ($floor){
                $q->where('floor',$floor);
            })
            ->whereHas('order',function ($qe) use ($raft,$bargasht){
                $qe->where(function ($q) use ($raft, $bargasht) {
                    $q->whereDate('raft', '>=', Date::create($raft))
                        ->whereDate('raft', '<=', Date::create($bargasht))->where('status_order_id', '1');

                })
                    ->orWhere(function ($q) use ($raft, $bargasht) {
                        $q->whereDate('bargasht', '<=', Date::create($bargasht))
                            ->whereDate('bargasht', '>=', Date::create($raft))->where('status_order_id', '1');

                    })
                    ->orWhere(function ($q) use ($raft, $bargasht) {
                        $q->whereDate('bargasht', '>=', Date::create($bargasht))
                            ->whereDate('bargasht', '>=', Date::create($raft))
                            ->whereDate('raft', '<=', Date::create($raft))
                            ->whereDate('raft', '<=', Date::create($bargasht))
                            ->where('status_order_id', '1');

                    });
            })->get();
        foreach ($takhtss as $takhte) {
            array_push($existTakht,$takhte->id);
        }
        $takhts=Takht::with(['reservetype','room','order'])
            ->whereHas('room',function ($q) use ($floor){
                $q->where('floor',$floor);
            })
            ->whereNotIn('id',$existTakht)
            ->get();
    foreach ($takhts as $takht){
        if ($takht->photo()!=null){
            if ($takht->photo()->where('pick','1')->first()!=null){
            $takht['showPhoto']=$takht->photo()->where('pick','1')->first()->path;
        }
        }
        else{
            $takht['showPhoto']="aa";
        }

    }

      return count($takhts)!=0?$takhts:'notfound';
    }
    public function getTakhtByRoomOrderPriceLimitOffsset($floor,$raft,$bargasht,$limit,$offset)
    {
        $existTakht=[];
        $takhtss=Takht::with(['reservetype','room','order'])
            ->whereHas('room',function ($q) use ($floor){
                $q->where('floor',$floor);
            })
            ->whereHas('order',function ($qe) use ($raft,$bargasht){
                $qe->where(function ($q) use ($raft, $bargasht) {
                    $q->whereDate('raft', '>=', Date::create($raft))
                        ->whereDate('raft', '<=', Date::create($bargasht))->where('status_order_id', '1');

                })
                    ->orWhere(function ($q) use ($raft, $bargasht) {
                        $q->whereDate('bargasht', '<=', Date::create($bargasht))
                            ->whereDate('bargasht', '>=', Date::create($raft))->where('status_order_id', '1');

                    })
                    ->orWhere(function ($q) use ($raft, $bargasht) {
                        $q->whereDate('bargasht', '>=', Date::create($bargasht))
                            ->whereDate('bargasht', '>=', Date::create($raft))
                            ->whereDate('raft', '<=', Date::create($raft))
                            ->whereDate('raft', '<=', Date::create($bargasht))
                            ->where('status_order_id', '1');

                    });
            })->get();
        foreach ($takhtss as $takhte) {
            array_push($existTakht,$takhte->id);
        }
        $takhts=Takht::with(['reservetype','room','order'])
            ->whereHas('room',function ($q) use ($floor){
                $q->where('floor',$floor);
            })
            ->whereNotIn('id',$existTakht)
            ->limit($limit)
            ->offset($offset)
            ->get();
    foreach ($takhts as $takht){
        if ($takht->photo()!=null){
            if ($takht->photo()->where('pick','1')->first()!=null){
            $takht['showPhoto']=$takht->photo()->where('pick','1')->first()->path;
            $takht['roomnumber']=$takht->room->roomnumber;
        }
        }
        else{
            $takht['showPhoto']="aa";
        }

    }
      return count($takhts)!=0?$takhts:'notfound';
    }


    //=================== zizi
    public function getRelatedTakhtToPansion($PansionId, $reserveType)
    {
         $roomsList = Room::where('pansion_id', $PansionId)->pluck('id');
         $takhtsList = Takht::whereIn('room_id', $roomsList)->pluck('id','takhtnumber');


         return $takhtsList;
    }




}
