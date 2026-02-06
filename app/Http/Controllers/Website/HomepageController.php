<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Website;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HomepageController extends Controller
{
    /**
     * Show the homepage hero settings form.
     */
    public function edit(Website $website): View
    {
        $user = Auth::user();

        if (!$user->isSuperAdmin() && $website->user_id !== $user->id) {
            abort(403, 'You do not have permission to edit this website.');
        }

        return view('admin.websites.homepage.edit', [
            'website' => $website,
        ]);
    }

    /**
     * Update the homepage hero settings.
     */
    public function update(Request $request, Website $website): RedirectResponse
    {
        $user = Auth::user();

        if (!$user->isSuperAdmin() && $website->user_id !== $user->id) {
            abort(403, 'You do not have permission to update this website.');
        }

        $validated = $request->validate([
            'tagline' => ['nullable', 'string', 'max:255'],
            'show_logo_in_hero' => ['nullable', 'boolean'],
            'hero_title' => ['nullable', 'string', 'max:255'],
            'color_settings.hero_background' => ['nullable', 'array'],
            'color_settings.hero_background.enabled' => ['nullable', 'boolean'],
            'color_settings.hero_background.light' => ['nullable', 'string', 'max:20', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'color_settings.hero_background.dark' => ['nullable', 'string', 'max:20', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'color_settings.hero_heading' => ['nullable', 'array'],
            'color_settings.hero_heading.enabled' => ['nullable', 'boolean'],
            'color_settings.hero_heading.light' => ['nullable', 'string', 'max:20', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'color_settings.hero_heading.dark' => ['nullable', 'string', 'max:20', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'color_settings.hero_text' => ['nullable', 'array'],
            'color_settings.hero_text.enabled' => ['nullable', 'boolean'],
            'color_settings.hero_text.light' => ['nullable', 'string', 'max:20', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'color_settings.hero_text.dark' => ['nullable', 'string', 'max:20', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ]);

        $main = [
            'tagline' => $validated['tagline'] ?? null,
            'show_logo_in_hero' => $request->boolean('show_logo_in_hero'),
            'hero_title' => $validated['hero_title'] ?? null,
        ];

        $defaultLight = '#ffffff';
        $defaultDark = '#1e293b';
        $colorSettings = $website->color_settings ?? [];

        foreach (['hero_background', 'hero_heading', 'hero_text'] as $key) {
            $raw = $request->input("color_settings.{$key}", []);
            $enabled = !empty($raw['enabled']);
            $light = $raw['light'] ?? $raw['color'] ?? ($colorSettings[$key]['light'] ?? $defaultLight);
            $dark = $raw['dark'] ?? $raw['color'] ?? ($colorSettings[$key]['dark'] ?? $defaultDark);
            $colorSettings[$key] = [
                'enabled' => $enabled,
                'light' => preg_match('/^#[0-9A-Fa-f]{6}$/', $light) ? $light : $defaultLight,
                'dark' => preg_match('/^#[0-9A-Fa-f]{6}$/', $dark) ? $dark : $defaultDark,
            ];
        }

        $website->update($main + ['color_settings' => $colorSettings]);

        return redirect()->route('admin.websites.homepage.edit', $website)
            ->with('success', 'Homepage hero settings updated successfully.');
    }
}
