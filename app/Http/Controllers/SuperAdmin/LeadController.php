<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\User;
use App\Notifications\NewLeadNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
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

        $leads = $query->paginate(16);

        return view('super-admin.leads.index', [
            'leads' => $leads,
            'statuses' => ['new', 'contacted', 'qualified', 'has_website', 'proposal', 'negotiation', 'won', 'lost'],
            'sources' => ['google_maps', 'website', 'referral', 'social_media', 'cold_call', 'email', 'other'],
        ]);
    }

    /**
     * Display the leads map view (USA with color-coded pins by status).
     */
    public function map(Request $request): View
    {
        $query = Lead::select(['id', 'restaurant_name', 'city', 'state', 'street_address', 'status', 'latitude', 'longitude'])
            ->where(function ($q) {
                $q->whereNotNull('latitude')->whereNotNull('longitude')
                    ->orWhere(function ($q2) {
                        $q2->where(function ($q3) {
                            $q3->whereNotNull('city')->where('city', '!=', '')
                                ->orWhereNotNull('state')->where('state', '!=', '');
                        });
                    });
            });

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }
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

        $leads = $query->get()
            ->map(fn ($lead) => [
                'id' => $lead->id,
                'restaurant_name' => $lead->restaurant_name,
                'city' => $lead->city,
                'state' => $lead->state,
                'street_address' => $lead->street_address,
                'status' => $lead->status,
                'latitude' => $lead->latitude ? (float) $lead->latitude : null,
                'longitude' => $lead->longitude ? (float) $lead->longitude : null,
                'show_url' => route('super-admin.leads.show', $lead),
            ]);

        return view('super-admin.leads.map', [
            'leads' => $leads,
            'statuses' => ['new', 'contacted', 'qualified', 'has_website', 'proposal', 'negotiation', 'won', 'lost'],
            'sources' => ['google_maps', 'website', 'referral', 'social_media', 'cold_call', 'email', 'other'],
        ]);
    }

    /**
     * Update a lead's stored coordinates (called after first geocode on map).
     */
    public function updateCoordinates(Request $request, Lead $lead): \Illuminate\Http\JsonResponse
    {
        Log::info('Lead coordinates request received', [
            'lead_id' => $lead->id,
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
        ]);

        try {
            $validated = $request->validate([
                'latitude' => 'required|numeric|between:-90,90',
                'longitude' => 'required|numeric|between:-180,180',
            ]);

            $lead->latitude = (float) $validated['latitude'];
            $lead->longitude = (float) $validated['longitude'];
            $lead->save();

            Log::info('Lead coordinates saved', ['lead_id' => $lead->id, 'latitude' => $validated['latitude'], 'longitude' => $validated['longitude']]);

            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            Log::warning('Lead coordinates save failed', ['lead_id' => $lead->id, 'error' => $e->getMessage()]);

            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('super-admin.leads.create', [
            'users' => User::whereIn('role', ['admin', 'super_admin'])->get(),
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
            'phone' => ['nullable', 'string', 'regex:/^\(\d{3}\) \d{3}-\d{4}$/'],
            'secondary_phone' => ['nullable', 'string', 'regex:/^\(\d{3}\) \d{3}-\d{4}$/'],
            'street_address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'current_url' => 'nullable|url|max:255',
            'facebook_url' => 'nullable|url|max:500',
            'instagram_url' => 'nullable|url|max:500',
            'yelp_url' => 'nullable|url|max:500',
            'youtube_url' => 'nullable|url|max:500',
            'business_type' => ['nullable', Rule::in(['Restaurant', 'Food Truck', 'Bar', 'Other'])],
            'cuisine_type' => 'nullable|string|max:255',
            'number_of_locations' => 'nullable|integer|min:1',
            'current_ordering_system' => 'nullable|in:GrubHub,DoorDash,Custom,Other',
            'special_requirements' => 'nullable|string',
            'status' => 'required|in:new,contacted,qualified,has_website,proposal,negotiation,won,lost',
            'source' => 'nullable|in:google_maps,website,referral,social_media,cold_call,email,other',
            'estimated_value' => 'nullable|numeric|min:0',
            'first_contact_date' => 'nullable|date',
            'last_contact_date' => 'nullable|date',
            'follow_up_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'internal_notes' => 'nullable|string',
            'tags' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
        ], [
            'phone.regex' => 'The phone number must be in the format (000) 000-0000.',
            'secondary_phone.regex' => 'The secondary phone number must be in the format (000) 000-0000.',
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

        // When a super admin creates a lead, no email notifications are sent.
        if (!auth()->user()->isSuperAdmin()) {
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
                \Log::error('Failed to send lead notification email: ' . $e->getMessage());
            }
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
        $lead->load('prospectiveContacts');

        return view('super-admin.leads.edit', [
            'lead' => $lead,
            'users' => User::whereIn('role', ['admin', 'super_admin'])->get(),
            'contactTypes' => \App\Models\ProspectiveContact::CONTACT_TYPES,
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
            'phone' => ['nullable', 'string', 'regex:/^\(\d{3}\) \d{3}-\d{4}$/'],
            'secondary_phone' => ['nullable', 'string', 'regex:/^\(\d{3}\) \d{3}-\d{4}$/'],
            'street_address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'current_url' => 'nullable|url|max:255',
            'facebook_url' => 'nullable|url|max:500',
            'instagram_url' => 'nullable|url|max:500',
            'yelp_url' => 'nullable|url|max:500',
            'youtube_url' => 'nullable|url|max:500',
            'business_type' => ['nullable', Rule::in(['Restaurant', 'Food Truck', 'Bar', 'Other'])],
            'cuisine_type' => 'nullable|string|max:255',
            'number_of_locations' => 'nullable|integer|min:1',
            'current_ordering_system' => 'nullable|in:GrubHub,DoorDash,Custom,Other',
            'special_requirements' => 'nullable|string',
            'status' => 'required|in:new,contacted,qualified,has_website,proposal,negotiation,won,lost',
            'source' => 'nullable|in:google_maps,website,referral,social_media,cold_call,email,other',
            'estimated_value' => 'nullable|numeric|min:0',
            'first_contact_date' => 'nullable|date',
            'last_contact_date' => 'nullable|date',
            'follow_up_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'internal_notes' => 'nullable|string',
            'tags' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
        ], [
            'phone.regex' => 'The phone number must be in the format (000) 000-0000.',
            'secondary_phone.regex' => 'The secondary phone number must be in the format (000) 000-0000.',
        ]);

        // Update last contact date if status changed
        if ($request->has('status') && $request->status !== $lead->status) {
            $validated['last_contact_date'] = now();
        }

        $lead->update($validated);

        return redirect()->route('super-admin.leads.edit', $lead)
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
