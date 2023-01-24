<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventFormRequest;
use App\Http\Resources\EventResource;
use App\Http\Resources\Utility\ResponseType;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $result = Event::where('user_id', Auth::user()->id)->get();
        if ($result->isEmpty()) {
            return (new EventResource([]))->additional(ResponseType::simpleResponse('No Events found', false));
        }
        return EventResource::collection($result)
            ->additional(ResponseType::simpleResponse('Events result', true));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  CategoryFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventFormRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = str_replace(' ', '_', $data['slug']) . Event::latest()->first()->id + 1;
        // $data['slug'] = str_replace(' ', '_', $data['slug']);
        return (new EventResource(Event::create($data)))->additional(ResponseType::simpleResponse('Event created successfully', true));
    }

    /**
     * Display the specified resource.
     *
     * @param  Event  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Event $Event)
    {
        return (new EventResource($Event))->additional(ResponseType::simpleResponse('Event item', true));
    }

    /**
     *
     * * update the specified resource.
     */
    public function update(EventFormRequest $request, Event $Event)
    {
        $data = $request->validated();
        Event::where('id', $Event->id)->update($data);
        return (new EventResource(Event::find($Event->id)))->additional(ResponseType::simpleResponse('Event update successfully', true));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Event  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {

        Event::destroy($event->id);
        return (new EventResource([]))->additional(ResponseType::simpleResponse('Event Deleted successfully', true));
    }
}
