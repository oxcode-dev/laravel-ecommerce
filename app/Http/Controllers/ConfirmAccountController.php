<?php

namespace App\Http\Controllers;

use App\Models\OtpCode;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ConfirmAccountController extends Controller
{
    public function index (Request $request)
    {
        return Inertia::render('auth/confirm-account', [
            // 'status' => $request->session()->get('status'),
        ]);
    }

    public function confirm(Request $request)//: \Illuminate\Http\JsonResponse
    {
        $data = $request->validate([
            'otp' => 'required',
            'email' => 'required|email',
            'password' => ['required'],
            // 'password' => ['required', 'confirmed'],
        ]);

        if (
            OtpCode::where('code', $data['otp'])
                ->where('email', $data['email'])
                // ->where('expires_at', '>', now())
                ->exists()
        ) {
            $user = User::where('email', $data['email'])->first();

            $user['email_verified_at'] = now();
            $user['password'] = bcrypt($data['password']);

            $user->save();

            OtpCode::where('code', $data['otp'])->delete();

            return redirect('/login');

            // return redirect()->intended(route('login', absolute: true));
        }

        return back()->withErrors(
            [
                'status' => 'failed',
                'message' => 'this otp does not exist',
            ],
            'error'
        );
    }

    public function generateOtp(Request $request)//: \Illuminate\Http\JsonResponse
    {
        $data = $request->validate(['email' => 'required|email']);

        if (User::where('email', $data['email'])->exists()) {
            $user = User::where('email', $data['email'])->firstOrFail();
            $user->sendPasswordResetNotification();

            return back()->with(
                [
                    'status' => 'success',
                    'message' => 'email sent successfully.',
                ],
                'error'
            );
        } else {
            return back()->withErrors(
                [
                    'status' => 'failed',
                    'message' => 'email does not exist.',
                ],
                'error'
            );
        }
    }

}
