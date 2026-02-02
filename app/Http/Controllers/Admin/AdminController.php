<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(): View
    {
        $websites = Auth::user()->websites()->latest()->get();

        return view('admin.dashboard', compact('websites'));
    }
}
