<?php


namespace App\Services\Admin\Pansion;


use App\Models\Address;
use App\Models\Pansion;
use App\Models\Photo;
use App\Models\Takht;
use App\Models\Video;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isNan;

class PansionService
{


    public function getAllPansions()
    {
        $pansions=Pansion::with(['room','city','address'])->get();


        foreach ($pansions as $pansion){
            $kol=0;
            foreach ($pansion->room as $room){

                $kol=count($room->takht->where('status','خالی'))+$kol;
                $pansion['khali']=$kol;
            }

            $pansion['showPhoto']=$pansion->photo->first()->path;
        }


        return count($pansions)>0?$pansions:'notfound';

    }


    public function getPansionById($id)
    {
        $pansions=Pansion::with(['room','city','address'])->find($id);

        return isset($pansions)?$pansions:'notfound';
    }

    public function insertPansion($countrooms,$counttakhts,$cityId,$name,$show,$addr,$title,$vorud,$khoruj,$floors,$gender,$file,$video)
    {

        $pansion= new Pansion();
        $pansion->countrooms=$countrooms;
        $pansion->counttakhts=$counttakhts;
        $pansion->city_id=$cityId;
        $pansion->name=$name;
        $pansion->show=$show;
        $pansion->vorud=$vorud;
        $pansion->khoruj=$khoruj;
        $pansion->gender=$gender;
        $pansion->floors=$floors;

        DB::beginTransaction();
        if ($pansion->save()){
            $address= new Address();
            $address->addr=$addr;
            $address->title=$title;
            $address->city_id=$cityId;
            $address->pansion_id=$pansion->id;
            $address->save();
            for ($i=0;$i<count($file);$i++){
                $photo = new Photo();
                $photo->picable_id = $pansion->id;
                $photo->picable_type = "App\Models\Pansion";
                $filename=$file[$i]->getClientOriginalName();
                $path = 'storage/images/pansion/' . $filename;
                $photo->path=$path;
                if ($i==0){
                    $photo->pick='1';
                }
                else{
                    $photo->pick='0';
                }

                $photo->save();
                $file[$i]->storeAs('public/images/pansion/', $filename);
            }
            if ($video!=null){
                $videos= new Video();
                $videos->video_id = $pansion->id;
                $filenameVideo=$video->getClientOriginalName();
                $videos->video_type="App\Models\Pansion";
                $pathVideo = 'storage/videos/pansion/' . $filenameVideo;
                $videos->path=$pathVideo;
                $videos->save();
                $video->storeAs('public/videos/pansion/', $filenameVideo);
            }

            DB::commit();
            return "ok";
        }
        else{
            DB::rollback();
            return "notfound";
        }


    }

    public function deletePansionById($id)
    {
        $pansion=$this->getPansionById($id);
        if ($pansion->delete()){
            return 'ok';
        }
        else{
            return 'notfound';
        }
    }

    public function editPansion($id,$counttakhts,$name,$cityId,$countrooms,$show,$addr,$vorud,$khoruj,$floors,$gender,$title,$file,$video,$isvideo,$pick)
    {

        $pansion=$this->getPansionById($id);
        $pansion->name=$name;
        $pansion->city_id=$cityId;
        $pansion->countrooms=$countrooms;
        $pansion->show=$show;
        $pansion->counttakhts=$counttakhts;
        $address=$pansion->address[0];
        $pansion->vorud=$vorud;
        $pansion->khoruj=$khoruj;
        $pansion->floors=$floors;
        $pansion->gender=$gender;
        $address->addr=$addr;
        $address->title=$title;
        DB::beginTransaction();
        if ($file!=null){
        for ($i=0;$i<count($file);$i++){
            $photo = new Photo();
            $photo->picable_id = $pansion->id;
            $photo->picable_type = "App\Models\Pansion";
            $filename=$file[$i]->getClientOriginalName();
            $path = 'storage/images/pansion/' . $filename;
            $photo->path=$path;

            if ($filename==$pick){
                foreach ($pansion->photo as $p) {
                    $p->pick = '0';
                    $p->save();
                }
                $photo->pick='1';

            }
            else{

                $photo->pick='0';
            }
            $photo->save();
            $file[$i]->storeAs('public/images/pansion/', $filename);
        }
        }

        if (is_numeric($pick)==true){
            foreach ($pansion->photo as $p){
                $p->pick='0';
                $p->save();
                if ($pick==$p->id){
                    $p->pick='1';
                    $p->save();
                }
            }
        }

        if ($isvideo!=null) {
            if ($video != null) {
                $videos = new Video();
                $videos->video_id = $pansion->id;
                $filenameVideo = $video->getClientOriginalName();
                $videos->video_type = "App\Models\Pansion";
                $pathVideo = 'storage/videos/pansion/' . $filenameVideo;
                $videos->path = $pathVideo;
                $videos->save();
                $video->storeAs('public/videos/pansion/', $filenameVideo);
            }
        }
        else{
            $pansion->video()->delete();
        }
        if ($pansion->save()){
            $address->save();
            DB::commit();
            return 'ok';
        }
        else{
            DB::rollBack();
            return 'notfound';
        }
    }


    public function deletePhoto($id)
    {
        $photo=Photo::find($id);
        DB::beginTransaction();
        if ($photo->pick=='1'){
            $photo->pick='0';
            $photo->save();
            $firstPhoto=Photo::where('picable_type',$photo->picable_type)->where('picable_id',$photo->picable_id)->where('id','!=',$photo->id)->first();
            $firstPhoto->pick='1';
            $firstPhoto->save();
        }
        if ($photo->delete()){
            DB::commit();
            return 'ok';
        }
        else{
            DB::rollBack();
            return "notfound";
        }

    }




}
