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

    public function reset(Request $request): \Illuminate\Http\JsonResponse
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
                ->where('expires_at', '>', now())
                ->exists()
        ) {
            $user = User::where('email', $data['email'])->first();

            $user['password'] = bcrypt($data['password']);

            $user->save();

            OtpCode::where('code', $data['otp'])->delete();

            return redirect()->intended(route('login', absolute: false));
        }
    }
}
