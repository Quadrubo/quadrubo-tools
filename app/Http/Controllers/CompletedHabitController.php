<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompletedHabitRequest;
use App\Http\Requests\UpdateCompletedHabitRequest;
use App\Models\CompletedHabit;

class CompletedHabitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreCompletedHabitRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCompletedHabitRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CompletedHabit  $completedHabit
     * @return \Illuminate\Http\Response
     */
    public function show(CompletedHabit $completedHabit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CompletedHabit  $completedHabit
     * @return \Illuminate\Http\Response
     */
    public function edit(CompletedHabit $completedHabit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCompletedHabitRequest  $request
     * @param  \App\Models\CompletedHabit  $completedHabit
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCompletedHabitRequest $request, CompletedHabit $completedHabit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CompletedHabit  $completedHabit
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompletedHabit $completedHabit)
    {
        //
    }
}
