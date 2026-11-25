@use('App\Models\Comment')

@php
    $isOwn = $workDay->user->is(auth()->user());
    $month = $workDay->date->format('Y-m');
@endphp

<x-layout :title="'Dzień '.$workDay->date->format('d.m.Y')">
    <p class="text-sm text-slate-500">
        @if ($isOwn)
            <a href="{{ route('my-time', ['month' => $month]) }}" class="font-medium text-indigo-700 hover:underline">Mój czas pracy</a>
        @else
            <a href="{{ route('summary', ['month' => $month]) }}" class="font-medium text-indigo-700 hover:underline">Podsumowanie czasu pracy</a>
            <span aria-hidden="true">/</span>
            <a href="{{ route('employees.work-days.index', ['employee' => $workDay->user, 'month' => $month]) }}" class="font-medium text-indigo-700 hover:underline">{{ $workDay->user->name }}</a>
        @endif
        <span aria-hidden="true">/</span> {{ $workDay->date->format('d.m.Y') }}
    </p>

    <div class="mt-2 flex flex-wrap items-end justify-between gap-4">
        <h1 class="text-xl font-semibold text-balance">{{ ucfirst($workDay->date->translatedFormat('l, j F Y')) }}</h1>

        <div class="flex flex-wrap gap-3">
            @can('update', $workDay)
                <x-button variant="secondary" :href="route('work-days.edit', $workDay)">Edytuj dzień</x-button>
            @endcan
            @can('delete', $workDay)
                <form method="POST" action="{{ route('work-days.destroy', $workDay) }}">
                    @csrf
                    @method('DELETE')
                    <x-button variant="danger">Usuń dzień</x-button>
                </form>
            @endcan
        </div>
    </div>

    <dl class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-md border border-slate-200 bg-white p-4">
            <dt class="text-sm text-slate-500">Pracownik</dt>
            <dd class="mt-1 text-sm font-medium">{{ $workDay->user->name }}</dd>
        </div>
        <div class="rounded-md border border-slate-200 bg-white p-4">
            <dt class="text-sm text-slate-500">Godziny</dt>
            <dd class="mt-1 text-2xl font-semibold tabular-nums"><x-hours :value="$workDay->hours" /></dd>
        </div>
        <div class="rounded-md border border-slate-200 bg-white p-4">
            <dt class="text-sm text-slate-500">Wpisał lub zmienił</dt>
            @if ($workDay->updatedBy)
                <dd class="mt-1 text-sm font-medium">{{ $workDay->updatedBy->name }}</dd>
                <dd class="text-sm text-slate-500">{{ $workDay->updatedBy->role->label() }}</dd>
            @else
                <dd class="mt-1 text-sm text-slate-400 italic">konto usunięte</dd>
            @endif
        </div>
        <div class="rounded-md border border-slate-200 bg-white p-4">
            <dt class="text-sm text-slate-500">Ostatnia zmiana</dt>
            <dd class="mt-1 text-sm font-medium tabular-nums">{{ $workDay->updated_at->format('d.m.Y, H:i') }}</dd>
        </div>
    </dl>

    <section class="mt-8 max-w-3xl">
        <h2 class="text-base font-semibold">
            Komentarze <span class="text-slate-400">({{ $workDay->comments->count() }})</span>
        </h2>

        <ul class="mt-2 divide-y divide-slate-200 border-y border-slate-200">
            @forelse ($workDay->comments as $comment)
                <li class="py-4">
                    <div class="flex flex-wrap items-center gap-2 text-sm">
                        @if ($comment->author)
                            <span class="font-medium">{{ $comment->author->name }}</span>
                            <x-role-badge :role="$comment->author->role" />
                        @else
                            <span class="text-slate-400 italic">konto usunięte</span>
                        @endif
                        <span class="text-slate-400 tabular-nums">{{ $comment->created_at->format('d.m.Y, H:i') }}</span>
                        @if ($comment->updated_at->ne($comment->created_at))
                            <span class="text-slate-400">(edytowany)</span>
                        @endif
                    </div>

                    <p class="mt-1 text-sm whitespace-pre-line text-slate-800">{{ $comment->content }}</p>

                    <div class="mt-2 flex gap-3 text-sm">
                        @can('update', $comment)
                            <a href="{{ route('comments.edit', $comment) }}" class="font-medium text-indigo-700 hover:underline">Edytuj</a>
                        @endcan
                        @can('delete', $comment)
                            <form method="POST" action="{{ route('comments.destroy', $comment) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="cursor-pointer font-medium text-red-700 hover:underline">Usuń</button>
                            </form>
                        @endcan
                    </div>
                </li>
            @empty
                <li class="py-4 text-sm text-slate-500">Do tego dnia nie ma jeszcze komentarzy.</li>
            @endforelse
        </ul>

        @can('create', [Comment::class, $workDay])
            <form method="POST" action="{{ route('work-days.comments.store', $workDay) }}" class="mt-6 grid gap-4" novalidate>
                @csrf
                <x-input name="content" label="Nowy komentarz" type="textarea" />
                <div>
                    <x-button>Dodaj komentarz</x-button>
                </div>
            </form>
        @endcan
    </section>
</x-layout>
