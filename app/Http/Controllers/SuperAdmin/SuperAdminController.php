<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class SuperAdminController extends Controller
{
    /**
     * Display the super admin dashboard.
     */
    public function index(): View
    {
        return view('super-admin.dashboard');
    }
}
