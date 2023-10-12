<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'user_picture' => $this->user_picture,
            'user_role' => $this->user_role,
            'calisma_durumu' => $this->calisma_durumu,
            'telefon_no' => $this->telefon_no,
            'user_prova_state_types' => CutStatusResource::collection($this->userCutStatus)
        ];
    }
}
