<x-guest-layout title="Rejestracja">
    <h1 class="mt-1 text-xl font-semibold text-balance">Załóż konto</h1>
    <p class="mt-1 text-sm text-slate-500">Nowe konto ma rolę pracownika. Po rejestracji aktywujesz je linkiem z e-maila.</p>

    <form method="POST" action="{{ route('register') }}" class="mt-6 grid gap-4" novalidate>
        @csrf

        <x-input name="name" label="Imię i nazwisko" autocomplete="name" autofocus />
        <x-input name="email" label="E-mail" type="email" autocomplete="email" />
        <x-input name="password" label="Hasło" type="password" autocomplete="new-password" />
        <x-input name="password_confirmation" label="Powtórz hasło" type="password" autocomplete="new-password" />

        <x-button class="w-full">Załóż konto</x-button>
    </form>

    <p class="mt-6 text-sm text-slate-600">
        Masz już konto?
        <a href="{{ route('login') }}" class="font-medium text-indigo-700 hover:underline">Zaloguj się</a>
    </p>
</x-guest-layout>
