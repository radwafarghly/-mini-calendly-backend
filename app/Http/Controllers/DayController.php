<?php

namespace App\Http\Controllers;

use App\Http\Resources\DayResource;
use App\Http\Resources\Utility\ResponseType;
use App\Models\Day;
use Illuminate\Http\Request;

class DayController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $result = Day::get();
        if ($result->isEmpty()) {
            return (new DayResource([]))->additional(ResponseType::simpleResponse('No Days found', false));
        }
        return DayResource::collection($result)
            ->additional(ResponseType::simpleResponse('Days result', true));
    }
}
