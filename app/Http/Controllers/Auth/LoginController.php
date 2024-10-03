<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class LoginController extends Controller
{

    /**
     * Show the login page in the application.
     *
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('LoginSection');
    }


    /**
     * Method to login in the application.
     *
     * @param LoginRequest $request [User credentials]
     *
     * @return RedirectResponse
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $credential = $request->validated();

        if (Auth::attempt($credential)) {
            $request->session()->regenerate();

            if (Auth::user()->role->name === 'admin') {
                return redirect()->route('dashboard-home');
            }

            return redirect()->route('home');
        }

        $user = User::where('email', $credential['email'])->first();

        if ($user) {
            $errors = ['password' => 'Invalid Password'];
        } else {
            $errors = ['email' => 'Invalid Email Address'];
        }

        return to_route('login.index')->withErrors($errors);
    }

    /**
     * Method to logout from the application.
     *
     * @param Request $request [User credentials]
     *
     * @return RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return to_route('login.index');
    }
}
