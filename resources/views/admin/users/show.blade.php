@use('App\Enums\Role')

<x-layout :title="$user->name">
    <p class="text-sm text-slate-500">
        <a href="{{ route('admin.users.index') }}" class="font-medium text-indigo-700 hover:underline">Użytkownicy</a>
        <span aria-hidden="true">/</span> {{ $user->name }}
    </p>

    <div class="mt-2 flex flex-wrap items-end justify-between gap-4">
        <h1 class="text-xl font-semibold text-balance">{{ $user->name }}</h1>

        <div class="flex flex-wrap gap-3">
            @if ($user->hasRole(Role::Employee))
                <x-button variant="secondary" :href="route('employees.work-days.index', $user)">Czas pracy</x-button>
            @endif
            <x-button variant="secondary" :href="route('admin.users.edit', $user)">Edytuj</x-button>
            <form method="POST" action="{{ route('admin.users.destroy', $user) }}">
                @csrf
                @method('DELETE')
                <x-button variant="danger">Usuń</x-button>
            </form>
        </div>
    </div>

    <dl class="mt-6 grid max-w-3xl gap-4 sm:grid-cols-2">
        <div class="rounded-md border border-slate-200 bg-white p-4">
            <dt class="text-sm text-slate-500">E-mail</dt>
            <dd class="mt-1 text-sm font-medium break-all">{{ $user->email }}</dd>
        </div>
        <div class="rounded-md border border-slate-200 bg-white p-4">
            <dt class="text-sm text-slate-500">Rola</dt>
            <dd class="mt-1"><x-role-badge :role="$user->role" /></dd>
        </div>
        <div class="rounded-md border border-slate-200 bg-white p-4">
            <dt class="text-sm text-slate-500">Konto</dt>
            <dd class="mt-1 text-sm font-medium">
                @if ($user->hasVerifiedEmail())
                    aktywne od {{ $user->email_verified_at->format('d.m.Y') }}
                @else
                    czeka na aktywację
                @endif
            </dd>
        </div>
        <div class="rounded-md border border-slate-200 bg-white p-4">
            <dt class="text-sm text-slate-500">Utworzone</dt>
            <dd class="mt-1 text-sm font-medium tabular-nums">{{ $user->created_at->format('d.m.Y, H:i') }}</dd>
        </div>
    </dl>
</x-layout>
