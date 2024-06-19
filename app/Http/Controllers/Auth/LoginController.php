<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Login');
    }

    /**
     * Handle an authentication attempt.
     */
    public function store(LoginRequest $request)
    {
        $credential = $request->validated();

        if (Auth::attempt($credential)) {
            $request->session()->regenerate();
            return redirect('/home');
        }

        $user = User::where('email', $credential['email'])->first();

        if ($user) {
            $errors = ['password' => 'Invalid Password'];
        } else {
            $errors = ['email' => 'Invalid Email Address'];
        }

        return to_route('login.index')->withErrors($errors);
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return to_route('login.index');
    }
}
