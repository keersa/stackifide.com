<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\ContactFormNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
class ContactController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:5000',
        ]);

        try {
            $superAdmins = User::where('role', User::ROLE_SUPER_ADMIN)->get();
            foreach ($superAdmins as $user) {
                if ($user->email) {
                    $user->notify(new ContactFormNotification(
                        $validated['name'],
                        $validated['email'],
                        $validated['message']
                    ));
                }
            }
        } catch (\Exception $e) {
            Log::error('Contact form email failed: ' . $e->getMessage());
            // Don't fail the request; user still sees success
        }

        return redirect()->route('contact.index')->with('success', 'Contact form submitted successfully');
    }
}
