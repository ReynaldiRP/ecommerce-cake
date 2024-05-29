<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class AuthentificationController extends Controller
{
    public function login()
    {
        return Inertia::render('Login');
    }
}
