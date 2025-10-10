<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is an admin
        if ($request->user()->hasRole('admin') || $request->user()->hasRole('owner')) {

            // Allow the request to proceed if the route belongs to the admin section
            if ($request->is('admin/dashboard*')) {
                return $next($request);
            }

            // Check if the user is not owner its will not access to home dashboard
            // if (!auth()->user()->hasRole('owner')) {
            //     return redirect()->route('category.index');
            // } else {
            //     return redirect()->route('dashboard-home');
            // }

        }

        // If the user is not an admin, redirect them to the homepage
        return redirect()->route('home');
    }
}
