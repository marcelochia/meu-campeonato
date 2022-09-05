<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FinishedChampionshipsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'championship' => $this->championship,
            'firstPlace' => $this->firstPlace,
            'secondPlace' => $this->secondPlace,
            'thirstPlace' => $this->thirdPlace
        ];
    }
}
