<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $users = User::with('roles')
            ->when($search, function ($q) use ($search) {
                $q->where(function ($qq) use ($search) {
                    $qq->where('name', 'like', "%{$search}%")
                       ->orWhere('email', 'like', "%{$search}%")
                       ->orWhere('department', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        // SINGULAR: pages.user.index (ikuti pola vendor: pages.vendor.index)
        return view('pages.user.index', compact('users'));
    }

    public function edit(User $user)
    {
        // SINGULAR juga
        return view('pages.user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->only(['name', 'email', 'department', 'position', 'employee_status']));
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Tidak bisa menghapus akun Anda sendiri.');
        }

        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }
}