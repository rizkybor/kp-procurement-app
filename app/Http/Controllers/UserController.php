<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

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

   public function edit(User $user) {
    $roles = \Spatie\Permission\Models\Role::orderBy('name')->pluck('name');
    return view('pages.user.edit', compact('user','roles'));
}

//     public function update(Request $request, User $user)
//     {
// dd($request,'<< cek');

//         $user->update($request->only(['name', 'email', 'department', 'position', 'employee_status']));
//         return redirect()->route('users.index')->with('success', 'User updated successfully.');
//     }
public function update(Request $request, User $user)
{
    // 🔹 Validasi data
    $validated = $request->validate([
        'name'             => 'required|string|max:255',
        'email'            => 'required|email|max:255|unique:users,email,' . $user->id,
        'nip'              => 'required|integer|digits:8|unique:users,nip,' . $user->id,
        'department'       => 'required|string|max:255',
        'position'         => 'required|string|max:255',
        'role'             => 'required|string|max:255',
        'employee_status'  => 'required|string|max:255',
        'gender'           => 'required|string|max:255',
        'identity_number'  => 'required|string|max:255',
        'signature'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
        'remove_signature' => 'nullable|boolean',
    ]);

    // 🔹 Handle upload signature baru
    $signaturePath = $user->signature;
    if ($request->hasFile('signature')) {
        $file = $request->file('signature');

        // hapus file lama jika ada
        if ($user->signature && File::exists(storage_path('app/public/' . str_replace('storage/', '', $user->signature)))) {
            File::delete(storage_path('app/public/' . str_replace('storage/', '', $user->signature)));
        }

        // simpan baru
        $filename  = 'paraf-' . Str::uuid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/images-paraf', $filename);
        $signaturePath = 'storage/images-paraf/' . $filename;
    }

    // 🔹 Hapus signature jika dicentang
    if (!$request->hasFile('signature') && $request->boolean('remove_signature')) {
        if ($user->signature && File::exists(storage_path('app/public/' . str_replace('storage/', '', $user->signature)))) {
            File::delete(storage_path('app/public/' . str_replace('storage/', '', $user->signature)));
        }
        $signaturePath = null;
    }

    // 🔹 Update data user
    $user->update([
        'name'            => $validated['name'],
        'email'           => $validated['email'],
        'nip'             => $validated['nip'],
        'department'      => $validated['department'],
        'position'        => $validated['position'],
        'role'            => $validated['role'],
        'employee_status' => $validated['employee_status'],
        'gender'          => $validated['gender'],
        'identity_number' => $validated['identity_number'],
        'signature'       => $signaturePath,
    ]);

    // 🔹 Sinkronkan role di Spatie Permission
    $roleName = $validated['role'];
    $user->syncRoles([$roleName]);

    if ($role = Role::where('name', $roleName)->first()) {
        $user->permissions()->detach();
        $user->givePermissionTo($role->permissions);
    }

    return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
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