<?php


namespace App\Services\Admin\Room;


use App\Models\Pvemkanat;
use Illuminate\Database\Eloquent\Model;

class PvService
{
    public function getAllPvemkanats()
    {
        $pvs=Pvemkanat::all();

        return count($pvs)>0?$pvs:'notfound';

    }


    public function getPvemkanatById($id)
    {
        $pvs=Pvemkanat::find($id);

        return isset($pvs)?$pvs:'notfound';
    }

    public function insertPvemkanat($title)
    {

        $pv= new Pvemkanat();
        $pv->title=$title;

        if ($pv->save()){

            return "ok";
        }
        else{

            return "notfound";
        }


    }
}
