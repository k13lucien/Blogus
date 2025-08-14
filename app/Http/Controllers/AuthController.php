<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * POST /api/register
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', Password::min(8)],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return response()->json([
            'message' => 'Utilisateur créé',
            'user' => $user,
        ], 201);
    }

    /**
     * POST /api/login
     * retourne un token d'accès (Bearer).
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string']
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || Hash::check($credentials['password'], $user->password))
        {
            return response()->json([
                'message' => 'Identifiants invalides',
            ], 422);
        }

        
        $tokenName = $request->userAgent() ?: 'api-token';

        // Abilities par défaut : tout accès (*)
        $abilities = ['*'];

        $token = $user->createToken($tokenName, $abilities)->plainTextToken;

        return response()->json([
            'message' => 'Connexion réussie',
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }

    /**
     * GET /api/user
     * Retourne l'utilisateur courant (Décodé depuis le token).
     */
    public function me(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * POST /api/logout
     * Revoque le token courant.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Déconnecté (Token revoqué)']);
    }
}
