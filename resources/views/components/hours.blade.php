{{-- Hours in Polish notation, e.g. "7,5 h". --}}
@props(['value'])
{{ number_format((float) $value, 1, ',', ' ') }} h
