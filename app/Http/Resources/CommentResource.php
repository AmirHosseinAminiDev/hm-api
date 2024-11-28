<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'content' => $this->content,
            'created_at' => $this->created_at,
            'user' => [
                'name' => $this->user->name ?? 'admin',
                'score' => $this->user->score ?? 0,
                'citizen_code' => $this->user->citizen_code ?? 'hm-unknown',
            ],
            'likes' => $this->likesCount(),
            'dislikes' => $this->dislikesCount(),
            'replies' => CommentResource::collection($this->replies),
        ];
    }
}
