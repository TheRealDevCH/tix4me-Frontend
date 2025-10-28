<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

/**
 * RegisterController - Handles user registration and initial session creation
 *
 * This controller is responsible for:
 * - Validating registration data
 * - Creating new user accounts
 * - Generating secure session tokens
 * - Creating initial session records
 * - Returning authentication tokens to the client
 *
 * API Endpoint: POST /api/auth/register
 *
 * @package App\Http\Controllers\Auth
 */
class RegisterController extends Controller
{
    /**
     * Session token expiration time in hours
     */
    private const SESSION_EXPIRATION_HOURS = 24;

    /**
     * Handle user registration and generate session token
     *
     * Request body:
     * {
     *     "name": "User Name",
     *     "email": "user@example.com",
     *     "password": "password123",
     *     "password_confirmation": "password123"
     * }
     *
     * Success response (201):
     * {
     *     "message": "Registrierung erfolgreich",
     *     "token": "secure_random_token_60_characters",
     *     "user": {
     *         "id": 1,
     *         "name": "User Name",
     *         "email": "user@example.com"
     *     },
     *     "expires_at": "2025-10-24T12:00:00Z"
     * }
     *
     * Error response (422):
     * {
     *     "message": "Validierungsfehler",
     *     "errors": {
     *         "email": ["Diese E-Mail-Adresse ist bereits registriert"],
     *         "password": ["Passwort muss mindestens 8 Zeichen lang sein"]
     *     }
     * }
     */
    public function register(Request $request): JsonResponse
    {
        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ], [
            'name.required' => 'Name ist erforderlich',
            'name.max' => 'Name darf maximal 255 Zeichen lang sein',
            'email.required' => 'E-Mail ist erforderlich',
            'email.email' => 'E-Mail-Format ist ungültig',
            'email.unique' => 'Diese E-Mail-Adresse ist bereits registriert',
            'password.required' => 'Passwort ist erforderlich',
            'password.confirmed' => 'Passwörter stimmen nicht überein',
            'password.min' => 'Passwort muss mindestens 8 Zeichen lang sein',
            'password.mixed_case' => 'Passwort muss Groß- und Kleinbuchstaben enthalten',
            'password.numbers' => 'Passwort muss Zahlen enthalten',
            'password.symbols' => 'Passwort muss Sonderzeichen enthalten',
        ]);

        // Create new user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        // Generate secure token
        $token = Str::random(60);
        $expiresAt = now()->addHours(self::SESSION_EXPIRATION_HOURS);

        // Create initial session
        $session = Session::create([
            'user_id' => $user->id,
            'token' => $token,
            'user_agent' => $request->userAgent(),
            'ip_address' => $request->ip(),
            'last_activity' => now(),
            'expires_at' => $expiresAt,
        ]);

        return response()->json([
            'message' => 'Registrierung erfolgreich',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'expires_at' => $expiresAt->toIso8601String(),
        ], 201);
    }
}
