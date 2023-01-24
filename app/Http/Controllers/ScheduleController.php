<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScheduleFormRequest;
use App\Http\Resources\ScheduleResource;
use App\Http\Resources\Utility\ResponseType;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    //

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $result = Schedule::where('user_id', Auth::user()->id)->get();
        if ($result->isEmpty()) {
            return (new ScheduleResource([]))->additional(ResponseType::simpleResponse('No Schedules found', false));
        }
        return ScheduleResource::collection($result)
            ->additional(ResponseType::simpleResponse('Schedules result', true));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  CategoryFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ScheduleFormRequest $request)
    {
        $data = $request->validated();
        return (new ScheduleResource(Schedule::create($data)))->additional(ResponseType::simpleResponse('Schedule created successfully', true));
    }

    /**
     * Display the specified resource.
     *
     * @param  Schedule  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $schedule)
    {
        return (new ScheduleResource($schedule))->additional(ResponseType::simpleResponse('Schedule item', true));
    }

    /**
     * update the specified resource.
     *
     * @param  Schedule  $category
     * @return \Illuminate\Http\Response
     */
    public function update(ScheduleFormRequest $request, Schedule $schedule)
    {
        $data = $request->validated();
        Schedule::where('id', $schedule->id)->update($data);
        return (new ScheduleResource(Schedule::find($schedule->id)))->additional(ResponseType::simpleResponse('Schedule created successfully', true));
    }
}
