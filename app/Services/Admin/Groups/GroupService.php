<?php


namespace App\Services\Admin\Groups;


use App\Models\Group;
use Illuminate\Support\Facades\DB;

class GroupService
{
    public function getAllGroups()
    {
//        $permissions=DB::table('group_permission as gp')
//            ->join('permissions as p','gp.permission_id','=','p.id')
//        ->select(['p.name as permissionName','p.name_en as perName_en']);
        $group=Group::with('permission')->get();
        return count($group)>0? $group:"notfound";
    }

    public function getGroupById($id)
    {
        $group=Group::find($id);
        return isset($group)? $group:"notfound";
    }

    public function insertGroup($name,$name_en)
    {

        $group= new Group();
        $group->name = $name;
        $group->name_en=$name_en;
        if ($group->save()){
            return 'ok';
        }
        else{
            return "notfound";
        }
    }

    public function editGroup($id,$name,$name_en)
    {
        $group = Group::find($id);
        $group->name=$name;
        $group->name_en=$name_en;
        if ($group->save()){
            return "ok";
        }
        else{
            return "notfound";
        }
    }


    public function deleteGroup($id)
    {
        $group = Group::find($id);
        if ($group->delete()){
            $group->permission()->detach();
            return "ok";
        }
        else{
            return 'notfound';
        }
    }

    public function setPermission($id,$pId)
    {

        $group=Group::with('permission')->find($id);

        try {
            $group->permission()->attach($pId);
            return 'ok';
        }
        catch (\Exception $exception)
        {
            if($group->permission()->where('permission_id',$pId)->exists()){
                return 'exist';
            }
            return 'notfound';
        }
    }

    public function dettachPermissioonGroup($gId,$pId)
    {
        $group=$this->getGroupById($gId);

        try {

            $group->permission()->detach($pId);
            return 'ok';
        }
        catch (\Exception $exception)
        {

            return 'notfound';
        }
    }
}
