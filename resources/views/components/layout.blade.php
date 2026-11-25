@props(['title'])
@use('App\Enums\Role')

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} · {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900 antialiased">
    <div class="flex min-h-screen flex-col md:flex-row">
        <aside class="flex shrink-0 flex-col border-b border-slate-200 bg-white md:w-64 md:border-r md:border-b-0">
            <div class="px-5 py-5">
                <p class="text-base font-semibold">Rejestr pracowników</p>
                <p class="text-xs text-slate-500">Firma XYZ</p>
            </div>

            <nav class="flex flex-row flex-wrap gap-1 px-3 md:flex-col">
                @if (auth()->user()->hasRole(Role::Employee))
                    <x-nav-link :href="route('my-time')" :active="request()->routeIs('my-time', 'work-days.*', 'comments.*')">
                        Mój czas pracy
                    </x-nav-link>
                @endif

                @if (auth()->user()->hasRole(Role::Supervisor, Role::Admin))
                    <x-nav-link :href="route('summary')" :active="request()->routeIs('summary', 'employees.*', 'work-days.*', 'comments.*')">
                        Podsumowanie czasu pracy
                    </x-nav-link>
                @endif

                @if (auth()->user()->hasRole(Role::Admin))
                    <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                        Użytkownicy
                    </x-nav-link>
                @endif
            </nav>

            <div class="mt-auto border-t border-slate-200 px-5 py-4">
                <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                <p class="text-xs text-slate-500">{{ auth()->user()->role->label() }}</p>
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" class="-mx-3 block w-[calc(100%+1.5rem)] cursor-pointer rounded-md px-3 py-2 text-left text-sm text-slate-700 hover:bg-slate-100">
                        Wyloguj
                    </button>
                </form>
            </div>
        </aside>

        <main class="min-w-0 flex-1 p-6 md:p-8">
            {{ $slot }}
        </main>
    </div>
</body>
</html>
