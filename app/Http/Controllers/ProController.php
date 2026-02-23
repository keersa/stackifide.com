<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\User;
use App\Notifications\NewLeadNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProController extends Controller
{

    public function learn(): View
    {
        $title = 'Learn More - Pro';
        return view('pro.learn-more', [
            'title' => $title,
        ]);
    }

    public function survey(): View
    {
        $title = 'Get Started - Pro';
        return view('pro.get-started', [
            'title' => $title,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'restaurant_name' => 'required|string|max:255',
            'contact_first_name' => 'required|string|max:255',
            'contact_last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => ['required', 'string', 'regex:/^\(\d{3}\) \d{3}-\d{4}$/'],
            'business_type' => 'nullable|string|max:255',
            'cuisine_type' => 'nullable|string|max:255',
            'number_of_locations' => 'nullable|integer|min:1',
            'street_address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'current_url' => 'nullable|url|max:255',
            'current_ordering_system' => 'nullable|in:GrubHub,DoorDash,Custom,Other',
            'special_requirements' => 'nullable|string',
            'notes' => 'nullable|string',
        ], [
            'phone.regex' => 'The phone number must be in the format (000) 000-0000.',
        ]);

        // Create lead with Pro plan defaults
        $leadData = array_merge($validated, [
            'status' => 'new',
            'source' => 'website',
            'first_contact_date' => now(),
            'last_contact_date' => now(),
            'tags' => ['Pro Plan', 'Website Inquiry'],
        ]);

        $lead = Lead::create($leadData);

        // Send notification to super admins only
        try {
            $superAdmins = User::where('role', User::ROLE_SUPER_ADMIN)->get();
            foreach ($superAdmins as $user) {
                if ($user->email) {
                    $user->notify(new NewLeadNotification($lead));
                }
            }
        } catch (\Exception $e) {
            // Log the error but don't fail the lead creation
            \Log::error('Failed to send lead notification email: ' . $e->getMessage());
        }

        return redirect()->route('pro.get-started')
            ->with('success', 'Thank you for your inquiry! We will contact you soon to discuss your Pro subscription.');
    }

}
