<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHabitRequest;
use App\Http\Requests\UpdateHabitRequest;
use App\Models\Habit;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class HabitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // last seven days
        $dateRage = CarbonPeriod::create(Carbon::now()->subDays(6), Carbon::now());
        
        $habits = Auth::user()->habits()->get()->each(function ($habit) use ($dateRage) {
            $days = [];

            foreach($dateRage as $day) {
                array_push($days, 
                    [
                        'day' => $day->format('Y-m-d'),
                        'completed' => Auth::user()->hasCompletedHabit($habit, $day),
                        'needs_completion' => false, // TODO
                    ]
                );
            }

            $days = array_reverse($days);

            $habit['days'] = $days;

            return $habit;
        });

        $days = [];

        foreach($dateRage as $day) {
            array_push($days, 
                [
                    'D' => $day->format('D'),
                    'j' => $day->format('j'), 
                    'date' => $day->format('Y-m-d'),
                ]
            );
        }

        $days = array_reverse($days);

        return Inertia::render('Habits/Index', [
            'habits' => $habits,
            'date_range' => $days,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreHabitRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHabitRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Habit  $habit
     * @return \Illuminate\Http\Response
     */
    public function show(Habit $habit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Habit  $habit
     * @return \Illuminate\Http\Response
     */
    public function edit(Habit $habit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateHabitRequest  $request
     * @param  \App\Models\Habit  $habit
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHabitRequest $request, Habit $habit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Habit  $habit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Habit $habit)
    {
        //
    }
}
