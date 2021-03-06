<?php

namespace SBD\Softadmin\Traits;

use SBD\Softadmin\Models\Role;

/**
 * @property  \Illuminate\Database\Eloquent\Collection  roles
 */
trait SoftadminUser
{
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hasRole($name)
    {
        return $this->role->name == $name;
    }

    public function setRole($name)
    {
        $role = Role::where('name', '=', $name)->first();

        if ($role) {
            $this->role()->associate($role);
        }

        return $this;
    }

    public function hasPermission($name)
    {
        return in_array($name, $this->role->permissions->pluck('key')->toArray());
    }
}
