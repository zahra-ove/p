<?php


namespace App\Services\Permission\Traits;


use App\Models\Permission;

trait HasPermission
{

    public function givePermissionToGroups(...$permissions)
    {
        $permissions=$this->getAllPermissions($permissions);
        if ($permissions->isEmpty()) return $this;

        $this->permissions()->syncWithoutDetaching($permissions);
        return $this;
    }

    public function deletePermissions(...$permissions)
    {
        $permissions=$this->getAllPermissions($permissions);
        $this->permissions()->detach($permissions);
        return $this;
    }

    public function refreshPermissionOfGroup(...$permissions)
    {
        $permissions=$this->getAllPermissions($permissions);
        $this->permissions()->sync($permissions);
        return $this;
    }

    public function getAllPermissions(array $permissions)
    {
        return Permission::whereIn("name_en",array_flatten($permissions))->get();
    }

    public function existsPermission($permission)
    {
        return Permission::where("name_en",$permission)->exists();
    }

    public function hasPermissionsThroughGroups(Permission $permission)
    {
        return $this->permission->contains($permission);
    }

}
