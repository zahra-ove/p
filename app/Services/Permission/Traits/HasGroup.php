<?php


namespace App\Services\Permission\Traits;


use App\Models\Group;
use App\Models\Permission;

trait HasGroup
{
    public function giveGroupToUser(...$groups)
    {
        $groups = $this->getAllGroups($groups);
        if ($groups->isEmpty()) {
            return $this;
        }
        $this->groups()->syncWithoutDetaching($groups);
        return $this;
    }

    public function refreshGroups(...$groups)
    {
        $groups = $this->getAllGroups($groups);
        $this->groups()->sync($groups);
        return $this;
    }

    public function deleteGroups(...$groups)
    {
        $groups = $this->getAllGroups($groups);
        $this->groups()->detach($groups);
        return $this;
    }

    public function hasGroup(string $group)
    {
        return $this->groups->contains("name_en", $group);
    }

    public function getAllGroups(array $groups)
    {
        return Group::whereIn("name_en", array_flatten($groups))->get();
    }


    public function hasPermission($permission)
    {

        if (Permission::where(['name_en' => $permission])->exists()) {
            $permission = Permission::where(['name_en' => $permission])->first();
            foreach ($this->group as $group) {
                if ($group->hasPermissionsThroughGroups($permission))
                    return true;
            }
            return false;
        }
        return false;
    }

    public function hasGroupPermission($group, $permission)
    {
        if (Group::where(['name_en' => $group])->exists()) {
            if (Permission::where(['name_en' => $permission])->exists()) {
                $permission = Permission::where(['name_en' => $permission])->first();
                if ($group->hasPermissionsThroughGroups($permission))
                    return true;
                return false;
            }
            return false;
        }
        return false;
    }

}
