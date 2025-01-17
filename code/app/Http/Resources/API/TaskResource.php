<?php

namespace App\Http\Resources\API;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'parent_id' => $this->parent_id,
            'status' => $this->status,
            'title' => $this->title,
            'description' => $this->description,
            'due_date' => $this->due_date,
            'created_at' => Carbon::create($this->created_at)->toDateTimeString(),
            'children' => TaskResource::collection($this->whenLoaded('children')),
        ];
    }
}
