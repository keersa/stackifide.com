<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\ProspectiveContact;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProspectiveContactController extends Controller
{
    /**
     * List prospective contacts for a lead (JSON for AJAX).
     */
    public function index(Lead $lead): JsonResponse
    {
        $contacts = $lead->prospectiveContacts()->get()->map(
            fn (ProspectiveContact $c) => [
                'id' => $c->id,
                'contact_type' => $c->contact_type,
                'contact_type_label' => $c->contact_type_label,
                'notes' => $c->notes,
                'created_at' => $c->created_at->toIso8601String(),
                'created_at_human' => $c->created_at->format('M j, Y g:i A'),
                'user_name' => $c->user
                    ? ($c->user->full_name ?: $c->user->email)
                    : null,
            ]
        );

        return response()->json(['contacts' => $contacts]);
    }

    /**
     * Store a new prospective contact (JSON for AJAX).
     */
    public function store(Request $request, Lead $lead): JsonResponse
    {
        $validated = $request->validate([
            'contact_type' => 'required|in:email,phone_call,facebook,in_person_flyer,sms_message,other',
            'notes' => 'nullable|string|max:65535',
        ]);

        $contact = $lead->prospectiveContacts()->create($validated + [
            'user_id' => Auth::id(),
        ]);

        return response()->json([
            'contact' => [
                'id' => $contact->id,
                'contact_type' => $contact->contact_type,
                'contact_type_label' => $contact->contact_type_label,
                'notes' => $contact->notes,
                'created_at' => $contact->created_at->toIso8601String(),
                'created_at_human' => $contact->created_at->format('M j, Y g:i A'),
                'user_name' => $contact->user
                    ? ($contact->user->full_name ?: $contact->user->email)
                    : null,
            ],
        ], 201);
    }

    /**
     * Update a prospective contact (JSON for AJAX).
     */
    public function update(Request $request, Lead $lead, ProspectiveContact $prospective_contact): JsonResponse
    {
        if ((int) $prospective_contact->lead_id !== (int) $lead->id) {
            abort(404);
        }

        $validated = $request->validate([
            'contact_type' => 'required|in:email,phone_call,facebook,in_person_flyer,sms_message,other',
            'notes' => 'nullable|string|max:65535',
        ]);

        $prospective_contact->update($validated);

        return response()->json([
            'contact' => [
                'id' => $prospective_contact->id,
                'contact_type' => $prospective_contact->contact_type,
                'contact_type_label' => $prospective_contact->contact_type_label,
                'notes' => $prospective_contact->notes,
                'created_at' => $prospective_contact->created_at->toIso8601String(),
                'created_at_human' => $prospective_contact->created_at->format('M j, Y g:i A'),
                'user_name' => $prospective_contact->user
                    ? ($prospective_contact->user->full_name ?: $prospective_contact->user->email)
                    : null,
            ],
        ]);
    }

    /**
     * Delete a prospective contact (JSON for AJAX).
     */
    public function destroy(Lead $lead, ProspectiveContact $prospective_contact): JsonResponse
    {
        if ((int) $prospective_contact->lead_id !== (int) $lead->id) {
            abort(404);
        }

        $prospective_contact->delete();

        return response()->json(['deleted' => true]);
    }
}
