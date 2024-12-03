<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LatestQuestionsResource extends JsonResource
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
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'views' => $this->views ?? 0,
            'created_at' => $this->created_at,
            'category_name' => $this->category->name ?? '',
            'answers_count' => $this->answers->count() ?? 0,
            'last_activity' => $this->activity->last_activity,
            'author' => $this->user->name ?? 'admin',
            'votes_count' => $this->votes->where('vote_type', 1)->count(),
            'status' => $this->status,
        ];
    }
}
