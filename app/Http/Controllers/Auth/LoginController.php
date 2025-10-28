<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

/**
 * LoginController - Handles user authentication and session token generation
 *
 * This controller is responsible for:
 * - Validating user credentials
 * - Generating secure session tokens
 * - Creating session records in the database
 * - Returning authentication tokens to the client
 *
 * API Endpoint: POST /api/auth/login
 *
 * @package App\Http\Controllers\Auth
 */
class LoginController extends Controller
{
    /**
     * Session token expiration time in hours
     */
    private const SESSION_EXPIRATION_HOURS = 24;

    /**
     * Handle user login and generate session token
     *
     * Request body:
     * {
     *     "email": "user@example.com",
     *     "password": "password123"
     * }
     *
     * Success response (200):
     * {
     *     "message": "Login erfolgreich",
     *     "token": "secure_random_token_60_characters",
     *     "user": {
     *         "id": 1,
     *         "name": "User Name",
     *         "email": "user@example.com"
     *     },
     *     "expires_at": "2025-10-24T12:00:00Z"
     * }
     *
     * Error response (401):
     * {
     *     "message": "E-Mail oder Passwort ist falsch"
     * }
     *
     * Error response (422):
     * {
     *     "message": "Validierungsfehler",
     *     "errors": {
     *         "email": ["E-Mail ist erforderlich"],
     *         "password": ["Passwort ist erforderlich"]
     *     }
     * }
     */
    public function login(Request $request): JsonResponse
    {
        // Validate input
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ], [
            'email.required' => 'E-Mail ist erforderlich',
            'email.email' => 'E-Mail-Format ist ungültig',
            'password.required' => 'Passwort ist erforderlich',
            'password.min' => 'Passwort muss mindestens 6 Zeichen lang sein',
        ]);

        // Find user by email
        $user = User::where('email', $validated['email'])->first();

        // Check if user exists and password is correct
        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'message' => 'E-Mail oder Passwort ist falsch',
            ], 401);
        }

        // Invalidate all previous sessions for this user
        $user->invalidateAllSessions();

        // Generate secure token
        $token = Str::random(60);
        $expiresAt = now()->addHours(self::SESSION_EXPIRATION_HOURS);

        // Create new session
        $session = Session::create([
            'user_id' => $user->id,
            'token' => $token,
            'user_agent' => $request->userAgent(),
            'ip_address' => $request->ip(),
            'last_activity' => now(),
            'expires_at' => $expiresAt,
        ]);

        return response()->json([
            'message' => 'Login erfolgreich',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'expires_at' => $expiresAt->toIso8601String(),
        ], 200);
    }

    /**
     * Handle user logout and invalidate session
     *
     * Headers required:
     * {
     *     "Authorization": "Bearer session_token"
     * }
     *
     * Success response (200):
     * {
     *     "message": "Logout erfolgreich"
     * }
     *
     * Error response (401):
     * {
     *     "message": "Ungültiges oder abgelaufenes Token"
     * }
     */
    public function logout(Request $request): JsonResponse
    {
        // Get token from Authorization header
        $token = $this->getTokenFromRequest($request);

        if (!$token) {
            return response()->json([
                'message' => 'Token nicht gefunden',
            ], 401);
        }

        // Find and delete session
        $session = Session::where('token', $token)->first();

        if (!$session) {
            return response()->json([
                'message' => 'Ungültiges oder abgelaufenes Token',
            ], 401);
        }

        $session->invalidate();

        return response()->json([
            'message' => 'Logout erfolgreich',
        ], 200);
    }

    /**
     * Extract token from Authorization header
     *
     * Expected format: "Bearer token_value"
     */
    private function getTokenFromRequest(Request $request): ?string
    {
        $authHeader = $request->header('Authorization');

        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return null;
        }

        return substr($authHeader, 7);
    }
}
