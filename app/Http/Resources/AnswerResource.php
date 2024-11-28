<?php

namespace App\Http\Resources;

use App\Models\Answer;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class AnswerResource extends JsonResource
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
            'question_id' => $this->question_id,
            'created_at' => $this->created_at,
            'is_correct_answer' => $this->is_correct_answer,
            'author' => $this->user->name ?? 'user',
            'user' => [
                'name' => $this->user->name ?? 'admin',
                'score' => $this->user->score ?? 0,
                'citizen_code' => $this->user->citizen_code ?? 'hm-unknown',
            ],
            'likes' => $this->likesCount(),
            'dislikes' => $this->dislikesCount(),
            'comments' => CommentResource::collection($this->comments),
        ];
    }

}
