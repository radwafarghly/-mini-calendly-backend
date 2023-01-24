<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScheduleDayFormRequest;
use App\Http\Requests\ScheduleFormRequest;
use App\Http\Resources\ScheduleResource;
use App\Http\Resources\Utility\ResponseType;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleDayController extends Controller
{
    // this function assgin day to schedule  and update assigned day 
    public function assginDayToSchedule(ScheduleDayFormRequest $request, Schedule $schedule)
    {
        $data = $request->validated();
        $exists = $schedule->days->contains($data['day_id']);

        if ($exists) {
            //update time of assigned day
            $schedule->days()->updateExistingPivot($data['day_id'], ['time_from' => $data['time_from'], 'time_to' => $data['time_to']]);
        } else {
            //assgin new day to schedule
            $schedule->days()->attach($data['day_id'], ['time_from' => $data['time_from'], 'time_to' => $data['time_to'], 'user_id' => Auth::user()->id]);
        }

        return (new ScheduleResource(Schedule::find($schedule->id)))->additional(ResponseType::simpleResponse('Schedule time add successfully', true));
    }



    // this function delete assgined day from  schedule 

    public function deleteDayToSchedule(ScheduleDayFormRequest $request, Schedule $schedule)
    {
        $data = $request->validated();
        $exists = $schedule->days->contains($data['day_id']);

        if ($exists) {
            $schedule->days()->detach($data['day_id']);
        }
        return (new ScheduleResource(Schedule::find($schedule->id)))->additional(ResponseType::simpleResponse('Schedule time delete  successfully', true));
    }
}
