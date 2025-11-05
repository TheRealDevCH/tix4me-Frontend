<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Session;

/**
 * ValidateSessionToken Middleware
 *
 * This middleware validates the session token from the Authorization header.
 * It checks if:
 * - The token exists in the Authorization header
 * - The token is valid and exists in the database
 * - The token has not expired
 * - The session is still active
 *
 * If validation fails, it returns a 401 Unauthorized response.
 * If validation succeeds, it attaches the session and user to the request.
 */
class ValidateSessionToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $this->getTokenFromRequest($request);

        if (!$token) {
            return response()->json([
                'message' => 'Token nicht gefunden. Bitte melden Sie sich an.',
            ], 401);
        }

        $session = Session::where('token', $token)
            ->with('user')
            ->first();

        if (!$session) {
            return response()->json([
                'message' => 'Ungültiges Token',
            ], 401);
        }

        if (!$session->isValid()) {
            $session->delete();
            return response()->json([
                'message' => 'Token ist abgelaufen. Bitte melden Sie sich erneut an.',
            ], 401);
        }

        $session->update(['last_activity' => now()]);

        Auth::setUser($session->user);

        $request->merge([
            'session' => $session,
            'user' => $session->user,
        ]);

        return $next($request);
    }

    private function getTokenFromRequest(Request $request): ?string
    {
        $authHeader = $request->header('Authorization');

        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return null;
        }

        return substr($authHeader, 7);
    }
}
