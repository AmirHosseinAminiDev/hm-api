<?php

namespace App\Services;

use App\Enum\LevelEnum;
use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class SingleQuestionService
{
    public function getSpecificQuestion($slug)
    {
        return Cache::remember("single-question-{$slug}", 60, function () use ($slug) {
            $question = Question::where('slug', $slug)->first();
            if ($question) {
                $question->increment('views');
            }
            return $question;
        });
    }


    public function getSpecificQuestionById($id)
    {
        return Question::findOrFail($id);
    }

    /**
     * @param $question
     * @return true
     */
    public function deleteSpecificQuestion($question): true
    {
        $question->answers()->each(function ($answer) {
            $answer->comments()->delete();
            $answer->votes()->delete();
            $answer->delete();
        });

        $question->tags()->detach();
        $question->comments()->each(function ($comment) {
            $comment->votes()->delete();
            $comment->delete();
        });
        $question->votes()->delete();

        Cache::forget("single-question-{$question->slug}");
        $question->delete();

        return true;
    }


    /**
     * @param Question $question
     * @param array $data
     * @return Question
     */
    public function updateQuestion(Question $question, array $data): Question
    {
        $question->title = $data['title'];
        $question->category_id = $data['category_id'];
        $question->content = $data['content'];
        $question->user_id = $data['user_id'];
        $question->status = $data['status'];
        $question->is_pinned = $data['is_pinned'];
        $question->save();

        if (isset($data['tags'])) {
            $question->tags()->sync($data['tags']);
        }

        Cache::forget("single-question-{$question->slug}");

        return $question;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function createNewQuestion(array $data): mixed
    {
        $question = Question::create([
            'title' => $data['title'],
            'slug' => str_replace(' ', '-', $data['title']),
            'category_id' => $data['category_id'],
            'content' => $data['content'],
            'user_id' => $data['user_id'],
            'is_pinned' => $data['is_pinned'],
            'status' => $this->getQuestionStatus($data['user_id']),
            'old_id' => 0,
        ]);
        $question->activity()->create([
            'last_activity' => now(),
        ]);
        $question->category->activity()->create([
            'last_activity' => now(),
        ]);
        if (!empty($data['tags'])) {
            $question->tags()->attach($data['tags']);
        }

        return $question;
    }

    public function updateQuestionStatus(Question $question)
    {
        $question->update([
            'status' => $question->status == 1 ? 0 : 1,
        ]);

        $question->activity()->update([
            'last_activity' => now(),
        ]);

        $question->category->activity()->update([
            'last_activity' => now(),
        ]);
        if ($question->status == 1) {
            $author = $question->user;
            $author->update([
                'score' => $author->score + config('points.publish_question'),
            ]);
        }
        return $question;
    }

    protected function getQuestionStatus($user_id)
    {
        $user = User::find($user_id);
        $levelSlug = $user->level->slug;
        if ($levelSlug == LevelEnum::LEVEL_ZERO->value || $levelSlug == LevelEnum::LEVEL_ONE->value) {
            return 0;
        } else {
            return 1;
        }
    }

}
