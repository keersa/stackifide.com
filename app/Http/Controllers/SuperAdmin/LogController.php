<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Log::with('user')->latest();

        // Filter by action
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by model type
        if ($request->filled('model_type')) {
            $query->where('model_type', $request->model_type);
        }

        // Search in description
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                    ->orWhere('action', 'like', "%{$search}%");
            });
        }

        // Get unique actions for filter dropdown
        $actions = Log::distinct()->pluck('action')->sort()->values();
        
        // Get unique model types for filter dropdown
        $modelTypes = Log::distinct()->whereNotNull('model_type')->pluck('model_type')->sort()->values();

        // Get users who have logs for filter dropdown
        $users = User::whereHas('logs')->orderBy('first_name')->orderBy('last_name')->get();

        $logs = $query->paginate(50);

        return view('super-admin.logs.index', [
            'logs' => $logs,
            'actions' => $actions,
            'modelTypes' => $modelTypes,
            'users' => $users,
        ]);
    }
}
