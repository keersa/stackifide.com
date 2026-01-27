<x-admin-layout>
    <x-admin-website-header :website="$website" title="Edit Store Hours" />

    <div class="py-4">
        <form method="POST" action="{{ route('admin.websites.hours.update', $website) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Weekly Hours</h3>

                    @php
                        $websiteTimezone = $website->timezone ?: 'America/New_York';
                        $timeOptions = [];
                        for ($h = 0; $h < 24; $h++) {
                            for ($m = 0; $m < 60; $m += 5) {
                                $timeOptions[] = sprintf('%02d:%02d', $h, $m);
                            }
                        }
                        $formatTimeLabel = function (string $hhmm): string {
                            $dt = \DateTime::createFromFormat('H:i', $hhmm, new \DateTimeZone('UTC'));
                            return $dt ? $dt->format('g:i A') : $hhmm;
                        };
                    @endphp

                    <div class="space-y-4">
                        @foreach($days as $dayIndex => $label)
                            @php
                                $row = $hours->get($dayIndex);
                                $isClosed = old("hours.$dayIndex.is_closed", $row ? (bool) $row->is_closed : false) ? true : false;
                                $opens = old("hours.$dayIndex.opens_at", $row && $row->opens_at ? substr((string) $row->opens_at, 0, 5) : '09:00');
                                $closes = old("hours.$dayIndex.closes_at", $row && $row->closes_at ? substr((string) $row->closes_at, 0, 5) : '17:00');
                            @endphp

                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4"
                                 x-data="{ closed: {{ $isClosed ? 'true' : 'false' }} }">
                                <div class="flex items-center justify-between">
                                    <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $label }}
                                    </div>
                                    <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                                        <input type="checkbox"
                                               name="hours[{{ $dayIndex }}][is_closed]"
                                               value="1"
                                               x-model="closed"
                                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                                        Closed
                                    </label>
                                </div>

                                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4" x-show="!closed">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Opens</label>
                                        <select name="hours[{{ $dayIndex }}][opens_at]"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                            <option value="">Select time</option>
                                            @foreach($timeOptions as $t)
                                                <option value="{{ $t }}" {{ $opens === $t ? 'selected' : '' }}>
                                                    {{ $formatTimeLabel($t) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error("hours.$dayIndex.opens_at")
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Closes</label>
                                        <select name="hours[{{ $dayIndex }}][closes_at]"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                            <option value="">Select time</option>
                                            @foreach($timeOptions as $t)
                                                <option value="{{ $t }}" {{ $closes === $t ? 'selected' : '' }}>
                                                    {{ $formatTimeLabel($t) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error("hours.$dayIndex.closes_at")
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4 text-xs text-gray-500 dark:text-gray-400">
                        Timezone: {{ $websiteTimezone }}
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.websites.hours.index', $website) }}"
                   class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                    Cancel
                </a>
                <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    Save Hours
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>

