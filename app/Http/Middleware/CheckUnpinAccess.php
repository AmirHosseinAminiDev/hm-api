<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUnpinAccess
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
            return $this->denyAccess('Users with your level are not allowed to unpin questions.');
        }

        return $next($request);
    }

    private function denyAccess(string $message)
    {
        return response()->json(['message' => $message], 403);
    }
}
