<?php

namespace App\Http\Controllers\AdminDashboard\Approval;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShowAllApprovalController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return Inertia::render('AdminDashboard/Approval/Index');
    }
}
