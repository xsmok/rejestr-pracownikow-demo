<x-layout title="Edycja komentarza">
    <p class="text-sm text-slate-500">
        <a href="{{ route('work-days.show', $comment->workDay) }}" class="font-medium text-indigo-700 hover:underline">
            {{ $comment->workDay->user->name }}, {{ $comment->workDay->date->format('d.m.Y') }}
        </a>
        <span aria-hidden="true">/</span> Edycja komentarza
    </p>

    <h1 class="mt-2 text-xl font-semibold text-balance">Edycja komentarza</h1>

    <div class="mt-6 max-w-2xl rounded-md border border-slate-200 bg-white p-6">
        <form method="POST" action="{{ route('comments.update', $comment) }}" class="grid gap-4" novalidate>
            @csrf
            @method('PUT')

            <x-input name="content" label="Treść komentarza" type="textarea" :value="$comment->content" />

            <div class="flex flex-wrap gap-3">
                <x-button>Zapisz</x-button>
                <x-button variant="secondary" :href="route('work-days.show', $comment->workDay)">Anuluj</x-button>
            </div>
        </form>
    </div>
</x-layout>
