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
        if ($request->user()->role_id == 2) {
            // If the request is already on the admin dashboard, allow it to proceed
            if ($request->routeIs('dashboard-home')) {
                return $next($request);
            }

            // If not already on the dashboard, redirect to the admin dashboard
            return redirect()->route('dashboard-home');
        }

        // If the user is not an admin, redirect them to the homepage
        return redirect()->route('home');
    }
}
