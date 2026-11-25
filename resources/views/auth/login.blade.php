<x-guest-layout title="Logowanie">
    <h1 class="mt-1 text-xl font-semibold text-balance">Rejestr pracowników</h1>
    <p class="mt-1 text-sm text-slate-500">Zaloguj się, żeby zobaczyć swój czas pracy.</p>

    <form method="POST" action="{{ route('login') }}" class="mt-6 grid gap-4" novalidate>
        @csrf

        <x-input name="email" label="E-mail" type="email" autocomplete="email" autofocus />
        <x-input name="password" label="Hasło" type="password" autocomplete="current-password" />

        <label for="remember" class="flex items-center gap-2 text-sm text-slate-700">
            <input id="remember" name="remember" type="checkbox" class="size-4 accent-indigo-600">
            Zapamiętaj mnie
        </label>

        <x-button class="w-full">Zaloguj się</x-button>
    </form>

    <p class="mt-6 text-sm text-slate-600">
        Nie masz konta?
        <a href="{{ route('register') }}" class="font-medium text-indigo-700 hover:underline">Zarejestruj się</a>
    </p>
</x-guest-layout>
