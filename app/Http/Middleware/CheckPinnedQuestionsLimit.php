<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Models\UserPinnedQuestion;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPinnedQuestionsLimit
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = User::findOrFail($request->get('user_id'));
        $restrictedLevels = ['L0', 'L1', 'L2', 'L3', 'L4'];

        if (in_array($user->level->slug, $restrictedLevels)) {
            return $this->denyAccess('Users with your level are not allowed to pin questions.');
        }

        if (UserPinnedQuestion::where('user_id', $user->id)->count() >= 2) {
            return $this->denyAccess('You cannot pin more than 2 questions.');
        }

        return $next($request);
    }

    private function denyAccess(string $message)
    {
        return response()->json(['message' => $message], 403);
    }
}
