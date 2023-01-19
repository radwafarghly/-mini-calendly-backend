<?php

namespace App\Http\Resources;

use App\Http\Resources\Abstracts\AbstractJsonResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

/**
 *
 */
class TimeResource extends AbstractJsonResource
{
    /**
     *
     */
    protected function modelResponse(): array
    {
        return [
            'id' => $this->id,
            'time_from' =>  Carbon::parse($this->time_from)->format('H:i'),
            'time_to' => Carbon::parse($this->time_to)->format('H:i'),
            // 'user_id' => $this->pivot->user_id,
            // 'day_id' => $this->pivot->day_id


        ];
    }
}
