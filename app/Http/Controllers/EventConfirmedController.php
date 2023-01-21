<?php

namespace App\Http\Controllers;

use App\Http\Resources\CalendarResource;
use App\Http\Resources\Utility\ResponseType;
use App\Mail\EventConfirmedMail;
use App\Models\Day;
use App\Models\Event;
use App\Models\EventConfirmed;
use App\Traits\MeetingZoomTrait;
use App\Traits\ZoomMeetingTrait;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EventConfirmedController extends Controller
{

    use  ZoomMeetingTrait;

    public function EventConfirmed(Request $request)
    {
        $event = Event::where('slug', $request->slug)->first();
        if ($event) {
            $meeting = $this->create($event, $request);
            if ($meeting) {
                $eventConfirmed = EventConfirmed::create([
                    'event_id' => $event->id,
                    'time_from' => $request->time_from,
                    'time_to' => Carbon::parse($request->time_from)->modify('+' . $event->duration . 'minutes'),
                    'date' => Carbon::parse($request->date)->format('Y-m-d'),
                    'day_id' => Day::where('name', Carbon::parse($request->date)->format('l'))->first()->id,
                    'email' => $request->email,
                    'name' => $request->name,
                    'notes' => $request->notes,
                    "meeting_link" => $meeting['data']['join_url'],
                    "meeting_id"   => $meeting['data']['id'],
                    "meeting_password" => $meeting['data']['password']
                ]);

                Mail::to($request->email)->send(new EventConfirmedMail($eventConfirmed));

                return (new CalendarResource([]))->additional(ResponseType::simpleResponse('Event Confirmed successfully', true));
            }
        }
    }
}
