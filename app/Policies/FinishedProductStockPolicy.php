<?php

namespace App\Policies;

use App\Models\User;
use App\Models\FinishedProductStock;
use Illuminate\Auth\Access\HandlesAuthorization;

class FinishedProductStockPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the finishedProductStock can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list finishedproductstocks');
    }

    /**
     * Determine whether the finishedProductStock can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FinishedProductStock  $model
     * @return mixed
     */
    public function view(User $user, FinishedProductStock $model)
    {
        return $user->hasPermissionTo('view finishedproductstocks');
    }

    /**
     * Determine whether the finishedProductStock can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create finishedproductstocks');
    }

    /**
     * Determine whether the finishedProductStock can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FinishedProductStock  $model
     * @return mixed
     */
    public function update(User $user, FinishedProductStock $model)
    {
        return $user->hasPermissionTo('update finishedproductstocks');
    }

    /**
     * Determine whether the finishedProductStock can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FinishedProductStock  $model
     * @return mixed
     */
    public function delete(User $user, FinishedProductStock $model)
    {
        return $user->hasPermissionTo('delete finishedproductstocks');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FinishedProductStock  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete finishedproductstocks');
    }

    /**
     * Determine whether the finishedProductStock can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FinishedProductStock  $model
     * @return mixed
     */
    public function restore(User $user, FinishedProductStock $model)
    {
        return false;
    }

    /**
     * Determine whether the finishedProductStock can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FinishedProductStock  $model
     * @return mixed
     */
    public function forceDelete(User $user, FinishedProductStock $model)
    {
        return false;
    }
}
