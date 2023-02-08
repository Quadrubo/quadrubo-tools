<?php

namespace App\Http\Controllers;

use App\Actions\CompleteHabitAction;
use App\Models\Habit;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CompleteHabitController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Habit $habit, string $day, CompleteHabitAction $completeHabitAction)
    {
        $day = Carbon::parse($day);

        $user = Auth::user();

        $completeHabitAction->execute($habit, $day, $user);
    }
}
