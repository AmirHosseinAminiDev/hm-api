<?php

namespace App\Http\Controllers;

use App\Enum\AnswerStatusTypeEnum;
use App\Http\Requests\CreateAnswerRequest;
use App\Http\Resources\AnswerResource;
use App\Models\Answer;
use App\Models\User;
use App\Services\AnswerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use SebastianBergmann\Diff\Exception;

class AnswerController extends Controller
{
    public AnswerService $answerService;

    public function __construct()
    {
        $this->answerService = new AnswerService();
    }

    /**
     * @param CreateAnswerRequest $request
     * @return AnswerResource
     */
    public function createAnswer(CreateAnswerRequest $request): AnswerResource
    {
        $answer = $this->answerService->create($request->validated());
        return AnswerResource::make($answer);
    }

    /**
     * @param CreateAnswerRequest $request
     * @return AnswerResource
     */
    public function updateAnswer(CreateAnswerRequest $request, $id): AnswerResource|JsonResponse
    {
        $answer = $this->answerService->update($id, $request->validated());
        return AnswerResource::make($answer);
    }


    /**
     * @param $id
     * @return JsonResponse
     */
    public
    function deleteAnswer($id): JsonResponse
    {
        $answer = Answer::findOrFail($id);
        $this->answerService->delete($answer->id);
        return response()->json([
            'message' => 'پاسخ با موفقیت حذف شد',
            'status' => 200
        ]);
    }

    public function getSpecificAnswer($id)
    {
        $answer = Answer::findOrFail($id);
        return AnswerResource::make($answer);
    }

    public function updateAnswerStatus($id)
    {
        $answer = Answer::findOrFail($id);

        $answer->update([
            'is_accepted' => $answer->is_accepted = 1 ? 0 : 1
        ]);

        if ($answer->status == 1) {
            $author = $answer->user;
            $author->update([
                'score' => $author->score + config('points.publish_answer')
            ]);
        }
        return response()->json([
            'message' => 'پاسخ با موفقیت بروز شد'
        ], 200);
    }


    public function isCorrectAnswerStatus(Request $request, $id)
    {
        $answer = Answer::findOrFail($id);
        $answer->update([
            'is_correct_answer' => 1
        ]);
        // The User Which Is Choosing Correct Answer
        $checkerUser = User::findOrFail($request->get('user_id'));
        $checkerUser->update([
            'score' => $checkerUser->score + config('points.correct_answer')
        ]);

        // The User Which Is Written The Answer
        $author = $answer->user;
        $author->update([
            'score' => $author->score + config('points.written_correct_answer_user')
        ]);

        $author->questionAnswerRecords()->create([
            'question_id' => $author->question_id,
            'user_id' => $author->id,
            'answer_type' => $answer->is_correct_answer == 1 ? AnswerStatusTypeEnum::CORRECT_ANSWER->value : AnswerStatusTypeEnum::INCORRECT_ANSWER->value
        ]);

        return response()->json([
            'message' => 'پاسخ با موفقیت بروز شد'
        ], 200);
    }


    public function makeAnswerUncorrect(Request $request, $id)
    {
        $answer = Answer::findOrFail($id);
        $answer->update([
            'is_correct_answer' => 0
        ]);


        // The User Which Is Choosing UnCorrect Answer
        $checkerUser = User::findOrFail($request->get('user_id'));
        $checkerUser->update([
            'score' => $checkerUser->score + config('points.uncorrected_answer')
        ]);

        // The User Which Is Written The Answer
        $author = $answer->user;
        $author->update([
            'score' => $author->score - config('points.written_incorrect_answer_user')
        ]);

        $author->questionAnswerRecords()->create([
            'question_id' => $author->question_id,
            'user_id' => $author->id,
            'answer_type' => $answer->is_correct_answer == 1 ? AnswerStatusTypeEnum::CORRECT_ANSWER->value : AnswerStatusTypeEnum::INCORRECT_ANSWER->value
        ]);

        return response()->json([
            'message' => 'پاسخ با موفقیت بروز شد'
        ], 200);
    }

}
