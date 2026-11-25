<x-layout title="Edycja dnia">
    <p class="text-sm text-slate-500">
        <a href="{{ route('work-days.show', $workDay) }}" class="font-medium text-indigo-700 hover:underline">
            {{ $workDay->user->name }}, {{ $workDay->date->format('d.m.Y') }}
        </a>
        <span aria-hidden="true">/</span> Edycja
    </p>

    <h1 class="mt-2 text-xl font-semibold text-balance">Edycja dnia</h1>

    <div class="mt-6 max-w-md rounded-md border border-slate-200 bg-white p-6">
        <form method="POST" action="{{ route('work-days.update', $workDay) }}" class="grid gap-4" novalidate>
            @csrf
            @method('PUT')

            <x-input name="date" label="Data" type="date" :value="$workDay->date->toDateString()" :max="now()->toDateString()" />
            <x-input name="hours" label="Godziny" type="number" :value="$workDay->hours" step="0.5" min="0.5" max="24" />

            <div class="flex flex-wrap gap-3">
                <x-button>Zapisz</x-button>
                <x-button variant="secondary" :href="route('work-days.show', $workDay)">Anuluj</x-button>
            </div>
        </form>
    </div>
</x-layout>
