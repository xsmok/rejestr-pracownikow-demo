@props(['title'])

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} · {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900 antialiased">
    <div class="flex min-h-screen items-center justify-center p-6">
        <div class="w-full max-w-sm rounded-md border border-slate-200 bg-white p-8 shadow-sm">
            <p class="text-xs font-semibold tracking-wider text-indigo-700 uppercase">Firma XYZ</p>
            {{ $slot }}
        </div>
    </div>
</body>
</html>
