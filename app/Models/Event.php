<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    /**
     *
     */
    protected $table = 'events';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];


    /**
     * Get the user that owns the event.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the schedule that owns the event.
     */
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
