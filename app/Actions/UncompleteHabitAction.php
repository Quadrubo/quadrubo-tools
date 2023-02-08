<?php
namespace App\Actions;

use App\Models\Habit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UncompleteHabitAction
{
    public function execute(Habit $habit, Carbon $day, ?User $user)
    {
        if (!Auth::check()) {
            // flash()->overlay('Sie müssen angemeldet sein um die Warteliste zu benutzen.', 'Fehler')->error();
            return back();
        }

        if (!$user->isMemberOfHabit($habit)) {
            //
            return back();
        }

        if (!$user->hasCompletedHabit($habit, $day)) {
            //
            return back();
        }

        $habit->completedHabits()->where('user_id', $user->id)->whereDate('completed_on', $day->format('Y-m-d'))->delete();
    }
}
