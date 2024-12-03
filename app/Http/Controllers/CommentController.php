<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Services\CommentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public CommentService $commentService;

    public function __construct()
    {
        $this->commentService = new CommentService();
    }

    /**
     * @param $id
     * @return CommentResource|JsonResponse
     */
    public function getSpecificComment($id): CommentResource|JsonResponse
    {
        $comment = $this->commentService->findById($id);
        if ($comment) {
            return CommentResource::make($comment);
        }
        return response()->json([
            'message' => 'نظر یافت نشد',
            'status' => 404
        ]);

    }

    /**
     * @param CreateCommentRequest $request
     * @return CommentResource
     */
    public function createComment(CreateCommentRequest $request): CommentResource|JsonResponse
    {
        $comment = $this->commentService->create(
            $request->getUserId(),
            $request->getCommentableId(),
            $request->getCommentableType(),
            $request->getCommentContent());
        return CommentResource::make($comment)->response()->setStatusCode(200);
    }

    /**
     * @param UpdateCommentRequest $request
     * @param $id
     * @return CommentResource|JsonResponse
     */
    public function updateComment(UpdateCommentRequest $request, $id): CommentResource|JsonResponse
    {
        try {
            $comment = $this->commentService->update(
                $id,
                $request->getCommentContent(),
                $request->getCommentStatus()
            );

            return CommentResource::make($comment)->response()->setStatusCode(200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * @param $commentId
     * @return JsonResponse
     */
    public function deleteComment($commentId): JsonResponse
    {
        $comment = $this->getSpecificComment($commentId);
        if ($comment) {
            $this->commentService->delete($comment);
            return response()->json([
                'message' => 'نظر با موفقیت حذف شد',
                'status' => 200
            ]);
        }
        return response()->json([
            'message' => 'نظر یافت نشد',
            'status' => 404
        ]);
    }

    public function updateCommentStatus($id): JsonResponse
    {
        $comment = $this->commentService->findById($id);
        if ($comment) {
            $this->commentService->updateStatus($comment);
            return response()->json([
                'message' => 'نظر با موفقیت بروز شد',
                'status' => 200
            ]);
        }
        return response()->json([
            'message' => 'نظر یافت نشد',
            'status' => 404
        ]);
    }
}
