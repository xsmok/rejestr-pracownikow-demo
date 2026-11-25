{{-- Fields shared by the create and edit forms. --}}
@use('App\Enums\Role')

<x-input name="name" label="Imię i nazwisko" :value="$user->name" autocomplete="off" />
<x-input name="email" label="E-mail" type="email" :value="$user->email" autocomplete="off" />

<x-input name="role" label="Rola" type="select">
    @foreach (Role::cases() as $role)
        <option value="{{ $role->value }}" @selected(old('role', $user->role->value) === $role->value)>{{ $role->label() }}</option>
    @endforeach
</x-input>

<div class="hidden md:block"></div>

<x-input name="password" label="Hasło" type="password" autocomplete="new-password" />
<x-input name="password_confirmation" label="Powtórz hasło" type="password" autocomplete="new-password" />
