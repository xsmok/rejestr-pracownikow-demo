{{-- Form field: label, control and its validation error. type="select" takes <option> tags in the slot. --}}
@props(['name', 'label', 'type' => 'text', 'value' => null])

@php
    $controlClasses = 'block w-full rounded-md border bg-white px-3 py-2 text-sm text-slate-900 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-600/20 focus:outline-none '
        .($errors->has($name) ? 'border-red-500' : 'border-slate-300');
@endphp

<div>
    <label for="{{ $name }}" class="mb-1 block text-sm font-medium text-slate-700">{{ $label }}</label>

    @if ($type === 'textarea')
        <textarea id="{{ $name }}" name="{{ $name }}" rows="3" {{ $attributes->class($controlClasses) }}>{{ old($name, $value) }}</textarea>
    @elseif ($type === 'select')
        <select id="{{ $name }}" name="{{ $name }}" {{ $attributes->class($controlClasses) }}>{{ $slot }}</select>
    @else
        <input
            id="{{ $name }}"
            name="{{ $name }}"
            type="{{ $type }}"
            value="{{ $type === 'password' ? '' : old($name, $value) }}"
            {{ $attributes->class($controlClasses) }}
        >
    @endif

    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
