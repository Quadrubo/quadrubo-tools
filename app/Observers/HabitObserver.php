<?php

namespace App\Observers;

use App\Models\Habit;

class HabitObserver
{
    /**
     * Handle the Habit "created" event.
     *
     * @param  \App\Models\Habit  $habit
     * @return void
     */
    public function created(Habit $habit)
    {
        // Automatically make the owner a member of a habit
        $owner = $habit->owner()->first();

        $habit->members()->attach($owner->id);
    }

    /**
     * Handle the Habit "updated" event.
     *
     * @param  \App\Models\Habit  $habit
     * @return void
     */
    public function updated(Habit $habit)
    {
        //
    }

    /**
     * Handle the Habit "deleted" event.
     *
     * @param  \App\Models\Habit  $habit
     * @return void
     */
    public function deleted(Habit $habit)
    {
        //
    }

    /**
     * Handle the Habit "restored" event.
     *
     * @param  \App\Models\Habit  $habit
     * @return void
     */
    public function restored(Habit $habit)
    {
        //
    }

    /**
     * Handle the Habit "force deleted" event.
     *
     * @param  \App\Models\Habit  $habit
     * @return void
     */
    public function forceDeleted(Habit $habit)
    {
        //
    }
}
