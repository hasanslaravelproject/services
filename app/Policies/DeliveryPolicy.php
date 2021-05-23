<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Delivery;
use Illuminate\Auth\Access\HandlesAuthorization;

class DeliveryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the delivery can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list deliveries');
    }

    /**
     * Determine whether the delivery can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Delivery  $model
     * @return mixed
     */
    public function view(User $user, Delivery $model)
    {
        return $user->hasPermissionTo('view deliveries');
    }

    /**
     * Determine whether the delivery can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create deliveries');
    }

    /**
     * Determine whether the delivery can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Delivery  $model
     * @return mixed
     */
    public function update(User $user, Delivery $model)
    {
        return $user->hasPermissionTo('update deliveries');
    }

    /**
     * Determine whether the delivery can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Delivery  $model
     * @return mixed
     */
    public function delete(User $user, Delivery $model)
    {
        return $user->hasPermissionTo('delete deliveries');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Delivery  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete deliveries');
    }

    /**
     * Determine whether the delivery can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Delivery  $model
     * @return mixed
     */
    public function restore(User $user, Delivery $model)
    {
        return false;
    }

    /**
     * Determine whether the delivery can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Delivery  $model
     * @return mixed
     */
    public function forceDelete(User $user, Delivery $model)
    {
        return false;
    }
}
