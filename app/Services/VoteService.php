<?php

namespace App\Services;

use App\Models\Answer;
use App\Models\Comment;
use App\Models\Question;
use App\Models\Vote;

class VoteService
{
    public function create($voteModel, $voteId, $voteType, $userId)
    {
        $voteableType = $this->getVoteableModel($voteModel);
        $existingVote = Vote::firstOrNew([
            'user_id' => $userId,
            'voteable_id' => $voteId,
            'voteable_type' => $voteableType,
        ]);
        $existingVote->vote_type = $existingVote->exists ? ($existingVote->vote_type == 1 ? 0 : 1) : $voteType;
        $existingVote->save();
        if ($voteableType == Question::class) {
            $question = Question::where('id', $voteId)
                ->with(['activity', 'category'])->first();
            $question->activity()->update([
                'last_activity' => now()
            ]);
            $question->category->activity()->update([
                'last_activity' => now()
            ]);
        }

        if ($voteableType == Question::class || $voteableType == Answer::class) {
            $author = $question->user;
            if ($existingVote->vote_type == 1) {
                $author->update([
                    'score' => $author->score + config('points.question_positive_vote'),
                ]);
            } else {
                $author->update([
                    'score' => $author->score - config('points.question_negative_vote'),
                ]);
            }
        }

        return $existingVote;
    }

    protected function getVoteableModel($voteModel)
    {
        return match ($voteModel) {
            'question' => Question::class,
            'answer' => Answer::class,
            'comment' => Comment::class,
            default => null,
        };
    }

}
