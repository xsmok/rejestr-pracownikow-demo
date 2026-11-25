<x-layout title="Podsumowanie czasu pracy">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div class="min-w-0">
            <h1 class="text-xl font-semibold text-balance">Podsumowanie czasu pracy</h1>
            <p class="mt-1 text-sm text-slate-500">
                Pracownicy z liczbą przepracowanych dni i sumą godzin: {{ $month->translatedFormat('F Y') }}.
            </p>
        </div>

        <form method="GET" class="flex items-end gap-2" novalidate>
            <x-input name="month" label="Miesiąc" type="month" :value="$month->format('Y-m')" class="w-44" />
            <x-button variant="secondary">Pokaż</x-button>
        </form>
    </div>

    <div class="mt-6 overflow-x-auto rounded-md border border-slate-200 bg-white">
        <table class="w-full text-sm">
            <thead class="border-b border-slate-200">
                <tr>
                    <th scope="col" class="px-4 py-2.5 text-left text-xs font-semibold tracking-wide text-slate-500 uppercase">Pracownik</th>
                    <th scope="col" class="px-4 py-2.5 text-right text-xs font-semibold tracking-wide text-slate-500 uppercase">Liczba dni</th>
                    <th scope="col" class="px-4 py-2.5 text-right text-xs font-semibold tracking-wide text-slate-500 uppercase">Suma godzin</th>
                    <th scope="col" class="px-4 py-2.5"><span class="sr-only">Akcje</span></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse ($employees as $employee)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 font-medium">{{ $employee->name }}</td>
                        <td class="px-4 py-3 text-right tabular-nums">{{ $employee->work_days_count }}</td>
                        <td class="px-4 py-3 text-right tabular-nums"><x-hours :value="$employee->work_days_sum_hours ?? 0" /></td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('employees.work-days.index', ['employee' => $employee, 'month' => $month->format('Y-m')]) }}" class="font-medium text-indigo-700 hover:underline">Podgląd</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-slate-500">Nie ma jeszcze żadnego pracownika.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot class="border-t-2 border-slate-300 font-semibold">
                <tr>
                    <td class="px-4 py-3">Razem</td>
                    <td class="px-4 py-3 text-right tabular-nums">{{ $employees->sum('work_days_count') }}</td>
                    <td class="px-4 py-3 text-right tabular-nums"><x-hours :value="$employees->sum('work_days_sum_hours')" /></td>
                    <td class="px-4 py-3"></td>
                </tr>
            </tfoot>
        </table>
    </div>
</x-layout>
