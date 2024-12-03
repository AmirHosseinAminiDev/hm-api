<?php

namespace App\Http\Middleware;

use App\Models\Answer;
use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAnswerStatusAccess
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = User::findOrFail($request->get('user_id'));
        $answer = Answer::findOrFail($request->route('id'));
        $userLevel = $user->level;

        if (in_array($userLevel->slug, ['L0', 'L1', 'L2'])) {
            return response()->json(['message' => 'You do not have permission to update the status of this answer.'], 403);
        }

        if ($userLevel->slug <= $answer->user->level->slug) {
            return response()->json(['message' => 'You cannot update the status of an answer from a user with an equal or higher level.'], 403);
        }

        return $next($request);
    }
}
