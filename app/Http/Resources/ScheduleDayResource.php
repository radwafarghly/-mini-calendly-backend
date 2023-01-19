<?php

namespace App\Http\Resources;

use App\Http\Resources\Abstracts\AbstractJsonResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 *
 */
class ScheduleDayResource extends AbstractJsonResource
{
    /**
     *
     */
    protected function modelResponse(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'time_from' => Carbon::parse($this->pivot->time_from)->format('H:i'),
            'time_to' => Carbon::parse($this->pivot->time_to)->format('H:i'),

        ];
    }
}
