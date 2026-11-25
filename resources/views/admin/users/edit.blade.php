<x-layout title="Edycja użytkownika">
    <p class="text-sm text-slate-500">
        <a href="{{ route('admin.users.index') }}" class="font-medium text-indigo-700 hover:underline">Użytkownicy</a>
        <span aria-hidden="true">/</span>
        <a href="{{ route('admin.users.show', $user) }}" class="font-medium text-indigo-700 hover:underline">{{ $user->name }}</a>
        <span aria-hidden="true">/</span> Edycja
    </p>

    <h1 class="mt-2 text-xl font-semibold text-balance">Edycja użytkownika</h1>
    <p class="mt-1 text-sm text-slate-500">Zostaw pola hasła puste, żeby nie zmieniać hasła.</p>

    <div class="mt-6 max-w-3xl rounded-md border border-slate-200 bg-white p-6">
        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="grid gap-4 md:grid-cols-2" novalidate>
            @csrf
            @method('PUT')

            @include('admin.users.form')

            <div class="flex flex-wrap gap-3 md:col-span-2">
                <x-button>Zapisz</x-button>
                <x-button variant="secondary" :href="route('admin.users.show', $user)">Anuluj</x-button>
            </div>
        </form>
    </div>
</x-layout>
