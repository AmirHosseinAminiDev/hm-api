<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAnswerRequest;
use App\Http\Resources\AnswerResource;
use App\Models\Answer;
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
        $answer = Answer::where('id', $id)->first();
        if ($answer) {
            $this->answerService->delete($id);
            return response()->json([
                'message' => 'پاسخ با موفقیت حذف شد',
                'status' => 200
            ]);
        }
        return response()->json([
            'message' => 'پاسخ یافت نشد',
            'status' => 404
        ]);
    }

    public function getSpecificAnswer($id)
    {
        $answer = Answer::where('id', $id)->first();
        if ($answer) {
            return AnswerResource::make($answer);
        }
        return response()->json([
            'message' => 'پاسخ یافت نشد',
            'status' => 404
        ]);
    }

    public function updateAnswerStatus($id)
    {
        $answer = Answer::find($id);

        if (!$answer) {
            return response()->json([
                'status' => 404,
                'message' => 'پاسخ یافت نشد'
            ]);
        }
        if ($answer->is_correct_answer == 1) {
            $answer->update(['is_correct_answer' => 0]);
        } else {
            Answer::where('question_id', $answer->question_id)
                ->where('is_correct_answer', 1)
                ->update(['is_correct_answer' => 0]);
            $answer->update(['is_correct_answer' => 1]);
        }
        return AnswerResource::make($answer);
    }

}
