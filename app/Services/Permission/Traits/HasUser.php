<?php


namespace App\Services\Permission\Traits;


use App\Models\User;
use App\Models\Permission;

trait HasUser
{

    public function hasPermissions($permission)
    {

        if (Permission::with('user')->where(['name_en' => $permission])->exists()) {
            $permission = Permission::where(['name_en' => $permission])->first();


                if ($this->hasPermissionsThroughGroups($permission))
                    return true;

            return false;
        }
        return false;
    }



}
