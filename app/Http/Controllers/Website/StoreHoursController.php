<?php

namespace App\Http\Controllers\Website;

use App\Helpers\WebsiteHelper;
use App\Http\Controllers\Controller;
use App\Models\StoreHour;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class StoreHoursController extends Controller
{
    /**
     * Resolve website parameter to Website model instance.
     */
    private function resolveWebsite($routeWebsite): \App\Models\Website
    {
        if ($routeWebsite instanceof \App\Models\Website) {
            return $routeWebsite;
        }

        return \App\Models\Website::where('id', $routeWebsite)
            ->orWhere('slug', $routeWebsite)
            ->firstOrFail();
    }

    /**
     * Check if user has permission to access this website.
     */
    private function checkWebsiteAccess($website): void
    {
        if ($website && request()->routeIs('admin.websites.*')) {
            $user = Auth::user();
            $websiteModel = $website instanceof \App\Models\Website
                ? $website
                : $this->resolveWebsite($website);

            if (!$user->isSuperAdmin() && $websiteModel->user_id !== $user->id) {
                abort(403, 'You do not have permission to access this website.');
            }
        }
    }

    private function days(): array
    {
        return StoreHour::daysSundayFirst();
    }

    /**
     * Display current hours.
     */
    public function index(Request $request): View
    {
        $routeWebsite = $request->route('website');
        $website = $routeWebsite ? $this->resolveWebsite($routeWebsite) : WebsiteHelper::current();
        $this->checkWebsiteAccess($website);

        $hours = StoreHour::where('website_id', $website->id)
            ->orderBy('day_of_week')
            ->get()
            ->keyBy('day_of_week');

        return view('admin.websites.hours.index', [
            'website' => $website,
            'days' => $this->days(),
            'hours' => $hours,
        ]);
    }

    public function create(Request $request): View
    {
        $routeWebsite = $request->route('website');
        $website = $routeWebsite ? $this->resolveWebsite($routeWebsite) : WebsiteHelper::current();
        $this->checkWebsiteAccess($website);

        $hours = StoreHour::where('website_id', $website->id)
            ->orderBy('day_of_week')
            ->get()
            ->keyBy('day_of_week');

        return view('admin.websites.hours.create', [
            'website' => $website,
            'days' => $this->days(),
            'hours' => $hours,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $routeWebsite = $request->route('website');
        $website = $routeWebsite ? $this->resolveWebsite($routeWebsite) : WebsiteHelper::current();
        $this->checkWebsiteAccess($website);

        $data = $this->validateHoursPayload($request);

        foreach ($this->days() as $dayIndex => $label) {
            $row = $data['hours'][$dayIndex] ?? [];
            $isClosed = (bool) ($row['is_closed'] ?? false);

            StoreHour::updateOrCreate(
                ['website_id' => $website->id, 'day_of_week' => $dayIndex],
                [
                    'is_closed' => $isClosed,
                    'opens_at' => $isClosed ? null : ($row['opens_at'] ?? null),
                    'closes_at' => $isClosed ? null : ($row['closes_at'] ?? null),
                ]
            );
        }

        return redirect()->route('admin.websites.hours.index', $website)
            ->with('success', 'Store hours saved successfully.');
    }

    public function edit(Request $request): View
    {
        $routeWebsite = $request->route('website');
        $website = $routeWebsite ? $this->resolveWebsite($routeWebsite) : WebsiteHelper::current();
        $this->checkWebsiteAccess($website);

        $hours = StoreHour::where('website_id', $website->id)
            ->orderBy('day_of_week')
            ->get()
            ->keyBy('day_of_week');

        return view('admin.websites.hours.edit', [
            'website' => $website,
            'days' => $this->days(),
            'hours' => $hours,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        return $this->store($request);
    }

    private function validateHoursPayload(Request $request): array
    {
        $validated = $request->validate([
            'hours' => ['required', 'array'],
            'hours.*' => ['array'],
            'hours.*.is_closed' => ['nullable'],
            'hours.*.opens_at' => ['nullable', 'date_format:H:i'],
            'hours.*.closes_at' => ['nullable', 'date_format:H:i'],
        ]);

        // Enforce opens/closes when not closed
        $errors = [];
        foreach ($this->days() as $dayIndex => $label) {
            $row = $validated['hours'][$dayIndex] ?? [];
            $isClosed = (bool) ($row['is_closed'] ?? false);
            $opens = $row['opens_at'] ?? null;
            $closes = $row['closes_at'] ?? null;

            if (!$isClosed) {
                if (!$opens) {
                    $errors["hours.$dayIndex.opens_at"] = "Opening time is required for {$label}.";
                }
                if (!$closes) {
                    $errors["hours.$dayIndex.closes_at"] = "Closing time is required for {$label}.";
                }
            }
        }

        if (!empty($errors)) {
            throw ValidationException::withMessages($errors);
        }

        return $validated;
    }
}

