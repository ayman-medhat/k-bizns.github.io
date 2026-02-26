<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    public function index(): View
    {
        $users = User::with('roles')->latest()->paginate(10);

        return view('users.index', compact('users'));
    }

    public function create(): View
    {
        $roles = Role::whereNotIn('name', ['Super Admin'])->get();
        $managers = User::all(); // Scoped by TenantScope

        return view('users.create', compact('roles', 'managers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
            'manager_id' => 'nullable|exists:users,id',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => \Hash::make($validated['password']),
            'manager_id' => $validated['manager_id'],
        ]);

        $user->assignRole($validated['role']);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit(User $user): View
    {
        $roles = Role::whereNotIn('name', ['Super Admin'])->get();
        $managers = User::where('id', '!=', $user->id)->get();

        return view('users.edit', compact('user', 'roles', 'managers'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'role' => 'required|exists:roles,name',
            'manager_id' => 'nullable|exists:users,id',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'manager_id' => $validated['manager_id'],
        ]);

        $user->syncRoles([$validated['role']]);

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }
}
