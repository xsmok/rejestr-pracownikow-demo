{{-- A submit button, or a link styled as a button when href is given. --}}
@props(['variant' => 'primary', 'href' => null])

@php
    $buttonClasses = 'inline-flex cursor-pointer items-center justify-center gap-2 rounded-md px-4 py-2 text-sm font-medium transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 '
        .match ($variant) {
            'secondary' => 'border border-slate-300 bg-white text-slate-700 hover:bg-slate-50',
            'danger' => 'bg-red-600 text-white hover:bg-red-700',
            default => 'bg-indigo-600 text-white hover:bg-indigo-700',
        };
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->class($buttonClasses) }}>{{ $slot }}</a>
@else
    <button {{ $attributes->merge(['type' => 'submit'])->class($buttonClasses) }}>{{ $slot }}</button>
@endif
