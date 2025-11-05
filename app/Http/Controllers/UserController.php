<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function updateProfile(Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'Nicht authentifiziert',
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validierungsfehler',
                'errors' => $validator->errors(),
            ], 422);
        }

        $emailChanged = $user->email !== $request->email;

        $user->name = $request->name;
        $user->email = $request->email;

        if ($emailChanged) {
            $user->email_verified_at = null;
            $user->save();

            try {
                $user->sendEmailVerificationNotification();
            } catch (\Exception $e) {
                \Log::error('Failed to send verification email after email change: ' . $e->getMessage());
            }

            return response()->json([
                'message' => 'Profil aktualisiert. Bitte bestätigen Sie Ihre neue E-Mail-Adresse.',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'email_verified_at' => $user->email_verified_at,
                ],
                'email_changed' => true,
            ], 200);
        }

        $user->save();

        return response()->json([
            'message' => 'Profil erfolgreich aktualisiert',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at,
            ],
            'email_changed' => false,
        ], 200);
    }

    public function updatePassword(Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'Nicht authentifiziert',
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validierungsfehler',
                'errors' => $validator->errors(),
            ], 422);
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'message' => 'Das aktuelle Passwort ist falsch',
            ], 422);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'message' => 'Passwort erfolgreich geändert',
        ], 200);
    }

    public function deleteAccount(Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'Nicht authentifiziert',
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validierungsfehler',
                'errors' => $validator->errors(),
            ], 422);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Das Passwort ist falsch',
            ], 422);
        }

        $user->invalidateAllSessions();
        $user->delete();

        return response()->json([
            'message' => 'Konto erfolgreich gelöscht',
        ], 200);
    }
}

