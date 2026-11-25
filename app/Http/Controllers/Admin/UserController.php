<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * List all accounts.
     */
    public function index(): View
    {
        return view('admin.users.index', ['users' => User::query()->orderBy('name')->get()]);
    }

    /**
     * Show the form for a new account.
     */
    public function create(): View
    {
        return view('admin.users.create', ['user' => new User]);
    }

    /**
     * Create an account; it still has to be activated from the e-mail.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            // Letters (any alphabet), spaces and hyphens only.
            'name' => ['required', 'string', 'max:255', 'regex:/^[\pL\s\-]+$/u'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            // At least 8 characters, including a letter and a digit.
            'password' => ['required', 'confirmed', 'regex:/^(?=.*\pL)(?=.*\d).{8,}$/u'],
            'role' => ['required', Rule::enum(Role::class)],
        ]);

        $user = User::create($data);

        event(new Registered($user));

        return redirect()->route('admin.users.index');
    }

    /**
     * Show one account.
     */
    public function show(User $user): View
    {
        return view('admin.users.show', ['user' => $user]);
    }

    /**
     * Show the form for changing an account.
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit', ['user' => $user]);
    }

    /**
     * Save the changes; an empty password keeps the current one.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            // Letters (any alphabet), spaces and hyphens only.
            'name' => ['required', 'string', 'max:255', 'regex:/^[\pL\s\-]+$/u'],
            // The edited account may keep its own e-mail.
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user)],
            // At least 8 characters, including a letter and a digit.
            'password' => ['nullable', 'confirmed', 'regex:/^(?=.*\pL)(?=.*\d).{8,}$/u'],
            'role' => ['required', Rule::enum(Role::class)],
        ]);

        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.show', $user);
    }

    /**
     * Delete an account together with its work days.
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('admin.users.index');
    }
}
