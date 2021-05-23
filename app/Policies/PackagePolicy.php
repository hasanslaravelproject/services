<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Package;
use Illuminate\Auth\Access\HandlesAuthorization;

class PackagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the package can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list packages');
    }

    /**
     * Determine whether the package can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Package  $model
     * @return mixed
     */
    public function view(User $user, Package $model)
    {
        return $user->hasPermissionTo('view packages');
    }

    /**
     * Determine whether the package can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create packages');
    }

    /**
     * Determine whether the package can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Package  $model
     * @return mixed
     */
    public function update(User $user, Package $model)
    {
        return $user->hasPermissionTo('update packages');
    }

    /**
     * Determine whether the package can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Package  $model
     * @return mixed
     */
    public function delete(User $user, Package $model)
    {
        return $user->hasPermissionTo('delete packages');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Package  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete packages');
    }

    /**
     * Determine whether the package can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Package  $model
     * @return mixed
     */
    public function restore(User $user, Package $model)
    {
        return false;
    }

    /**
     * Determine whether the package can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Package  $model
     * @return mixed
     */
    public function forceDelete(User $user, Package $model)
    {
        return false;
    }
}
