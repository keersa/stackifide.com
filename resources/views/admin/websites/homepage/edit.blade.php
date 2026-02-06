<x-admin-layout>
    @push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/mdbassit/Coloris@latest/dist/coloris.min.css">
    <style>
        .clr-field { display: flex; align-items: center; gap: 0.25rem; }
        .clr-field .clr-preview { flex-shrink: 0; }
        .clr-field input { min-width: 4ch; flex: 1; }
        .dark .clr-field input { color: #e5e7eb; }
        .clr-field button:after { border:1px solid #ccc!important; }
        .dark .clr-field button:after { border:1px solid #000!important; }
    </style>
    @endpush
    <x-admin-website-header :website="$website" title="Homepage Hero" />

    <div class="py-2">
        <div class="px-2 pb-4 flex items-center justify-between">
            <h3 class="font-black text-gray-900 dark:text-white text-2xl tracking-tighter">{{ __('Homepage Settings') }}</h3>
        </div>
        <form method="POST" action="{{ route('admin.websites.homepage.update', $website) }}">
            @csrf
            @method('PUT')

            <!-- Hero Content -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Hero Content</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Configure the headline and messaging displayed in the hero section of your homepage.</p>
                    <div class="space-y-6">
                        @php
                            $showLogoInHero = old('show_logo_in_hero', $website->show_logo_in_hero ?? true);
                        @endphp
                        <div class="flex items-center justify-between">
                            <div>
                                <label for="show_logo_in_hero" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Show Logo in Hero</label>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Display your logo instead of the restaurant name in the hero section.</p>
                            </div>
                            <label id="show_logo_in_hero_label" class="relative inline-flex h-7 w-12 shrink-0 cursor-pointer rounded-full border-1 border-transparent transition-colors focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 dark:focus-within:ring-offset-gray-800 {{ $showLogoInHero ? 'bg-indigo-600' : 'bg-gray-200 dark:bg-gray-600' }}">
                                <input type="hidden" name="show_logo_in_hero" value="0">
                                <input type="checkbox"
                                       name="show_logo_in_hero"
                                       id="show_logo_in_hero"
                                       value="1"
                                       {{ $showLogoInHero ? 'checked' : '' }}
                                       class="sr-only peer">
                                <span class="pointer-events-none absolute left-1 top-1 inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition-transform peer-checked:translate-x-5"></span>
                            </label>
                        </div>
                        <div>
                            <label for="hero_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Hero Title</label>
                            <input type="text"
                                   name="hero_title"
                                   id="hero_title"
                                   value="{{ old('hero_title', $website->hero_title) }}"
                                   placeholder="{{ $website->name }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Leave blank to use the restaurant name. Ignored when logo is shown.</p>
                            @error('hero_title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="tagline" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tagline / Subtitle</label>
                            <input type="text"
                                   name="tagline"
                                   id="tagline"
                                   value="{{ old('tagline', $website->tagline) }}"
                                   placeholder="A short, catchy phrase that describes your restaurant"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Displayed below the title or logo in the hero section.</p>
                            @error('tagline')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hero Colors -->
            @php
                $colorSettings = old('color_settings', $website->color_settings ?? []);
                $heroColorKeys = [
                    'hero_background' => 'Hero Background',
                    'hero_heading' => 'Hero Heading / Title',
                    'hero_text' => 'Hero Text / Tagline',
                ];
                $defaultLight = '#ffffff';
                $defaultDark = '#1e293b';
            @endphp
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Hero Color Overrides</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Override default theme colors for the hero section. Enable each setting and choose colors for Light Mode and Dark Mode.</p>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th class="text-left py-3 pr-4 text-sm font-medium text-gray-700 dark:text-gray-300 w-20"></th>
                                    <th class="text-left py-3 pr-4 text-sm font-medium text-gray-700 dark:text-gray-300">Setting</th>
                                    <th class="text-left py-3 pr-4 text-sm font-medium text-gray-700 dark:text-gray-300">Light Mode</th>
                                    <th class="text-left py-3 text-sm font-medium text-gray-700 dark:text-gray-300">Dark Mode</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($heroColorKeys as $key => $label)
                                    @php
                                        $setting = $colorSettings[$key] ?? [];
                                        $enabled = old("color_settings.{$key}.enabled", $setting['enabled'] ?? false);
                                        $light = old("color_settings.{$key}.light", $setting['light'] ?? $setting['color'] ?? $defaultLight);
                                        $dark = old("color_settings.{$key}.dark", $setting['dark'] ?? $setting['color'] ?? $defaultDark);
                                    @endphp
                                    <tr>
                                        <td class="py-3 px-2 align-top">
                                            <label class="relative inline-flex h-7 w-12 shrink-0 cursor-pointer rounded-full border-1 border-transparent transition-colors focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 dark:focus-within:ring-offset-gray-800 {{ $enabled ? 'bg-indigo-600' : 'bg-gray-200 dark:bg-gray-600' }}">
                                                <input type="hidden" name="color_settings[{{ $key }}][enabled]" value="0">
                                                <input type="checkbox"
                                                       name="color_settings[{{ $key }}][enabled]"
                                                       value="1"
                                                       {{ $enabled ? 'checked' : '' }}
                                                       data-color-key="{{ $key }}"
                                                       class="color-enable-toggle sr-only peer">
                                                <span class="pointer-events-none absolute left-1 top-1 inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition-transform peer-checked:translate-x-5"></span>
                                            </label>
                                        </td>
                                        <td class="py-3 pr-4 align-top">
                                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $label }}</span>
                                        </td>
                                        <td class="py-3 pr-4 align-top">
                                            <input type="text"
                                                   name="color_settings[{{ $key }}][light]"
                                                   value="{{ $light }}"
                                                   data-coloris
                                                   class="color-picker-light w-24 rounded border border-gray-300 dark:border-blue-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 disabled:opacity-50 disabled:cursor-not-allowed px-1.5 py-1.5 text-sm font-mono"
                                                   {{ $enabled ? '' : 'disabled' }}
                                                   data-color-key="{{ $key }}">
                                        </td>
                                        <td class="py-3 align-top">
                                            <input type="text"
                                                   name="color_settings[{{ $key }}][dark]"
                                                   value="{{ $dark }}"
                                                   data-coloris
                                                   class="color-picker-dark w-24 rounded border border-gray-300 dark:border-blue-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 disabled:opacity-50 disabled:cursor-not-allowed px-1.5 py-1.5 text-sm font-mono"
                                                   {{ $enabled ? '' : 'disabled' }}
                                                   data-color-key="{{ $key }}">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Save Hero Settings') }}
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/gh/mdbassit/Coloris@latest/dist/coloris.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof Coloris !== 'undefined') {
            Coloris({ format: 'hex', formatToggle: false });
        }
        const showLogoCheckbox = document.getElementById('show_logo_in_hero');
        const showLogoLabel = document.getElementById('show_logo_in_hero_label');
        if (showLogoCheckbox && showLogoLabel) {
            showLogoCheckbox.addEventListener('change', function() {
                showLogoLabel.classList.toggle('bg-indigo-600', this.checked);
                showLogoLabel.classList.toggle('bg-gray-200', !this.checked);
                showLogoLabel.classList.toggle('dark:bg-gray-600', !this.checked);
            });
        }
        document.querySelectorAll('.color-enable-toggle').forEach(function(checkbox) {
            const key = checkbox.dataset.colorKey;
            const label = checkbox.closest('label');
            const pickersLight = document.querySelectorAll('.color-picker-light[data-color-key="' + key + '"]');
            const pickersDark = document.querySelectorAll('.color-picker-dark[data-color-key="' + key + '"]');
            function updateState() {
                const enabled = checkbox.checked;
                if (label) {
                    label.classList.toggle('bg-indigo-600', enabled);
                    label.classList.toggle('bg-gray-200', !enabled);
                    label.classList.toggle('dark:bg-gray-600', !enabled);
                }
                pickersLight.forEach(p => p.disabled = !enabled);
                pickersDark.forEach(p => p.disabled = !enabled);
            }
            checkbox.addEventListener('change', updateState);
            updateState();
        });
    });
    </script>
    @endpush
</x-admin-layout>
