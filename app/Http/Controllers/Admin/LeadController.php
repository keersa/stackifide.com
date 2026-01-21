<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\User;
use App\Notifications\NewLeadNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Lead::with('assignedUser')->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by source
        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('restaurant_name', 'like', "%{$search}%")
                    ->orWhere('contact_first_name', 'like', "%{$search}%")
                    ->orWhere('contact_last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $leads = $query->paginate(20);

        return view('super-admin.leads.index', [
            'leads' => $leads,
            'statuses' => ['new', 'contacted', 'qualified', 'proposal', 'negotiation', 'won', 'lost'],
            'sources' => ['website', 'referral', 'social_media', 'cold_call', 'email', 'other'],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('super-admin.leads.create', [
            'users' => User::whereIn('role', ['admin', 'super_admin', 'editor'])->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'restaurant_name' => 'required|string|max:255',
            'contact_first_name' => 'nullable|string|max:255',
            'contact_last_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'secondary_phone' => 'nullable|string|max:255',
            'street_address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'current_url' => 'nullable|url|max:255',
            'business_type' => 'nullable|string|max:255',
            'cuisine_type' => 'nullable|string|max:255',
            'number_of_locations' => 'nullable|integer|min:1',
            'current_ordering_system' => 'nullable|in:GrubHub,DoorDash,Custom,Other',
            'special_requirements' => 'nullable|string',
            'status' => 'required|in:new,contacted,qualified,proposal,negotiation,won,lost',
            'source' => 'nullable|in:website,referral,social_media,cold_call,email,other',
            'estimated_value' => 'nullable|numeric|min:0',
            'first_contact_date' => 'nullable|date',
            'last_contact_date' => 'nullable|date',
            'follow_up_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'internal_notes' => 'nullable|string',
            'tags' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        // Set first contact date if not provided
        if (empty($validated['first_contact_date'])) {
            $validated['first_contact_date'] = now();
        }

        // Set last contact date if not provided
        if (empty($validated['last_contact_date'])) {
            $validated['last_contact_date'] = now();
        }

        // Convert tags from comma-separated string to array
        if (isset($validated['tags']) && is_string($validated['tags'])) {
            $tags = array_map('trim', explode(',', $validated['tags']));
            $validated['tags'] = array_filter($tags); // Remove empty tags
            if (empty($validated['tags'])) {
                $validated['tags'] = null;
            }
        }

        $lead = Lead::create($validated);

        // Send notification to all admin users (except the one creating the lead if they're an admin)
        try {
            $admins = User::whereIn('role', [User::ROLE_ADMIN, User::ROLE_SUPER_ADMIN])
                ->where('id', '!=', auth()->id())
                ->get();
            foreach ($admins as $admin) {
                if ($admin->email) {
                    $admin->notify(new NewLeadNotification($lead));
                }
            }
        } catch (\Exception $e) {
            // Log the error but don't fail the lead creation
            \Log::error('Failed to send lead notification email: ' . $e->getMessage());
        }

        return redirect()->route('super-admin.leads.index')
            ->with('success', 'Lead created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lead $lead): View
    {
        $lead->load('assignedUser');

        return view('super-admin.leads.show', [
            'lead' => $lead,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lead $lead): View
    {
        return view('super-admin.leads.edit', [
            'lead' => $lead,
            'users' => User::whereIn('role', ['admin', 'super_admin', 'editor'])->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lead $lead): RedirectResponse
    {
        $validated = $request->validate([
            'restaurant_name' => 'required|string|max:255',
            'contact_first_name' => 'nullable|string|max:255',
            'contact_last_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'secondary_phone' => 'nullable|string|max:255',
            'street_address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'current_url' => 'nullable|url|max:255',
            'business_type' => 'nullable|string|max:255',
            'cuisine_type' => 'nullable|string|max:255',
            'number_of_locations' => 'nullable|integer|min:1',
            'current_ordering_system' => 'nullable|in:GrubHub,DoorDash,Custom,Other',
            'special_requirements' => 'nullable|string',
            'status' => 'required|in:new,contacted,qualified,proposal,negotiation,won,lost',
            'source' => 'nullable|in:website,referral,social_media,cold_call,email,other',
            'estimated_value' => 'nullable|numeric|min:0',
            'first_contact_date' => 'nullable|date',
            'last_contact_date' => 'nullable|date',
            'follow_up_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'internal_notes' => 'nullable|string',
            'tags' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        // Update last contact date if status changed
        if ($request->has('status') && $request->status !== $lead->status) {
            $validated['last_contact_date'] = now();
        }

        $lead->update($validated);

        return redirect()->route('super-admin.leads.show', $lead)
            ->with('success', 'Lead updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lead $lead): RedirectResponse
    {
        $lead->delete();

        return redirect()->route('super-admin.leads.index')
            ->with('success', 'Lead deleted successfully.');
    }
}
