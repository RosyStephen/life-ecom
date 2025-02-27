<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;


class RegisterController extends Controller
{
    /**
     * Handle a registration request for the application.
     */
    public function register(Request $request){
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => ['required', 'string', Password::min(8), 'confirmed'],
        ]);
        $otp = mt_rand(100000, 999999);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'email_verified_at' => null,
            'otp' => $otp,
        ]);

        // Send OTP to user's email
        Mail::raw("Your OTP is: $otp", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Your OTP Code');
        });

        return response()->json(['message' => 'User registered successfully. OTP has been sent to your email.']);

    }

    /**
     * Verify Email
     */
    public function verifyEmail(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|string',
        ]);

        $otp = $request->otp;
        $user = User::where('email', $request->email)->first();
        if($user->otp == $otp){
            $user->email_verified_at = now();
            $user->otp = null;
            $user->save();
            $user->assignRole('customer');
            return response()->json(['message' => 'Email verified successfully.']);
        }
        return response()->json(['message' => 'Invalid OTP.'], 403);

    }

    /**
     * Resend OTP
     */
    public function resendOTP(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $otp = mt_rand(100000, 999999);
        $user = User::where('email', $request->email)->first();
        $user->otp = $otp;
        $user->save();

        // Send OTP to user's email
        Mail::raw("Your OTP is: $otp", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Your OTP Code');
        });

        return response()->json(['message' => 'OTP has been sent to your email.']);
    }

}
