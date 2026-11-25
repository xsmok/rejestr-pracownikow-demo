{{-- Shared by "Mój czas pracy" (own days) and the supervisor's view of one employee. --}}
@use('App\Models\WorkDay')

@php
    $isOwn = $employee->is(auth()->user());
    $canAdd = auth()->user()->can('create', WorkDay::class);
@endphp

<x-layout :title="$isOwn ? 'Mój czas pracy' : $employee->name">
    @unless ($isOwn)
        <p class="text-sm text-slate-500">
            <a href="{{ route('summary', ['month' => $month->format('Y-m')]) }}" class="font-medium text-indigo-700 hover:underline">Podsumowanie czasu pracy</a>
            <span aria-hidden="true">/</span> {{ $employee->name }}
        </p>
    @endunless

    <div class="mt-2 flex flex-wrap items-end justify-between gap-4">
        <div class="min-w-0">
            <h1 class="text-xl font-semibold text-balance">{{ $isOwn ? 'Mój czas pracy' : $employee->name }}</h1>
            <p class="mt-1 text-sm text-slate-500">
                {{ ucfirst($month->translatedFormat('F Y')) }} · liczba dni: {{ $workDays->count() }} · suma godzin: <x-hours :value="$workDays->sum('hours')" />
            </p>
        </div>

        <form method="GET" class="flex items-end gap-2" novalidate>
            <x-input name="month" label="Miesiąc" type="month" :value="$month->format('Y-m')" class="w-44" />
            <x-button variant="secondary">Pokaż</x-button>
        </form>
    </div>

    <div @class(['mt-6 grid gap-6', 'xl:grid-cols-[minmax(0,1fr)_20rem]' => $canAdd])>
        <div class="min-w-0 overflow-x-auto rounded-md border border-slate-200 bg-white">
            <table class="w-full text-sm">
                <thead class="border-b border-slate-200">
                    <tr>
                        <th scope="col" class="px-4 py-2.5 text-left text-xs font-semibold tracking-wide text-slate-500 uppercase">Data</th>
                        <th scope="col" class="px-4 py-2.5 text-left text-xs font-semibold tracking-wide text-slate-500 uppercase">Dzień</th>
                        <th scope="col" class="px-4 py-2.5 text-right text-xs font-semibold tracking-wide text-slate-500 uppercase">Godziny</th>
                        <th scope="col" class="px-4 py-2.5 text-right text-xs font-semibold tracking-wide text-slate-500 uppercase">Komentarze</th>
                        <th scope="col" class="px-4 py-2.5 text-left text-xs font-semibold tracking-wide text-slate-500 uppercase">Zmienił</th>
                        <th scope="col" class="px-4 py-2.5"><span class="sr-only">Akcje</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse ($workDays as $workDay)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 tabular-nums">{{ $workDay->date->format('d.m.Y') }}</td>
                            <td class="px-4 py-3 text-slate-500">{{ $workDay->date->translatedFormat('D') }}</td>
                            <td class="px-4 py-3 text-right tabular-nums"><x-hours :value="$workDay->hours" /></td>
                            <td class="px-4 py-3 text-right tabular-nums">{{ $workDay->comments_count ?: '—' }}</td>
                            <td class="px-4 py-3">
                                @if ($workDay->updatedBy)
                                    {{ $workDay->updatedBy->name }}
                                @else
                                    <span class="text-slate-400 italic">konto usunięte</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                <a href="{{ route('work-days.show', $workDay) }}" class="font-medium text-indigo-700 hover:underline">Podgląd</a>
                                @can('update', $workDay)
                                    <span class="mx-1.5 text-slate-300">·</span>
                                    <a href="{{ route('work-days.edit', $workDay) }}" class="font-medium text-indigo-700 hover:underline">Edytuj</a>
                                @endcan
                                @can('delete', $workDay)
                                    <span class="mx-1.5 text-slate-300">·</span>
                                    <form method="POST" action="{{ route('work-days.destroy', $workDay) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="cursor-pointer font-medium text-red-700 hover:underline">Usuń</button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-slate-500">W tym miesiącu nie ma jeszcze wpisanych dni.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot class="border-t-2 border-slate-300 font-semibold">
                    <tr>
                        <td class="px-4 py-3" colspan="2">Razem</td>
                        <td class="px-4 py-3 text-right tabular-nums"><x-hours :value="$workDays->sum('hours')" /></td>
                        <td class="px-4 py-3" colspan="3"></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        @if ($canAdd)
            <div class="h-fit rounded-md border border-slate-200 bg-white p-5">
                <h2 class="text-base font-semibold">Dodaj dzień</h2>
                <form method="POST" action="{{ route('employees.work-days.store', $employee) }}" class="mt-4 grid gap-4" novalidate>
                    @csrf
                    <x-input name="date" label="Data" type="date" :value="now()->toDateString()" :max="now()->toDateString()" />
                    <x-input name="hours" label="Godziny" type="number" value="8" step="0.5" min="0.5" max="24" />
                    <x-button>Dodaj dzień</x-button>
                </form>
            </div>
        @endif
    </div>
</x-layout>
