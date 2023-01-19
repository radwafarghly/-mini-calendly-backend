<?php

namespace App\Http\Resources;

use App\Http\Resources\Abstracts\AbstractJsonResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends AbstractJsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function modelResponse(): array
    {

        return [
            "id" => $this->id,
            "name" => $this->name,
            "slug" => $this->slug,
            "description" => $this->description,
            "duration" => $this->duration,
            "time_between" => $this->time_between,
            "schedule" => new ScheduleResource($this->schedule),
            "user" => new UserResource($this->user),






        ];
    }
}
