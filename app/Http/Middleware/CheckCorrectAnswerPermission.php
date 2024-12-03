<?php

namespace App\Http\Middleware;

use App\Models\Answer;
use App\Models\User;
use App\Models\UserCorrectAnswerRecord;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCorrectAnswerPermission
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = User::findOrFail($request->get('user_id'));
        $restrictedLevels = ['L0', 'L1', 'L2', 'L3'];

        $answer = Answer::findOrFail($request->route('id'));
        $questionId = $answer->question_id;

        // Check if the user has already marked this question's answer as correct
        $alreadyMarkedCorrect = UserCorrectAnswerRecord::where('user_id', $user->id)
            ->where('question_id', $questionId)
            ->where('answer_type', 'correct')
            ->exists();

        // Check if the user is restricted due to previously marked answers being unmarked
        $markedAndUnmarked = UserCorrectAnswerRecord::where('user_id', $user->id)
            ->where('question_id', $questionId)
            ->where('answer_type', 'incorrect')
            ->exists();

        if ($markedAndUnmarked) {
            return $this->denyAccess('You cannot change the status of answers for this question anymore.');
        }

        if ($alreadyMarkedCorrect) {
            return $this->denyAccess('You can only mark one answer as correct for this question.');
        }

        if ($answer->user_id == $user->id) {
            return $this->denyAccess('You cannot mark your own answer as correct.');
        }

        $userLevelSlug = $user->level->slug;
        $answerUserLevelSlug = $answer->user->level->slug;

        if (in_array($userLevelSlug, $restrictedLevels)) {
            return $this->denyAccess('Users with your level are not allowed to mark answers as correct.');
        }

        $userLevel = $this->getLevelValue($userLevelSlug);
        $answerUserLevel = $this->getLevelValue($answerUserLevelSlug);

        if ($userLevel >= $answerUserLevel) {
            return $this->denyAccess('You can only mark answers of users with a lower level as correct.');
        }

        return $next($request);
    }

    private function denyAccess(string $message)
    {
        return response()->json(['message' => $message], 403);
    }

    private function getLevelValue(string $slug)
    {
        $levels = ['L0' => 0, 'L1' => 1, 'L2' => 2, 'L3' => 3, 'L4' => 4, 'L5' => 5, 'L6' => 6, 'L7' => 7, 'L8' => 8, 'L9' => 9, 'L10' => 10, 'L11' => 11, 'L12' => 12, 'L13' => 13];
        return $levels[$slug] ?? 0;
    }
}
