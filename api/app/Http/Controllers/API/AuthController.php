<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate(['email'=>'required|email','password'=>'required']);
        $user = User::where('email', $request->email)->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['message'=>'Invalid credentials'], 401);
        }

        // gather abilities from roles
        $abilities = $user->getAbilitiesFromRoles(); // returns array of ability names

        // fallback: if manager or admin role, you may want '*' instead:
        if (in_array('admin', $user->roles->pluck('name')->toArray())) {
            $abilities = ['*'];
        }

        // create token with abilities and optional expires_at
        $tokenResult = $user->createToken('mobile', $abilities);
        $token = $tokenResult->accessToken;
        $token->expires_at = now()->addDays(30);
        $token->save();

        return response()->json([
            'token' => $tokenResult->plainTextToken,
            'user'  => $user,
        ]);

        // create personal access token
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user
        ]);
    }

    // Logout (delete current token)
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message'=>'Logged out']);
    }

    // Delete All tokens
    public function logoutFromAllDevices(Request $request)
    {
        $request->user()->tokens()->delete();     
        return response()->json(['message'=>'Logged out from all devices']);
    }

    // current user
    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}
