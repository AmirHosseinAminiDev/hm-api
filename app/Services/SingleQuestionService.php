<?php

namespace App\Services;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Support\Facades\Cache;

class SingleQuestionService
{
    public function getSpecificQuestion($slug)
    {
        Cache::forget("single-question-{$slug}");
        return Cache::remember("single-question-{$slug}", 60, function () use ($slug) {
            $question = Question::where('slug', $slug)->first();
            $question->increment('views');
            return $question;
        });
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
            'status' => $data['status'],
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

}
