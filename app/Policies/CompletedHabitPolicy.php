<?php

namespace App\Policies;

use App\Models\CompletedHabit;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompletedHabitPolicy
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
        return $user->can('view_any_completed_habit');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CompletedHabit  $completedHabit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, CompletedHabit $completedHabit)
    {
        return $user->can('view_completed_habit');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('create_completed_habit');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CompletedHabit  $completedHabit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, CompletedHabit $completedHabit)
    {
        return $user->can('update_completed_habit');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CompletedHabit  $completedHabit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, CompletedHabit $completedHabit)
    {
        return $user->can('delete_completed_habit');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CompletedHabit  $completedHabit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, CompletedHabit $completedHabit)
    {
        return $user->can('restore_completed_habit');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CompletedHabit  $completedHabit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, CompletedHabit $completedHabit)
    {
        return $user->can('force_delete_completed_habit');
    }
}