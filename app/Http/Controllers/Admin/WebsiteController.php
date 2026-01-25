<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Website;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Website::with('user')->latest();

        // Only show websites created by the current user
        $user = Auth::user();
        $query->where('user_id', $user->id);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by plan
        if ($request->filled('plan')) {
            $query->where('plan', $request->plan);
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

        return view('admin.websites.index', [
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
        return view('admin.websites.create', [
            'statuses' => ['active', 'suspended', 'pending', 'trial'],
            'plans' => ['basic', 'pro', 'enterprise'],
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
            'timezone' => [
                'nullable',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    if ($value && !in_array($value, \DateTimeZone::listIdentifiers(), true)) {
                        $fail('The selected timezone is invalid.');
                    }
                },
            ],
        ]);

        // Create the website and tie it to the current user (admin/super_admin)
        $website = Website::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'domain' => $validated['domain'] ?? null,
            'subdomain' => $validated['subdomain'] ?? null,
            'status' => $validated['status'],
            'plan' => $validated['plan'],
            'description' => $validated['description'] ?? null,
            'timezone' => $validated['timezone'] ?? null,
        ]);

        return redirect()->route('admin.websites.index')
            ->with('success', 'Website created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Website $website): View
    {
        $user = Auth::user();
        
        // Check if user owns this website or is super admin
        if (!$user->isSuperAdmin() && $website->user_id !== $user->id) {
            abort(403, 'You do not have permission to view this website.');
        }
        
        $website->load('user');
        $current_active_uri = '';
        if(config('app.env') === 'production') {
            $current_active_uri = 'https://' . ($website->domain ?? $website->subdomain) . '.' . config('app.domain');
        } else {
            $current_active_uri = 'http://' . ($website->domain ?? $website->subdomain) . '.' . config('app.domain');
        }
        return view('admin.websites.show', compact('website', 'current_active_uri'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Website $website): View
    {
        $user = Auth::user();
        
        // Check if user owns this website or is super admin
        if (!$user->isSuperAdmin() && $website->user_id !== $user->id) {
            abort(403, 'You do not have permission to edit this website.');
        }
        
        $website->load('user');
        return view('admin.websites.edit', [
            'website' => $website,
            'statuses' => ['active', 'suspended', 'pending', 'trial'],
            'plans' => ['basic', 'pro', 'enterprise'],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Website $website): RedirectResponse
    {
        $user = Auth::user();
        
        // Check if user owns this website or is super admin
        if (!$user->isSuperAdmin() && $website->user_id !== $user->id) {
            abort(403, 'You do not have permission to update this website.');
        }
        
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
            'timezone' => [
                'nullable',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    if ($value && !in_array($value, \DateTimeZone::listIdentifiers(), true)) {
                        $fail('The selected timezone is invalid.');
                    }
                },
            ],
        ]);

        $website->update($validated);

        return redirect()->route('admin.websites.show', $website)
            ->with('success', 'Website updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Website $website): RedirectResponse
    {
        $user = Auth::user();
        
        // Check if user owns this website or is super admin
        if (!$user->isSuperAdmin() && $website->user_id !== $user->id) {
            abort(403, 'You do not have permission to delete this website.');
        }
        
        $website->delete();

        return redirect()->route('admin.websites.index')
            ->with('success', 'Website deleted successfully.');
    }
}
