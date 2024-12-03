<?php

namespace App\Http\Middleware;

use App\Models\Comment;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCommentStatusAccess
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = User::findOrFail($request->get('user_id'));
        $comment = Comment::findOrFail($request->route('id'));
        $userLevel = $user->level;

        if (in_array($userLevel->slug, ['L0', 'L1', 'L2'])) {
            return response()->json(['message' => 'You Dont Have Permission For This Action'], 403);
        }

        if ($userLevel->slug <= $comment->user->level->slug) {
            return response()->json(['message' => 'You cannot change the status of questions belonging to users with a level equal to or higher than yours.'], 403);
        }

        return $next($request);
    }
}
