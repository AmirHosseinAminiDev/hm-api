<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Services\SingleQuestionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SingleQuestion extends Controller
{
    public $questionService;

    public function __construct()
    {
        $this->questionService = new SingleQuestionService();
    }

    /**
     * @param $slug
     * @return \App\Http\Resources\SingleQuestion
     */
    public function getSingleQuestion($slug): \App\Http\Resources\SingleQuestion
    {
        $question = $this->questionService->getSpecificQuestion($slug);
        return \App\Http\Resources\SingleQuestion::make($question);
    }

    /**
     * @param $slug
     * @return JsonResponse
     */
    public function deleteSingleQuestion($slug): JsonResponse
    {
        $question = $this->getSingleQuestion($slug);

        if ($question) {
            $this->questionService->deleteSpecificQuestion($question);
            return response()->json([
                'message' => 'سوال با موفقیت حذف شد.',
                'status' => 200
            ]);
        }

        return response()->json([
            'message' => 'سوال یافت نشد.',
            'status' => 404
        ]);
    }

    public function updateSingleQuestion(UpdateQuestionRequest $request, $slug): \App\Http\Resources\SingleQuestion|JsonResponse
    {

        $question = $this->questionService->getSpecificQuestion($slug);

        if ($question) {
            $updatedQuestion = $this->questionService->updateQuestion($question, $request->validated());

            return \App\Http\Resources\SingleQuestion::make($updatedQuestion);
        }
        return response()->json([
            'message' => 'سوال یافت نشد',
            'status' => 404
        ]);
    }


    /**
     * @param StoreQuestionRequest $request
     * @return \App\Http\Resources\SingleQuestion
     */
    public function createQuestion(StoreQuestionRequest $request): \App\Http\Resources\SingleQuestion
    {
        $question = $this->questionService->createNewQuestion($request->validated());

        return \App\Http\Resources\SingleQuestion::make($question);
    }

    /**
     * @param $slug
     * @return JsonResponse|\App\Http\Resources\SingleQuestion
     */
    public function pinSingleQuestion($slug): JsonResponse|\App\Http\Resources\SingleQuestion
    {
        $question = $this->questionService->getSpecificQuestion($slug);
        if ($question) {
            $question->update(['is_pinned' => 1]);
            return \App\Http\Resources\SingleQuestion::make($question);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'سوال موردنظر یافت نشد'
            ]);
        }
    }

}
