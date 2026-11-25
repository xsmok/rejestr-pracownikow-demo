<x-guest-layout title="Aktywacja konta">
    <h1 class="mt-1 text-xl font-semibold text-balance">Aktywuj konto</h1>
    <p class="mt-2 text-sm text-slate-600">
        Link aktywacyjny wysłaliśmy na adres <span class="font-medium text-slate-900">{{ auth()->user()->email }}</span>.
        Kliknij go, żeby korzystać z aplikacji.
    </p>

    <form method="POST" action="{{ route('verification.send') }}" class="mt-6">
        @csrf
        <x-button class="w-full">Wyślij link ponownie</x-button>
    </form>

    <form method="POST" action="{{ route('logout') }}" class="mt-3">
        @csrf
        <x-button variant="secondary" class="w-full">Wyloguj</x-button>
    </form>
</x-guest-layout>
