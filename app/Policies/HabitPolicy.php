<?php

namespace App\Policies;

use App\Models\Habit;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class HabitPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->can('view_any_habit');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Habit  $habit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Habit $habit)
    {
        return $user->can('view_habit');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('create_habit');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Habit  $habit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Habit $habit)
    {
        return $user->can('update_habit');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Habit  $habit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Habit $habit)
    {
        return $user->can('delete_habit');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Habit  $habit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Habit $habit)
    {
        return $user->can('restore_habit');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Habit  $habit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Habit $habit)
    {
        return $user->can('force_delete_habit');
    }
}