<x-layout title="Nowy użytkownik">
    <p class="text-sm text-slate-500">
        <a href="{{ route('admin.users.index') }}" class="font-medium text-indigo-700 hover:underline">Użytkownicy</a>
        <span aria-hidden="true">/</span> Nowy użytkownik
    </p>

    <h1 class="mt-2 text-xl font-semibold text-balance">Nowy użytkownik</h1>
    <p class="mt-1 text-sm text-slate-500">Nowe konto trzeba aktywować linkiem, który przyjdzie na podany adres e-mail.</p>

    <div class="mt-6 max-w-3xl rounded-md border border-slate-200 bg-white p-6">
        <form method="POST" action="{{ route('admin.users.store') }}" class="grid gap-4 md:grid-cols-2" novalidate>
            @csrf

            @include('admin.users.form')

            <div class="flex flex-wrap gap-3 md:col-span-2">
                <x-button>Zapisz</x-button>
                <x-button variant="secondary" :href="route('admin.users.index')">Anuluj</x-button>
            </div>
        </form>
    </div>
</x-layout>
