<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SetPasswordController extends Controller
{
    public function setPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        $email = base64_decode($request->token);
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid token'], 400);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message' => 'Password has been set successfully']);
    }
}
