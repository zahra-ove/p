<?php


namespace App\Services\Admin\Cities;



use App\Models\Ostan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OstanService
{

    public function getAllOstans()
    {
        $ostan=DB::table('ostans')->select(['id','name'])
            ->whereNull('deleted_at')
            ->get();
        return count($ostan)>0?$ostan:"notfound";
    }

    public function getOstanByid($id)
    {
        $ostan=Ostan::find($id);
        return isset($ostan)?$ostan:"notfound";
    }

    public function insertOstan($name)
    {
        $ostan = new Ostan();
        $ostan->name = $name;
        if ($ostan->save()){
            return "ok";
        }
        else{
            return "notfound";
        }
    }

    public function deleteCityById($id)
    {
        $ostan=Ostan::find($id);

        if(!$ostan)
            return false;

        try {
            DB::beginTransaction();
            $ostan->cities()->delete();
            $ostan->delete();
            DB::commit();
            return true;
        }
        catch (\Exception $exception){
            DB::rollBack();
            return false;
        }
    }

    public function editOstan($id,$name)
    {
        $ostan = Ostan::find($id);
        $ostan->name = $name;
        if($ostan->save()){
           return 'ok';
        }
        else{
            return 'notfound';
        }
    }
}
