<?php


namespace App\Services\Admin\Naqdtype;


use App\Models\Naqdtype;

class NaqdtypeService
{


    public function getAllNaqdtypes()
    {
        $naqd=Naqdtype::all();
        return count($naqd)>0?$naqd:"notfound";
    }

    public function insertNaqdtype($title)
    {
        $naqd=new Naqdtype();
        $naqd->title=$title;
        if ($naqd->save()){
            return 'ok';
        }
        else{
            return 'notfound';
        }
    }

    public function editNaqdtype($id,$title)
    {
        $naqd=Naqdtype::find($id);
        $naqd->title=$title;
        if ($naqd->save()){
            return 'ok';
        }
        else{
            return 'notfound';
        }
    }

    public function deleteNaqdType($id)
    {
        $naqd=Naqdtype::find($id);
        if ($naqd->delete()){
            return 'ok';
        }
        else{
            return 'notfound';
        }
    }
}
