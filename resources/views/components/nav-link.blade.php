@props(['href', 'active' => false])

<a href="{{ $href }}" @class([
    'rounded-md px-3 py-2 text-sm',
    'bg-indigo-50 font-semibold text-indigo-700' => $active,
    'text-slate-700 hover:bg-slate-100' => ! $active,
])>{{ $slot }}</a>
