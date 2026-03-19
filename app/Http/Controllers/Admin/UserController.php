<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(): View
    {
        return view('admin.users.index', [
            'users' => User::query()->with('roles')->latest()->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('admin.users.create', ['user' => new User()]);
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $user = User::query()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'headline' => $data['headline'] ?? null,
            'password' => Hash::make($data['password']),
            'email_verified_at' => now(),
        ]);

        Role::findOrCreate($data['role'], 'web');
        $user->syncRoles([$data['role']]);

        if ($data['role'] === 'vendor') {
            $user->store()->create([
                'name' => $user->name."'s Store",
                'slug' => Str::slug($user->name.'-'.Str::random(5)),
                'approval_status' => 'approved',
                'approved_at' => now(),
            ]);
        }

        return Redirect::route('admin.users.index')->with('status', 'User created successfully.');
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', ['user' => $user->load('roles')]);
    }

    public function update(StoreUserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'headline' => $data['headline'] ?? null,
            'password' => filled($data['password'] ?? null) ? Hash::make($data['password']) : $user->password,
        ]);

        Role::findOrCreate($data['role'], 'web');
        $user->syncRoles([$data['role']]);

        if ($data['role'] === 'vendor' && ! $user->store) {
            $user->store()->create([
                'name' => $user->name."'s Store",
                'slug' => Str::slug($user->name.'-'.Str::random(5)),
            ]);
        }

        return Redirect::route('admin.users.index')->with('status', 'User updated successfully.');
    }

    public function destroy(User $user): RedirectResponse
    {
        abort_if(auth()->user()->is($user), 422, 'You cannot delete yourself.');
        $user->delete();

        return Redirect::route('admin.users.index')->with('status', 'User deleted.');
    }
}
