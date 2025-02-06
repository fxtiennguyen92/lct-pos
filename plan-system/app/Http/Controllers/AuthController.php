<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Log in
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withInput($request->except('password'))->withErrors($validator);
        }

        // Unauth
        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return back()->withInput($request->except('password'))
                ->withErrors(['email' => __('auth.failed')]);
        }

        // Check active
        $user = Auth::user();
        if (!$user->active_flg) {
            Auth::logout();
            return back()->withInput($request->except('password'))
                ->withErrors(['error' => __('auth.inactived')]);
        }

        // Success
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    /**
     * Request to reset password
     */
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }

        // Check user exists
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withInput()->withErrors(['email' => __('passwords.user')]);
        }

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('info', __('passwords.sent'))
            : back()->withErrors(['email' => __($status)]);
    }

    public function viewResetPassword(Request $request)
    {
        return view('auth.reset-password');
    }

    /**
     * Reset password
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|min:8|email',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withInput($request->except('password'))->withErrors($validator);
        }

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                // Define token
                $token = Str::random(60);

                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken($token);

                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->withInput($request->except('password'))->with('info', __('passwords.reset'))
            : back()->withErrors(['email' => [__($status)]]);
    }

    /**
     * Log out
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
