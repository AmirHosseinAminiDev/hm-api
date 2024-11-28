<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Question;
use App\Models\Statistic;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class HomePageService
{
    /**
     * @return Collection
     */
    public function getPinnedQuestions($category = null): Collection
    {

        if($category === null){
            return Question::where('is_pinned', 1)
            ->with('activity')
            ->leftJoin('questions_activity', 'questions.id', '=', 'questions_activity.question_id')
            ->orderBy('questions_activity.last_activity', 'desc')
            ->select('questions.*')
            ->get();
        }else{

           $questions = Question::where('is_pinned', 1)
            ->where('category_id' , $category)
            ->with('activity')
            ->leftJoin('questions_activity', 'questions.id', '=', 'questions_activity.question_id')
            ->orderBy('questions_activity.last_activity', 'desc')
            ->select('questions.*')
            ->get();

            return $questions;
        }

    }
    /**
     * @return mixed
     */
    public function getLatestQuestions($category = null): mixed
    {
        if($category === null){
            return Question::where('is_pinned', 0)
            ->with('activity')
            ->leftJoin('questions_activity', 'questions.id', '=', 'questions_activity.question_id')
            ->orderBy('questions_activity.last_activity', 'desc')
            ->select('questions.*')
            ->take(5)
            ->get();
        }else{
            $questions =  Question::where('is_pinned', 0)
            ->where('category_id' , $category)
            ->with('activity')
            ->leftJoin('questions_activity', 'questions.id', '=', 'questions_activity.question_id')
            ->orderBy('questions_activity.last_activity', 'desc')
            ->select('questions.*')
            ->take(5)
            ->get();
              return $questions;
        }

    }

    /**
     * @return mixed
     */

    public function getLatestCategories(): mixed
    {

            return Category::join('categories_activity', 'categories.id', '=', 'categories_activity.category_id')
            ->orderByDesc('categories_activity.last_activity')
            ->select('categories.*')
            ->where('status', 'active')
            ->limit(12)
            ->get();


    }

    /**
     * @return mixed
     */
    public function getMostLikedQuestions(): mixed
    {
        return Cache::remember('most_liked_questions', 600, function () {
            return Question::select('questions.id', 'questions.title', 'questions.slug', 'questions.content', 'questions.created_at')
                ->join('questions_activity', 'questions.id', '=', 'questions_activity.question_id')
                ->leftJoin('votes', function ($join) {
                    $join->on('questions.id', '=', 'votes.voteable_id')
                        ->where('votes.voteable_type', '=', Question::class)
                        ->where('votes.vote_type', '=', 1);
                })
                ->groupBy('questions.id', 'questions.title', 'questions.slug', 'questions.content', 'questions.created_at', 'questions_activity.last_activity')
                ->orderByRaw('COUNT(votes.id) DESC')
                ->orderByDesc('questions_activity.last_activity')
                ->take(12)
                ->get();
        });
    }

    /**
     * @return mixed
     */
    public function getMostViewedQuestions(): mixed
    {
        return Cache::remember('most_viewed_questions', 600, function () {
            return Question::select('questions.id', 'questions.category_id', 'questions.views', 'questions.user_id', 'questions.title', 'questions.slug', 'questions.content', 'questions.created_at', 'users.name as user_name', 'categories.name as category_name')
                ->join('users', 'questions.user_id', '=', 'users.id')
                ->join('categories', 'questions.category_id', '=', 'categories.id')
                ->orderBy('views', 'desc')
                ->take(12)
                ->get();
        });
    }

    /**
     * @return mixed
     */
    public function getActiveUsers(): mixed
    {
        return Cache::remember('active_users', 600, function () {
            return User::select('users.name', 'users.id', 'users.last_name', 'users.score')
                ->orderBy('score', 'desc')
                ->take(5)
                ->get();
        });
    }

    public function getStatistics()
    {
        return Cache::remember('statistics', 600, function () {
           return Statistic::all();
        });
    }


}
