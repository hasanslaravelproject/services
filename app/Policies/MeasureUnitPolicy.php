<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MeasureUnit;
use Illuminate\Auth\Access\HandlesAuthorization;

class MeasureUnitPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the measureUnit can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list measureunits');
    }

    /**
     * Determine whether the measureUnit can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MeasureUnit  $model
     * @return mixed
     */
    public function view(User $user, MeasureUnit $model)
    {
        return $user->hasPermissionTo('view measureunits');
    }

    /**
     * Determine whether the measureUnit can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create measureunits');
    }

    /**
     * Determine whether the measureUnit can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MeasureUnit  $model
     * @return mixed
     */
    public function update(User $user, MeasureUnit $model)
    {
        return $user->hasPermissionTo('update measureunits');
    }

    /**
     * Determine whether the measureUnit can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MeasureUnit  $model
     * @return mixed
     */
    public function delete(User $user, MeasureUnit $model)
    {
        return $user->hasPermissionTo('delete measureunits');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MeasureUnit  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete measureunits');
    }

    /**
     * Determine whether the measureUnit can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MeasureUnit  $model
     * @return mixed
     */
    public function restore(User $user, MeasureUnit $model)
    {
        return false;
    }

    /**
     * Determine whether the measureUnit can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MeasureUnit  $model
     * @return mixed
     */
    public function forceDelete(User $user, MeasureUnit $model)
    {
        return false;
    }
}
