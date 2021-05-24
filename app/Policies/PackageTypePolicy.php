<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PackageType;
use Illuminate\Auth\Access\HandlesAuthorization;

class PackageTypePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the packageType can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list packagetypes');
    }

    /**
     * Determine whether the packageType can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PackageType  $model
     * @return mixed
     */
    public function view(User $user, PackageType $model)
    {
        return $user->hasPermissionTo('view packagetypes');
    }

    /**
     * Determine whether the packageType can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create packagetypes');
    }

    /**
     * Determine whether the packageType can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PackageType  $model
     * @return mixed
     */
    public function update(User $user, PackageType $model)
    {
        return $user->hasPermissionTo('update packagetypes');
    }

    /**
     * Determine whether the packageType can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PackageType  $model
     * @return mixed
     */
    public function delete(User $user, PackageType $model)
    {
        return $user->hasPermissionTo('delete packagetypes');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PackageType  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete packagetypes');
    }

    /**
     * Determine whether the packageType can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PackageType  $model
     * @return mixed
     */
    public function restore(User $user, PackageType $model)
    {
        return false;
    }

    /**
     * Determine whether the packageType can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PackageType  $model
     * @return mixed
     */
    public function forceDelete(User $user, PackageType $model)
    {
        return false;
    }
}
