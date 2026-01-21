<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Website;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Website::withTrashed()->with('user')->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by plan
        if ($request->filled('plan')) {
            $query->where('plan', $request->plan);
        }

        // Filter by deleted status
        if ($request->filled('deleted')) {
            if ($request->deleted === 'only') {
                $query->onlyTrashed();
            } elseif ($request->deleted === 'with') {
                // Already includes trashed
            } else {
                $query->withoutTrashed();
            }
        } else {
            $query->withoutTrashed();
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('domain', 'like', "%{$search}%")
                    ->orWhere('subdomain', 'like', "%{$search}%");
            });
        }

        $websites = $query->paginate(20);

        return view('super-admin.websites.index', [
            'websites' => $websites,
            'statuses' => ['active', 'suspended', 'pending', 'trial'],
            'plans' => ['basic', 'pro', 'enterprise'],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        // Get all admin and super_admin users for the dropdown
        $users = User::whereIn('role', [User::ROLE_ADMIN, User::ROLE_SUPER_ADMIN])
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();

        return view('super-admin.websites.create', [
            'statuses' => ['active', 'suspended', 'pending', 'trial'],
            'plans' => ['basic', 'pro', 'enterprise'],
            'users' => $users,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Convert empty strings to null for nullable fields
        $request->merge([
            'domain' => $request->input('domain') ?: null,
            'subdomain' => $request->input('subdomain') ?: null,
        ]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('websites', 'slug')],
            'domain' => ['nullable', 'string', 'max:255', Rule::unique('websites', 'domain')],
            'subdomain' => ['nullable', 'string', 'max:255', Rule::unique('websites', 'subdomain')],
            'status' => ['required', 'in:active,suspended,pending,trial'],
            'plan' => ['required', 'in:basic,pro,enterprise'],
            'description' => ['nullable', 'string'],
            'user_id' => ['required', 'exists:users,id'],
            'trial_ends_at' => ['nullable', 'date'],
            'subscription_ends_at' => ['nullable', 'date'],
        ]);

        // Create the website
        $website = Website::create([
            'user_id' => $validated['user_id'],
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'domain' => $validated['domain'] ?? null,
            'subdomain' => $validated['subdomain'] ?? null,
            'status' => $validated['status'],
            'plan' => $validated['plan'],
            'description' => $validated['description'] ?? null,
            'trial_ends_at' => $validated['trial_ends_at'] ?? null,
            'subscription_ends_at' => $validated['subscription_ends_at'] ?? null,
        ]);

        return redirect()->route('super-admin.websites.index')
            ->with('success', 'Website created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $website = Website::withTrashed()->with('user')->findOrFail($id);
        return view('super-admin.websites.show', compact('website'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $website = Website::withTrashed()->with('user')->findOrFail($id);
        
        // Get all admin and super_admin users for the dropdown
        $users = User::whereIn('role', [User::ROLE_ADMIN, User::ROLE_SUPER_ADMIN])
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();

        return view('super-admin.websites.edit', [
            'website' => $website,
            'statuses' => ['active', 'suspended', 'pending', 'trial'],
            'plans' => ['basic', 'pro', 'enterprise'],
            'users' => $users,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $website = Website::withTrashed()->findOrFail($id);
        
        // Convert empty strings to null for nullable fields
        $request->merge([
            'domain' => $request->input('domain') ?: null,
            'subdomain' => $request->input('subdomain') ?: null,
        ]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('websites', 'slug')->ignore($website->id)],
            'domain' => ['nullable', 'string', 'max:255', Rule::unique('websites', 'domain')->ignore($website->id)],
            'subdomain' => ['nullable', 'string', 'max:255', Rule::unique('websites', 'subdomain')->ignore($website->id)],
            'status' => ['required', 'in:active,suspended,pending,trial'],
            'plan' => ['required', 'in:basic,pro,enterprise'],
            'description' => ['nullable', 'string'],
            'user_id' => ['required', 'exists:users,id'],
            'trial_ends_at' => ['nullable', 'date'],
            'subscription_ends_at' => ['nullable', 'date'],
        ]);

        $website->update($validated);

        return redirect()->route('super-admin.websites.index')
            ->with('success', 'Website updated successfully.');
    }

    /**
     * Remove the specified resource from storage (soft delete).
     */
    public function destroy($id): RedirectResponse
    {
        $website = Website::withTrashed()->findOrFail($id);
        $website->delete();

        return redirect()->route('super-admin.websites.index')
            ->with('success', 'Website deleted successfully.');
    }

    /**
     * Restore a soft-deleted website.
     */
    public function restore($id): RedirectResponse
    {
        $website = Website::withTrashed()->findOrFail($id);
        $website->restore();

        return redirect()->route('super-admin.websites.index')
            ->with('success', 'Website restored successfully.');
    }

    /**
     * Permanently delete a website.
     */
    public function forceDelete($id): RedirectResponse
    {
        $website = Website::withTrashed()->findOrFail($id);
        $website->forceDelete();

        return redirect()->route('super-admin.websites.index')
            ->with('success', 'Website permanently deleted.');
    }
}
