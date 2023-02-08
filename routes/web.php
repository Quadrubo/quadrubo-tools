<?php

use App\Http\Controllers\CompleteHabitController;
use App\Http\Controllers\HabitController;
use App\Http\Controllers\UncompleteHabitController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', function () {
        return to_route('habits.index');
    });
    
    Route::resource('habits', HabitController::class)
        ->only(['index']);

    Route::post('/habits/{habit}/{day}/complete', CompleteHabitController::class)->name('habits.complete');
    Route::post('/habits/{habit}/{day}/uncomplete', UncompleteHabitController::class)->name('habits.uncomplete');
});
