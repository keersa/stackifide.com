<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Page;
use App\Helpers\TenantHelper;
use Illuminate\View\View;

class TenantDashboardController extends Controller
{
    /**
     * Display the tenant dashboard.
     */
    public function index(): View
    {
        $tenant = TenantHelper::current();
        
        $stats = [
            'menu_items' => MenuItem::count(),
            'published_pages' => Page::where('is_published', true)->count(),
            'total_pages' => Page::count(),
            'available_menu_items' => MenuItem::where('is_available', true)->count(),
        ];

        return view('tenant.dashboard', [
            'tenant' => $tenant,
            'stats' => $stats,
        ]);
    }
}
