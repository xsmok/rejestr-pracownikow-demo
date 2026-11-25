@props(['role'])
@use('App\Enums\Role')

<span @class([
    'inline-flex rounded-full px-2 py-0.5 text-xs font-medium',
    'bg-indigo-100 text-indigo-800' => $role === Role::Admin,
    'bg-amber-100 text-amber-800' => $role === Role::Supervisor,
    'bg-slate-200 text-slate-700' => $role === Role::Employee,
])>{{ $role->label() }}</span>
