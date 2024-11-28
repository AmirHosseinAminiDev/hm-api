<?php

namespace App\Http\Controllers;

use App\Http\Resources\ActiveUsers;
use App\Http\Resources\LatestCategories;
use App\Http\Resources\LatestQuestionsResource;
use App\Http\Resources\MostVieweQuestions;
use App\Http\Resources\PinnedQuestions;
use App\Http\Resources\Statistics;
use App\Services\HomePageService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class HomePageController extends Controller
{
    public $homePageService;

    public function __construct()
    {
        $this->homePageService = new HomePageService();
    }

    /**
     * @return array{pinnedQuestions: AnonymousResourceCollection}
     */
    public function index(): array
    {
        $latestCategories = $this->homePageService->getLatestCategories();
        $pinnedQuestions = $this->homePageService->getPinnedQuestions();
        $latestQuestions = $this->homePageService->getLatestQuestions();
        return [
            'latestCategories' => LatestCategories::collection($latestCategories),
            'pinnedQuestions' => PinnedQuestions::collection($pinnedQuestions),
            'latestQuestions' => LatestQuestionsResource::collection($latestQuestions)
        ];
    }

    public function mostLikedQuestions()
    {
        $mostLikedQuestions = $this->homePageService->getMostLikedQuestions();
        return LatestQuestionsResource::collection($mostLikedQuestions);
    }


    public function getMostViewedQuestions()
    {
        $mostViewedQuestions = $this->homePageService->getMostViewedQuestions();
        return MostVieweQuestions::collection($mostViewedQuestions);
    }

    public function getActiveUsers()
    {
        $activeUsers = $this->homePageService->getActiveUsers();
        return ActiveUsers::collection($activeUsers);
    }

    public function getStatistics()
    {
        $statistics = $this->homePageService->getStatistics();
        return Statistics::make($statistics->first());
    }
}
