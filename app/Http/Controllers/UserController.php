<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    private array $roleWeights = [
        'Super Admin' => 100,
        'Company Admin' => 80,
        'Sales Manager' => 60,
        'Sales Agent' => 40,
        'Accountant' => 40,
        'Support' => 30,
        'Viewer' => 10,
    ];

    private function canManageUser(User $targetUser): bool
    {
        $authUser = auth()->user();

        if ($authUser->is_root || $authUser->id === $targetUser->id) {
            return true;
        }

        if ($targetUser->is_root) {
            return false;
        }

        $authMaxWeight = 0;
        foreach ($authUser->roles as $role) {
            $authMaxWeight = max($authMaxWeight, $this->roleWeights[$role->name] ?? 0);
        }

        $targetMaxWeight = 0;
        foreach ($targetUser->roles as $role) {
            $targetMaxWeight = max($targetMaxWeight, $this->roleWeights[$role->name] ?? 0);
        }

        return $authMaxWeight >= $targetMaxWeight;
    }

    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    public function index(): View
    {
        $authUser = auth()->user();

        // Define hierarchy mapping (Higher number = higher privilege)
        $roleWeights = $this->roleWeights;

        // Determine the max weight of the current user
        $userMaxWeight = 0;
        foreach ($authUser->roles as $role) {
            $userMaxWeight = max($userMaxWeight, $roleWeights[$role->name] ?? 0);
        }

        // Apply weight filtering
        $users = User::with('roles')
            ->where(function ($query) use ($userMaxWeight, $roleWeights) {
                // Root users can see everyone
                if (auth()->user()->is_root) {
                    return;
                }

                // Allow users with NO roles (edge case) or roles <= userMaxWeight
                $query->whereDoesntHave('roles')
                    ->orWhereHas('roles', function ($q) use ($userMaxWeight, $roleWeights) {
                    $allowedRoles = array_keys(array_filter($roleWeights, function ($weight) use ($userMaxWeight) {
                        return $weight <= $userMaxWeight;
                    }));
                    $q->whereIn('name', $allowedRoles);
                });
            })
            ->latest()
            ->paginate(10);

        return view('users.index', compact('users'));
    }

    public function create(): View
    {
        $roles = Role::whereNotIn('name', ['Super Admin'])->get();
        $managers = User::all(); // Scoped by TenantScope
        $companies = auth()->user()->hasRole('Super Admin') ? \App\Models\Company::all() : collect();
        return view('users.create', compact('roles', 'managers', 'companies'));
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
            'company_id' => $validated['company_id'] ?? (auth()->user()->company_id ?? null),
        ]);

        $user->assignRole($validated['role']);

        return redirect()->route('users.index')
            ->with('success', __('messages.user_created_successfully'));
    }

    public function edit(User $user): View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
    {
        if (!$this->canManageUser($user)) {
            return redirect()->route('users.index')->with('error', __('Unauthorized to manage this user.'));
        }

        $roles = Role::whereNotIn('name', ['Super Admin'])->get();
        $managers = User::where('id', '!=', $user->id)->get();
        $companies = auth()->user()->hasRole('Super Admin') ? \App\Models\Company::all() : collect();
        return view('users.edit', compact('user', 'roles', 'managers', 'companies'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        if (!$this->canManageUser($user)) {
            return redirect()->route('users.index')->with('error', __('Unauthorized to manage this user.'));
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
            'manager_id' => 'nullable|exists:users,id',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'manager_id' => $validated['manager_id'],
            'company_id' => $validated['company_id'] ?? ($user->company_id),
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = \Hash::make($validated['password']);
        }

        $user->update($updateData);

        $user->syncRoles([$validated['role']]);

        return redirect()->route('users.index')
            ->with('success', __('messages.user_updated_successfully'));
    }

    public function resetPassword(User $user): RedirectResponse
    {
        if (!$this->canManageUser($user)) {
            return redirect()->route('users.index')->with('error', __('Unauthorized to manage this user.'));
        }

        $newPassword = \Illuminate\Support\Str::random(10);

        $user->update([
            'password' => \Hash::make($newPassword),
        ]);

        $rootUser = \App\Models\User::where('is_root', true)->first();
        if ($rootUser) {
            \Illuminate\Support\Facades\Mail::raw(
                "The password for user {$user->name} ({$user->email}) has been reset.\nNew Password: {$newPassword}",
                function ($message) use ($rootUser) {
                    $message->to($rootUser->email)->subject('User Password Reset Notification');
                }
            );
        }

        return redirect()->route('users.index')
            ->with('success', __('messages.password_reset_successfully', ['name' => $user->name]));
    }

    public function destroy(User $user): RedirectResponse
    {
        if (!$this->canManageUser($user)) {
            return redirect()->route('users.index')->with('error', __('Unauthorized to manage this user.'));
        }

        if ($user->is_root) {
            return redirect()->route('users.index')
                ->with('error', __('Cannot delete a root admin.'));
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', __('messages.user_deleted_successfully'));
    }
}
