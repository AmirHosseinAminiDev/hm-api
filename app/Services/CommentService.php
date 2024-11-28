<?php

namespace App\Services;

use App\Models\Answer;
use App\Models\Comment;
use App\Models\Question;
use function Symfony\Component\Translation\t;

class CommentService
{
    public function create($userId, $commentableId, $commentableType, $content, $status = 1)
    {
        switch ($commentableType) {
            case 'comment':
                $commentableType = Comment::class;
                break;
            case 'answer':
                $commentableType = Answer::class;
                break;
            case 'question':
                $commentableType = Question::class;
                break;
        }
        $comment = Comment::create([
            'user_id' => $userId,
            'commentable_id' => $commentableId,
            'commentable_type' => $commentableType,
            'content' => $content,
            'status' => $status,
            'old_question_id' => 0,
        ]);

        return $comment;
    }

    public function findById($commentId)
    {
        $comment = Comment::where('id', $commentId)->first();
        return $comment;
    }

    public function update($commentId, $content, $status)
    {
        $comment = $this->findById($commentId);

        if (!$comment) {
            throw new \Exception('نظری یافت نشد');
        }

        $comment->update([
            'content' => $content,
            'status' => $status,
            'updated_at' => now(),
        ]);

        return $comment;
    }

    /**
     * @param $comment
     * @return true
     */
    public function delete($comment): true
    {
        $comment->delete();
        return true;
    }
}
