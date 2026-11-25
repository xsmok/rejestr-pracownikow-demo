<x-layout title="Użytkownicy">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div class="min-w-0">
            <h1 class="text-xl font-semibold text-balance">Użytkownicy</h1>
            <p class="mt-1 text-sm text-slate-500">Wszystkie konta w systemie.</p>
        </div>
        <x-button :href="route('admin.users.create')">Dodaj użytkownika</x-button>
    </div>

    <div class="mt-6 overflow-x-auto rounded-md border border-slate-200 bg-white">
        <table class="w-full text-sm">
            <thead class="border-b border-slate-200">
                <tr>
                    <th scope="col" class="px-4 py-2.5 text-left text-xs font-semibold tracking-wide text-slate-500 uppercase">Imię i nazwisko</th>
                    <th scope="col" class="px-4 py-2.5 text-left text-xs font-semibold tracking-wide text-slate-500 uppercase">E-mail</th>
                    <th scope="col" class="px-4 py-2.5 text-left text-xs font-semibold tracking-wide text-slate-500 uppercase">Rola</th>
                    <th scope="col" class="px-4 py-2.5 text-left text-xs font-semibold tracking-wide text-slate-500 uppercase">Konto</th>
                    <th scope="col" class="px-4 py-2.5"><span class="sr-only">Akcje</span></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @foreach ($users as $user)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 font-medium">{{ $user->name }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $user->email }}</td>
                        <td class="px-4 py-3"><x-role-badge :role="$user->role" /></td>
                        <td class="px-4 py-3">
                            @if ($user->hasVerifiedEmail())
                                <span class="inline-flex items-center gap-1.5 text-green-700"><span class="size-2 rounded-full bg-green-600"></span>aktywne</span>
                            @else
                                <span class="inline-flex items-center gap-1.5 text-amber-700"><span class="size-2 rounded-full bg-amber-500"></span>czeka na aktywację</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right whitespace-nowrap">
                            <a href="{{ route('admin.users.show', $user) }}" class="font-medium text-indigo-700 hover:underline">Podgląd</a>
                            <span class="mx-1.5 text-slate-300">·</span>
                            <a href="{{ route('admin.users.edit', $user) }}" class="font-medium text-indigo-700 hover:underline">Edytuj</a>
                            <span class="mx-1.5 text-slate-300">·</span>
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="cursor-pointer font-medium text-red-700 hover:underline">Usuń</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layout>
