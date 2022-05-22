<?php


namespace App\Services\Admin\Room;


use App\Models\Pubemkanat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class pubService
{
    public function getAllPubemkanats()
    {
        $pubemkanats=Pubemkanat::all();

        return count($pubemkanats)>0?$pubemkanats:'notfound';

    }


    public function getPubemkanatById($id)
    {
        $pubemkanats=Pubemkanat::find($id);

        return isset($pubemkanats)?$pubemkanats:'notfound';
    }

    public function insertPubemkanat($title)
    {
            $allPublic=Pubemkanat::all();
        $pubemkanat= new Pubemkanat();
        $pubemkanat->title=$title;

        if ($pubemkanat->save()){

            return 'ok';
        }
        else{

            return "notfound";
        }


    }


    public function deletePubemkanat($id)
    {
        $pubemkanats=Pubemkanat::find($id);

        if ($pubemkanats->delete()){
            return 'ok';
        }
        else{
            return 'notfound';
        }
    }



}
