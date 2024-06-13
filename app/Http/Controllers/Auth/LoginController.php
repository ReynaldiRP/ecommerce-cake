<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

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
    public function store(StoreUserRequest $request)
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

        return back()->withErrors($errors);
    }
}
