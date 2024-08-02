<?php

// app/Http/Controllers/PasswordResetController.php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class PasswordResetController extends Controller
{
public function showResetForm($token)
{
return view('auth.passwords.reset')->with(['token' => $token]);
}

public function reset(Request $request)
{
$request->validate([
'email' => 'required|email',
'password' => 'required|confirmed|min:8',
'token' => 'required'
]);

$passwordReset = DB::table('password_reset_tokens')
->where('email', $request->email)
->first();

if (!$passwordReset || !Hash::check($request->token, $passwordReset->token)) {
return back()->withErrors(['email' => 'Invalid token!']);
}

$user = User::where('email', $request->email)->first();
if ($user) {
$user->password = Hash::make($request->password);
$user->save();
}

DB::table('password_reset_tokens')->where('email', $request->email)->delete();

return redirect('/login')->with('status', 'Password has been reset!');
}
}
