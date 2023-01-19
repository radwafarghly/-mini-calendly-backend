<?php

namespace App\Http\Resources;

use App\Http\Resources\Abstracts\AbstractJsonResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends AbstractJsonResource
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
            "days" => ScheduleDayResource::collection($this->days)


        ];
    }
}
