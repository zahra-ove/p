<?php


namespace App\Services\Admin\Permission;


use App\Models\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PermissioonService
{
    public function getAllPermissions()
    {
//        $permissions=DB::table('group_permission as gp')
//            ->join('permissions as p','gp.permission_id','=','p.id')
//        ->select(['p.name as permissionName','p.name_en as perName_en']);
        $permission=DB::table('permissions as p')->select(['p.name as permissionName','p.id','p.name_en'])
            ->get();
        return count($permission)>0? $permission:"notfound";
    }

    public function getPermissionById($id)
    {
        $permission=Permissions::find($id);
        return isset($permission)? $permission:"notfound";
    }

    public function insertPermission($name,$name_en)
    {

        $permission= new Permission();
        $permission->name = $name;
        $permission->name_en=$name_en;
        if ($permission->save()){
            return 'ok';
        }
        else{
            return "notfound";
        }
    }

    public function editPermission($id,$name,$name_en)
    {
        $permission = Permission::find($id);
        $permission->name=$name;
        $permission->name_en=$name_en;
        if ($permission->save()){
            return "ok";
        }
        else{
            return "notfound";
        }
    }


    public function deletePermission($id)
    {
        $permission = Permission::find($id);
        if ($permission->delete()){
            return "ok";
        }
        else{
            return 'notfound';
        }
    }
}
