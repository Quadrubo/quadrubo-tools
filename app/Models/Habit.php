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
        'user_id',
    ]; 

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
