<?php


namespace App\Services\Admin\Cities;


use App\Models\City;
use App\Models\Ostan;
use App\Models\Photo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CityService
{

    public function getAllCities()
    {
        $city=DB::table('cities as c')->select(['c.name as cityName','c.id','o.name as ostanName','c.ostan_id','ph.path as pathImage'])
            ->join('ostans as o','c.ostan_id','=','o.id')
            ->leftJoin('photos as ph',function ($join){
                $join->on('ph.picable_id','c.id')->where('picable_type','regexp','City');
            })
            ->whereNull('c.deleted_at')
            ->get();

        return count($city)>0? $city:"notfound";
    }

    public function getCityById($id)
    {
        $city=City::find($id);
        return isset($city)? $city:"notfound";
    }

    public function insertCity($name,$ostan_id,$file)
    {

        $city=new City();
        $city->name=$name;
        $city->ostan_id=$ostan_id;
        DB::beginTransaction();
        if ($city->save()){
if ($file!=null){

            $photo = new Photo();
            $photo->picable_id = $city->id;
            $photo->picable_type = "App\Models\City";
            $filename=$file->getClientOriginalName();
            $path = 'storage/images/city/' . $filename;
            $photo->path=$path;
            $photo->save();
            $file->storeAs('public/images/city/', $filename);
}
            DB::commit();
            return "ok";
        }
        else{
            DB::rollback();
            return "notfound";
        }

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


    public function getCityByCategory($id)
    {
        $cities = DB::table('cities')
            ->join('users', 'cities.id', '=', 'users.city_id')
            ->join('product_user', 'users.id', '=', 'product_user.user_id')
            ->join('products', 'products.id', '=', 'product_user.product_id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('cities.id as cityid', 'cities.name as cityname')
            ->where('categories.id', $id)->distinct()
            ->get();

        return count($cities) ? $cities : 'notFound';
    }


    public function deleteCityById($id)
    {
       $city = City::with('photo')->find($id);
       if ($city->delete()){
           $city->photo()->delete();
           return "ok";
       }
       else
       {
           return "notfound";
       }
    }

    public function editCity($id,$name,$ostan,$photo)
    {
        $city = City::with('photo')->find($id);
        $city->name = $name;
        $city->ostan_id = $ostan;

        if ($city->save()){

if ($photo!=null) {
    if (count($city->photo) > 0) {
        $filename = $photo->getClientOriginalName();
        $path = 'storage/images/city/' . $filename;
        $photo->storeAs('public/images/city/', $filename);
        $city->photo[0]->path = $path;

        $city->photo[0]->save();
    } else {
        $photos = new Photo();
        $photos->picable_id = $city->id;
        $photos->picable_type = "App\Models\City";
        $filename = $photo->getClientOriginalName();
        $path = 'storage/images/city/' . $filename;
        $photos->path = $path;
        $photos->save();
        $photo->storeAs('public/images/city/', $filename);
    }
}
            return 'ok' ;
        }
        else
        {
            return 'notfound';
        }

    }


    public function getCityByOstan($id)
    {
        $ostans=City::where('ostan_id',$id)->get();

        return count($ostans)!=0?$ostans:'notfound';
    }

}
