<?php

namespace App\Http\Resources;

use App\Services\SingleQuestionService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SingleQuestion extends JsonResource
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
            'is_pined' => $this->is_pinned == 1 ? 1 : 0,
            'is_solved' => $this->answers->where('is_correct_answer', 1)->count() > 0 ? 1 : 0,
            'user' => [
                'name' => $this->user->name ?? 'admin',
                'score' => $this->user->score ?? 0,
                'citizen_code' => $this->user->citizen_code ?? 'hm-unknown',
            ],
            'category_name' => $this->category->name ?? 'unknown',
            'created_at' => $this->created_at ?? 'unknown',
            'updated_at' => $this->updated ?? 'unknown',
            'views' => $this->views ?? 0,
            'content' => $this->content,
            'answers_count' => $this->answers->count(),
            'likes' => $this->likesCount(),
            'dislikes' => $this->dislikesCount(),
            'comments' => CommentResource::collection($this->comments),
            'answers' => AnswerResource::collection($this->answers),
        ];
    }
}
