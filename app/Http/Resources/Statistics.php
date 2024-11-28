<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Statistics extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'allAskedQuestions' => $this->getValueByKey('asked_questions'),
            'allSolvedQuestions' => $this->getValueByKey('solved_questions'),
            'answeredQuestions' => $this->getValueByKey('answered_questions'),
            'usersCount' => $this->getValueByKey('users_count'),
        ];
    }
}
