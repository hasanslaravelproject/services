<?php

namespace App\Policies;

use App\Models\User;
use App\Models\RawProductStock;
use Illuminate\Auth\Access\HandlesAuthorization;

class RawProductStockPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the rawProductStock can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list rawproductstocks');
    }

    /**
     * Determine whether the rawProductStock can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\RawProductStock  $model
     * @return mixed
     */
    public function view(User $user, RawProductStock $model)
    {
        return $user->hasPermissionTo('view rawproductstocks');
    }

    /**
     * Determine whether the rawProductStock can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create rawproductstocks');
    }

    /**
     * Determine whether the rawProductStock can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\RawProductStock  $model
     * @return mixed
     */
    public function update(User $user, RawProductStock $model)
    {
        return $user->hasPermissionTo('update rawproductstocks');
    }

    /**
     * Determine whether the rawProductStock can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\RawProductStock  $model
     * @return mixed
     */
    public function delete(User $user, RawProductStock $model)
    {
        return $user->hasPermissionTo('delete rawproductstocks');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\RawProductStock  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete rawproductstocks');
    }

    /**
     * Determine whether the rawProductStock can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\RawProductStock  $model
     * @return mixed
     */
    public function restore(User $user, RawProductStock $model)
    {
        return false;
    }

    /**
     * Determine whether the rawProductStock can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\RawProductStock  $model
     * @return mixed
     */
    public function forceDelete(User $user, RawProductStock $model)
    {
        return false;
    }
}
