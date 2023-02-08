<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habit extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'color',
        'question',
        'notes',
        'times',
        'multiplier',
        'unit',
        'frequency_sentence',
        'visibility',
        'owner_id',
    ]; 

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class);
    }

    public function completedHabits()
    {
        return $this->hasMany(CompletedHabit::class);
    }
}
