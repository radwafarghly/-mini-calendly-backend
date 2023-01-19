<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    /**
     *
     */
    protected $table = 'schedules';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    /**
     * Get the user that owns the comment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The days that belong to the schedule.
     */
    public function days()
    {
        return $this->belongsToMany(Day::class, 'schedule_days', 'schedule_id', 'day_id')->withPivot('time_from', 'time_to', 'user_id');
    }
}
