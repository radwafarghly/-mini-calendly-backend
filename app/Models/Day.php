<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory;

    /**
     *
     */
    protected $table = 'days';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The schedules that belong to the day.
     */
    public function schedules()
    {
        return $this->belongsToMany(Day::class, 'schedule_days', 'day_id', 'schedule_id')->withPivot('time_from', 'time_to', 'user_id');
    }
}
