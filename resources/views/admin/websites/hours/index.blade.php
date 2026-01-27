<x-admin-layout>
    <x-admin-website-header :website="$website" title="Store Hours" />

    <div class="py-4">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="overflow-x-auto">
                @php
                    $formatTimeLabel = function (?string $time): ?string {
                        if (!$time) return null;
                        $hhmm = substr((string) $time, 0, 5);
                        $dt = \DateTime::createFromFormat('H:i', $hhmm, new \DateTimeZone('UTC'));
                        return $dt ? $dt->format('g:i A') : $hhmm;
                    };
                @endphp
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Day</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Hours</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($days as $dayIndex => $label)
                            @php
                                $row = $hours->get($dayIndex);
                                $isClosed = $row ? (bool) $row->is_closed : false;
                                $opens = $row && $row->opens_at ? $formatTimeLabel((string) $row->opens_at) : null;
                                $closes = $row && $row->closes_at ? $formatTimeLabel((string) $row->closes_at) : null;
                            @endphp
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $label }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if(!$row)
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Not set</span>
                                    @elseif($isClosed)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                            Closed
                                        </span>
                                    @else
                                        <span class="text-sm text-gray-900 dark:text-gray-100">
                                            {{ $opens }} – {{ $closes }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                    No days configured yet.
                                    <a href="{{ route('admin.websites.hours.create', $website) }}"
                                       class="ml-2 text-indigo-600 hover:text-indigo-900 dark:text-indigo-400">
                                        Set hours
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-3 text-xs text-gray-500 dark:text-gray-400">
                Timezone: {{ $website->timezone ?: 'America/New_York' }}
            </div>
        </div>
        <div class="flex justify-end space-x-4 mt-4">
            @if($hours->count() > 0)
                <a href="{{ route('admin.websites.hours.edit', $website) }}"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    Edit Hours
                </a>
            @else
                <a href="{{ route('admin.websites.hours.create', $website) }}"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    Set Hours
                </a>
            @endif
        </div>
    </div>
</x-admin-layout>

