<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function login(Request $request)
    {
        // Validation Rules
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8',
        ], [
            'email.exists' => 'No account found with this email.',
            'password.min' => 'Password must be at least 8 characters.',
        ]);

        // Check Credentials
        if (!Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials.'],
            ]);
        }

        // Retrieve Authenticated User
        $user = User::where('email', $request->email)->first();

        // Check if Email is Verified
        if (is_null($user->email_verified_at)) {
            Auth::logout();

            $otp = mt_rand(100000, 999999);
            $user->otp = $otp;
            $user->save();

            // Send OTP to user's email
            Mail::raw("Your OTP is: $otp", function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Your OTP Code');
            });

            return response()->json([
                'message' => 'Email not verified. OTP has been sent to your email.',
            ], 403);

        }

        // Generate Token (Assuming Laravel Sanctum is Used)
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'message' => 'Login successful.'
        ], 200);
    }

    /**
     * Logout
     */

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout successful.']);
    }



}
