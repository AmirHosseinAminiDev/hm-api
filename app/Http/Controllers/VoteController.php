<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateVoteRequest;
use App\Services\VoteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public VoteService $voteService;
    public function __construct()
    {
        $this->voteService = new VoteService();
    }

    /**
     * @param CreateVoteRequest $request
     * @return JsonResponse
     */
    public function createVote(CreateVoteRequest $request): \Illuminate\Http\JsonResponse
    {
        $vote = $this->voteService->create(
            $request->getVoteModel(),
            $request->getVoteId(),
            $request->getVoteType(),
            $request->getUserId(),
        );
        return response()->json([
            'vote' => $vote,
            'message' => 'رای شما با موفقیت ثبت شد',
            'status' => 201
        ]);
    }
}
