<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Session;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EmailVerificationController extends Controller
{
    public function verify(Request $request, string $id, string $hash): JsonResponse
    {
        $user = User::findOrFail($id);

        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return response()->json([
                'message' => 'Ungültiger Verifizierungslink',
            ], 403);
        }

        if ($user->hasVerifiedEmail()) {
            $token = Str::random(60);
            $expiresAt = now()->addHours(24);

            $session = Session::create([
                'user_id' => $user->id,
                'token' => hash('sha256', $token),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'last_activity' => now(),
                'expires_at' => $expiresAt,
            ]);

            return response()->json([
                'message' => 'E-Mail bereits verifiziert',
                'verified' => true,
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'email_verified_at' => $user->email_verified_at,
                ],
                'expires_at' => $expiresAt->toIso8601String(),
            ], 200);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        $token = Str::random(60);
        $expiresAt = now()->addHours(24);

        $session = Session::create([
            'user_id' => $user->id,
            'token' => hash('sha256', $token),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'last_activity' => now(),
            'expires_at' => $expiresAt,
        ]);

        return response()->json([
            'message' => 'E-Mail erfolgreich verifiziert',
            'verified' => true,
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at,
            ],
            'expires_at' => $expiresAt->toIso8601String(),
        ], 200);
    }

    public function resend(Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'Nicht authentifiziert',
            ], 401);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'E-Mail bereits verifiziert',
            ], 400);
        }

        try {
            $user->sendEmailVerificationNotification();

            return response()->json([
                'message' => 'Verifizierungs-E-Mail wurde erneut gesendet',
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Failed to resend verification email: ' . $e->getMessage());

            return response()->json([
                'message' => 'Fehler beim Senden der E-Mail. Bitte versuchen Sie es später erneut.',
            ], 500);
        }
    }

    public function status(Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'Nicht authentifiziert',
            ], 401);
        }

        return response()->json([
            'verified' => $user->hasVerifiedEmail(),
            'email' => $user->email,
        ], 200);
    }
}

