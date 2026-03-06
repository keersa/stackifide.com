<x-super-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <span>{{ __('Leads Management') }}</span>
            <a href="{{ route('super-admin.leads.map') }}"
               title="Map view"
               class="inline-flex items-center justify-center w-9 h-9 rounded-md text-purple-600 hover:text-purple-800 hover:bg-purple-50 dark:text-purple-400 dark:hover:text-purple-300 dark:hover:bg-purple-900/20"
               aria-label="Map view">
                <svg class="w-5 h-5 ml-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                </svg>
            </a>
        </div>
    </x-slot>

    <div class="space-y-4">
        <!-- Filters (same as index) -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <form method="GET" action="{{ route('super-admin.leads.map') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Search</label>
                        <input type="text"
                               name="search"
                               id="search"
                               value="{{ request('search') }}"
                               placeholder="Name, email, phone..."
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                        <select name="status"
                                id="status"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">All Statuses</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                                    {{ $status === 'has_website' ? 'Has Website' : ucfirst(str_replace('_', ' ', $status)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="source" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Source</label>
                        <select name="source"
                                id="source"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">All Sources</option>
                            @foreach($sources as $source)
                                <option value="{{ $source }}" {{ request('source') === $source ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $source)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit"
                                class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                            Filter
                        </button>
                        <a href="{{ route('super-admin.leads.map') }}"
                           class="bg-gray-300 hover:bg-gray-400 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-800 dark:text-gray-200 font-bold py-2 px-4 rounded">
                            Clear
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Legend + status -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4">
            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Status</h3>
            <div class="flex flex-wrap gap-x-4 gap-y-1 text-sm text-gray-600 dark:text-gray-400">
                <span class="inline-flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-blue-500"></span> New</span>
                <span class="inline-flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-yellow-500"></span> Contacted</span>
                <span class="inline-flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-green-500"></span> Qualified</span>
                <span class="inline-flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-cyan-500"></span> Has Website</span>
                <span class="inline-flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-indigo-500"></span> Proposal</span>
                <span class="inline-flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-orange-500"></span> Negotiation</span>
                <span class="inline-flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-purple-500"></span> Won</span>
                <span class="inline-flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-red-500"></span> Lost</span>
            </div>
            <p id="map-status" class="mt-2 text-xs text-gray-500 dark:text-gray-400">Loading map…</p>
            <p id="map-save-errors" class="mt-1 text-xs text-red-600 dark:text-red-400 hidden" role="alert"></p>
        </div>

        <!-- Map -->
        <div id="map" class="w-full rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm" style="height: 600px;"></div>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        (function() {
            var leads = @json($leads);
            var coordinatesPath = '/super-admin/leads';
            var csrfToken = @json(csrf_token());
            var statusColors = {
                'new': '#3b82f6',
                'contacted': '#eab308',
                'qualified': '#22c55e',
                'has_website': '#06b6d4',
                'proposal': '#6366f1',
                'negotiation': '#f97316',
                'won': '#a855f7',
                'lost': '#ef4444'
            };
            var statusLabel = function(s) {
                return s === 'has_website' ? 'Has Website' : (s ? s.charAt(0).toUpperCase() + s.slice(1) : '');
            };

            var map = L.map('map').setView([39.5, -98], 2);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            var bounds = null;
            var markers = [];
            var processed = 0;
            var saveFailures = 0;
            var lastSaveError = '';

            function updateStatus(text) {
                var el = document.getElementById('map-status');
                if (el) el.textContent = text;
            }

            function showSaveError(msg) {
                var el = document.getElementById('map-save-errors');
                if (el) {
                    el.textContent = msg;
                    el.classList.remove('hidden');
                }
            }

            function buildQuery(lead) {
                var parts = [];
                if (lead.street_address) parts.push(lead.street_address);
                if (lead.city) parts.push(lead.city);
                if (lead.state) parts.push(lead.state);
                parts.push('USA');
                return parts.join(', ');
            }

            function addMarker(lead, lat, lng) {
                var color = statusColors[lead.status] || '#6b7280';
                var marker = L.circleMarker([lat, lng], {
                    radius: 10,
                    fillColor: color,
                    color: '#fff',
                    weight: 1.5,
                    opacity: 1,
                    fillOpacity: 0.9
                });
                var content = '<div class="min-w-0 max-w-xs">' +
                    '<p class="font-semibold text-gray-900">' + (lead.restaurant_name || 'Lead') + '</p>' +
                    '<p class="text-sm text-gray-600">' + statusLabel(lead.status) + '</p>' +
                    (lead.city || lead.state ? '<p class="text-xs text-gray-500">' + [lead.city, lead.state].filter(Boolean).join(', ') + '</p>' : '') +
                    '<a href="' + lead.show_url + '" class="inline-block mt-1 text-sm text-purple-600 hover:underline">View lead →</a>' +
                    '</div>';
                marker.bindPopup(content);
                marker.addTo(map);
                markers.push(marker);
                if (!bounds) bounds = L.latLngBounds([lat, lng], [lat, lng]);
                else bounds.extend([lat, lng]);
            }

            function saveCoordinates(leadId, lat, lon) {
                var url = coordinatesPath + '/' + leadId + '/coordinates';
                var payload = { latitude: Number(lat), longitude: Number(lon) };
                return fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken || ''
                    },
                    body: JSON.stringify(payload),
                    credentials: 'same-origin'
                }).then(function(r) {
                    if (!r.ok) {
                        saveFailures++;
                        lastSaveError = r.status + ' ' + r.statusText;
                        r.text().then(function(t) {
                            try {
                                var j = JSON.parse(t);
                                if (j.message) lastSaveError = j.message;
                                if (j.errors) lastSaveError = JSON.stringify(j.errors);
                            } catch (e) {
                                if (t.length < 200) lastSaveError = t; else lastSaveError = r.status + ' (see console)';
                            }
                            console.warn('Coordinates save failed for lead ' + leadId + ':', r.status, lastSaveError, t.substring(0, 500));
                            showSaveError(saveFailures + ' coordinate save(s) failed. ' + lastSaveError);
                        });
                    }
                    return r;
                });
            }

            function geocodeOne(lead, index) {
                var query = buildQuery(lead);
                if (!query || query === ', USA') {
                    processed++;
                    if (processed === leads.length && bounds) map.fitBounds(bounds, { padding: [30, 30] });
                    updateStatus(processed + ' / ' + leads.length + ' leads plotted.');
                    return Promise.resolve();
                }
                return fetch('https://nominatim.openstreetmap.org/search?q=' + encodeURIComponent(query) + '&format=json&limit=1', {
                    headers: {
                        'Accept': 'application/json',
                        'User-Agent': 'StackifideLeadsMap/1.0'
                    }
                })
                    .then(function(r) { return r.json(); })
                    .then(function(results) {
                        if (results && results[0]) {
                            var lat = parseFloat(results[0].lat);
                            var lon = parseFloat(results[0].lon);
                            addMarker(lead, lat, lon);
                            saveCoordinates(lead.id, lat, lon);
                        }
                        processed++;
                        updateStatus(processed + ' / ' + leads.length + ' leads plotted.');
                        if (processed === leads.length && bounds) map.fitBounds(bounds, { padding: [30, 30] });
                    })
                    .catch(function() {
                        processed++;
                        if (processed === leads.length && bounds) map.fitBounds(bounds, { padding: [30, 30] });
                        updateStatus(processed + ' / ' + leads.length + ' leads plotted.');
                    });
            }

            function runMap() {
                var withCoords = leads.filter(function(l) { return l.latitude != null && l.longitude != null; });
                var needGeocode = leads.filter(function(l) { return !(l.latitude != null && l.longitude != null); });

                if (leads.length === 0) {
                    updateStatus('No leads to plot.');
                    return;
                }

                withCoords.forEach(function(lead) {
                    addMarker(lead, lead.latitude, lead.longitude);
                });
                var plotted = withCoords.length;
                if (plotted === leads.length) {
                    updateStatus(plotted + ' leads plotted (from saved coordinates).');
                    if (bounds) map.fitBounds(bounds, { padding: [30, 30] });
                    return;
                }

                updateStatus(plotted + ' plotted from saved coordinates. Geocoding ' + needGeocode.length + ' more…');
                if (bounds) map.fitBounds(bounds, { padding: [30, 30] });

                processed = plotted;
                var delay = 0;
                needGeocode.forEach(function(lead, i) {
                    setTimeout(function() {
                        geocodeOne(lead, i);
                    }, delay);
                    delay += 1100;
                });
            }

            runMap();
        })();
    </script>
</x-super-admin-layout>
