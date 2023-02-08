<?php

namespace App\Http\Controllers;

use App\Actions\UncompleteHabitAction;
use App\Models\Habit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UncompleteHabitController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Habit $habit, string $day, UncompleteHabitAction $uncompleteHabitAction)
    {
        $day = Carbon::parse($day);

        $user = Auth::user();

        $uncompleteHabitAction->execute($habit, $day, $user);
    }
}
