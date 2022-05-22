<?php


namespace App\Services\Admin\Room;


use App\Models\Photo;
use App\Models\Pvemkanat;
use App\Models\Room;
use App\Models\Takht;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RoomService
{
    public function getAllRooms()
    {

        $rooms=Room::with(['pansion'])->get();
        foreach ($rooms as $room){
            $room['pansionName']=$room->pansion->name;
        }
        return count($rooms)>0?$rooms:'notfound';

    }


    public function getRoomById($id)
    {
        $rooms=Room::with(['pansion','photo'])->find($id);
$rooms['photos']=$rooms->photo;
        return isset($rooms)?$rooms:'notfound';
    }


    public function insertRoom($roomnumber,$counttakhts,$floor,$pansionId,$show,$pubId,$priTitle,$file)
    {
        $privateDesc=[];
        $privateTitle=[];
        $room= new Room();
        $room->roomnumber=$roomnumber;
        $room->counttakht=$counttakhts;
        $room->pansion_id=$pansionId;
        $room->floor=$floor;
        $room->show=$show;
        $room->capacity=$counttakhts;
        DB::beginTransaction();
        if ($room->save()){
            if (count($pubId)!=0) {
                for ($i = 0; $i < count($pubId); $i++) {


                    $room->pubemkanat()->attach(intval($pubId[$i]));

                }
            }

            if ($priTitle!=null ){
                foreach ($priTitle as $p){
                    if ($p!=null){
                        array_push($privateTitle,$p);
                    }

                }

                for ($i=0;$i<count($privateTitle);$i++) {
                    $private = new Pvemkanat();
                    $private->title=$privateTitle[$i];
                    $private->room_id=$room->id;
                    $private->save();


                }
            }
            for ($i=0;$i<count($file);$i++){
                $photo = new Photo();
                $photo->picable_id = $room->id;
                $photo->picable_type = "App\Models\Room";
                $filename=$file[$i]->getClientOriginalName();
                $path = 'storage/images/room/' . $filename;
                $photo->path=$path;
                if ($i==0){
                    $photo->pick='1';
                }
                else{
                    $photo->pick='0';
                }

                $photo->save();
                $file[$i]->storeAs('public/images/room/', $filename);
            }
            DB::commit();
            return "ok";
        }
        else{
            DB::rollback();
            return "notfound";
        }


    }

    public function getRoomByPansion($id)
    {
        $rooms=Room::with('pansion')->where('pansion_id',$id)->get();
        foreach ($rooms as $room){
            if (count($room->photo)!=0){
                $room['showPhoto']=$room->photo->first()->path;
            }
        }

        return count($rooms)>0?$rooms:'notfound';
    }

    public function getRoomByPansionByUniqueFloor($id)
    {
        $rooms=Room::with('pansion')->where('pansion_id',$id)->get();
        foreach ($rooms as $room){
            if (count($room->photo)!=0){
                 if (count($room->photo)!=0){
                $room['showPhoto']=$room->photo->first()->path;
            }
            }
        }

        return count($rooms)>0?$rooms:'notfound';
    }

    public function getEmptyRoomByPansion($id)
    {
        $rooms=Room::with('pansion')->where('pansion_id',$id)->get();
        foreach ($rooms as $room){
            if (count($room->photo)!=0){
                $room['showPhoto']=$room->photo->first()->path;
            }
        }

        return count($rooms)>0?$rooms:'notfound';
    }

    public function deleteRoomById($id)
    {
        $room = $this->getRoomById($id);
        DB::beginTransaction();
//        if (count($room->pubemkanat) != 0)
//        {
            $room->pubemkanat()->detach();
//    }
        if ($room->delete()){
            DB::commit();
            return 'ok';
        }
        else{
            DB::rollBack();
            return 'notfound';
        }
    }

    public function editRoom($id, $roomnumber, $show, $counttakht, $floor,$pansionId,$pubemkanat,$privates,$file,$pick)
    {

        $rooms = Room::find($id);
        $full=$rooms->counttakht-$rooms->capacity;
        $capacity=$counttakht-$full;
        if ($capacity<0){
            $capacity=0;
        }
        $rooms->roomnumber = $roomnumber;
        $rooms->capacity = $capacity;
        $rooms->show = $show;
        $rooms->counttakht = $counttakht;
        $rooms->floor = $floor;
        $rooms->pansion_id = $pansionId;
        DB::beginTransaction();
        if ($file!=null){
            for ($i=0;$i<count($file);$i++){
                $photo = new Photo();
                $photo->picable_id = $rooms->id;
                $photo->picable_type = "App\Models\Room";
                $filename=$file[$i]->getClientOriginalName();
                $path = 'storage/images/room/' . $filename;
                $photo->path=$path;
                if ($filename==$pick){
                    foreach ($rooms->photo as $p) {
                        $p->pick = '0';
                        $p->save();
                    }
                    $photo->pick='1';

                }
                else{

                    $photo->pick='0';
                }
                $photo->save();
                $file[$i]->storeAs('public/images/room/', $filename);
            }
        }
        if (is_numeric($pick)==true){
            foreach ($rooms->photo as $p){
                $p->pick='0';
                $p->save();
                if ($pick==$p->id){
                    $p->pick='1';
                    $p->save();
                }
            }
        }
        $rooms->pvemkanat()->delete();
        $rooms->pubemkanat()->detach();
        if ($pubemkanat!=null) {
            for ($i = 0; $i < count($pubemkanat); $i++) {


                $rooms->pubemkanat()->attach(intval($pubemkanat[$i]));
            }
        }
        if ($rooms->save()) {
            if ($privates!=null) {
                for ($i = 0; $i < count($privates); $i++) {
                    if ($privates[$i] != null) {
                        $private = new Pvemkanat();
                        $private->title = $privates[$i];
                        $private->room_id = $rooms->id;
                        $private->save();
                    }

                }
            }
            DB::commit();
            return "ok";
        } else {
            DB::rollBack();
            return 'notfound';
        }

    }

    public function totalRoom()
    {
        $room=Room::all();
        return count($room)!=0?count($room):0;
    }

    //@zizi
    public function getRoomTakhtNumber($id)
    {
        $takhts = Takht::where('room_id', $id)->get();   // number of takhts
        return $count = $takhts->count();
    }

}
