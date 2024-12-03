<?php

namespace App\Services;

use App\Enum\LevelEnum;
use App\Models\Answer;
use App\Models\Comment;
use App\Models\Question;
use App\Models\User;
use function Symfony\Component\Translation\t;

class CommentService
{
    public function create($userId, $commentableId, $commentableType, $content)
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

        $status = $this->selectAnswerStatus($userId);

        $comment = Comment::create([
            'user_id' => $userId,
            'commentable_id' => $commentableId,
            'commentable_type' => $commentableType,
            'content' => $content,
            'status' => $status,
            'old_question_id' => 0,
        ]);
        if ($commentableType == Question::class) {
            $author = $comment->user;
            $question = Question::where('id', $commentableId)
                ->with(['activity', 'category'])->first();
            $question->activity()->update([
                'last_activity' => now()
            ]);

            $question->category->activity()->update([
                'last_activity' => now()
            ]);

            $author->update([
                'score' => $author->score + config('points.comment_question'),
            ]);
        }

        return $comment;
    }

    public function findById($commentId)
    {
        return Comment::findOrFail($commentId);
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

        if ($comment->commentable_type == Question::class) {
            $question = Question::where('id', $comment->commentable_id)
                ->with(['activity', 'category'])->first();
            $question->activity()->update([
                'last_activity' => now()
            ]);
            $question->category->activity()->update([
                'last_activity' => now()
            ]);
        }
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


    public function updateStatus($comment)
    {
        $comment->update([
            'status' => $comment->status == 1 ? 0 : 1,
        ]);
        $author = $comment->user;
        $author->update([
            'score' => $author->score + config('points.publish_comment'),
        ]);
        return true;
    }

    private function selectAnswerStatus($user_id): int
    {
        $user = User::where('id', $user_id)->first();
        if ($user->level->slug == "L" . LevelEnum::LEVEL_ZERO->value || $user->level->slug == "L" . LevelEnum::LEVEL_ONE->value) {
            return 0;
        } else {
            return 1;
        }

    }
}
