<?php

namespace App\Http\Controllers;

use App\Http\Resources\CalendarResource;
use App\Http\Resources\Utility\ResponseType;
use App\Models\Event;
use App\Models\EventConfirmed;
use App\Models\Schedule;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DateTime;
use Illuminate\Http\Request;

class CalendarController extends Controller
{

    // function will all date with time spot  if time is not available will be status  unavailable

    public function eventCalendar(Request $request)
    {
        if (Carbon::parse($request->end_range)->format('Y-m-d') < Carbon::now()->format('Y-m-d')) {
            return (new CalendarResource([]))->additional(ResponseType::simpleResponse('No avaliable time', false));
        }

        $event = Event::where('slug', $request->slug)->first(); // to get event 

        if ($event) {
            $scheduleDays = Schedule::find($event->schedule_id)->days()->get(); // to get  Schedule day 

            $dates = [];
            foreach ($scheduleDays as $scheduleDay) {
                //dates Range
                $dateRange = CarbonPeriod::create(Carbon::parse($request->start_range)->format('Y-m-d'), Carbon::parse($request->end_range)->format('Y-m-d'));

                foreach ($dateRange as $date) {
                    if (Carbon::parse($date)->is($scheduleDay->name)) {
                        $startTime = new DateTime($date->format('Y-m-d') . $scheduleDay->pivot->time_from);
                        $endTime = new DateTime($date->format('Y-m-d') . ' ' . $scheduleDay->pivot->time_to);
                        $spot = [];
                        $eventConfirmed = EventConfirmed::where('date', $date->format('Y-m-d'))->where('time_from', $startTime->format('H:i'))->where('event_id', $event->id)->first();
                        if ($eventConfirmed) {
                            $data = ['time' => $startTime->format('H:i'), 'status' => 'unavailable'];
                        } else {
                            $data = ['time' => $startTime->format('H:i'), 'status' => 'available'];
                        }
                        array_push($spot, $data);
                        while ($startTime < $endTime) {
                            $time = $startTime->modify('+' . $event->duration + $event->time_between . 'minutes')->format('H:i');
                            $eventConfirmed = EventConfirmed::where('date', $date->format('Y-m-d'))->where('time_from',  $time)->where('event_id', $event->id)->first();
                            if ($eventConfirmed) {
                                $data = ['time' =>  $time, 'status' => 'unavailable'];
                            } else {
                                $data = ['time' =>  $time, 'status' => 'available'];
                            }
                            array_push($spot, $data);
                        }
                        $arr = ['date' => $date->format('Y-m-d'), 'spot' => $spot];
                        array_push($dates, $arr);
                    }
                }
            }
            return CalendarResource::collection($dates)
                ->additional(ResponseType::simpleResponse('Time Result ', true));
        } else {
            return (new CalendarResource([]))->additional(ResponseType::simpleResponse('Event Not found', false));
        }
    }
}
