<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMenuPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $menuKey, string $action = 'can_view'): Response
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated'
            ], 401);
        }

        // Check permission
        if (!$user->hasMenuPermission($menuKey, $action)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have permission to access this resource',
                    'required_permission' => $action,
                    'menu' => $menuKey
                ], 403);
            }

            abort(403, 'You do not have permission to access this page');
        }

        return $next($request);
    }
}
