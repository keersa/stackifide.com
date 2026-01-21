@props(['website'])

<x-layouts.website-owner>
    <x-slot name="header">
        {{ $header ?? '' }}
    </x-slot>
    {{ $slot }}
</x-layouts.website-owner>
