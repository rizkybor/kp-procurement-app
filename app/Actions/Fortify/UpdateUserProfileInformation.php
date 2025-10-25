<?php

namespace App\Actions\Fortify;

use App\Models\User; // ⬅️ pakai model aplikasi
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use Spatie\Permission\Models\Role;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * @param  array<string, mixed>  $input
     */
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'name'             => ['required', 'string', 'max:255'],
            'email'            => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo'            => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            'nip'              => ['required', 'integer', 'digits:8', Rule::unique('users', 'nip')->ignore($user->id)], // ⬅️ unik
            'department'       => ['required', 'string', 'max:255'],
            'position'         => ['required', 'string', 'max:255'],
            'role'             => ['required', 'string', 'max:255'],
            'employee_status'  => ['required', 'string', 'max:255'],
            'gender'           => ['required', 'string', 'max:255'],
            'identity_number'  => ['required', 'string', 'max:255'],
            'signature'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:1024'], // ⬅️ validasi paraf
            'remove_signature' => ['nullable', 'boolean'],                                      // ⬅️ opsional
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        // --- Proses upload/hapus signature ---
        $signaturePath = $user->signature; // default tetap yang lama
dd($signaturePath,'<< cek');
        if (request()->hasFile('signature')) {
            $file = request()->file('signature');

            // Hapus file lama jika ada
            if ($user->signature && File::exists(storage_path('app/public/' . str_replace('storage/', '', $user->signature)))) {
                @File::delete(storage_path('app/public/' . str_replace('storage/', '', $user->signature)));
            }

            // Buat folder target jika belum ada
            $filename  = 'paraf-' . Str::uuid() . '.' . $file->getClientOriginalExtension();
            $targetDir = storage_path('app/public/images-paraf');
            if (!File::exists($targetDir)) {
                File::makeDirectory($targetDir, 0755, true);
            }

            // Simpan file ke storage/app/public/images-paraf
            $file->move($targetDir, $filename);

            // Simpan path yang bisa diakses lewat URL (storage/images-paraf/...)
            $signaturePath = 'storage/images-paraf/' . $filename;
        } elseif (!empty($input['remove_signature'])) {
            // Hapus tanpa upload baru
            if ($user->signature && File::exists(storage_path('app/public/' . str_replace('storage/', '', $user->signature)))) {
                @File::delete(storage_path('app/public/' . str_replace('storage/', '', $user->signature)));
            }
            $signaturePath = null;
        }

        // --- Update data ---
        if ($input['email'] !== $user->email && $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);

            // (Opsional) jika ingin tetap memperbarui field lain meski email berubah:
            $user->forceFill([
                'nip'             => $input['nip'],
                'department'      => $input['department'],
                'position'        => $input['position'],
                'role'            => $input['role'],
                'employee_status' => $input['employee_status'],
                'gender'          => $input['gender'],
                'identity_number' => $input['identity_number'],
                'signature'       => $signaturePath, // ⬅️ simpan paraf
            ])->save();
        } else {
            $user->forceFill([
                'name'            => $input['name'],
                'email'           => $input['email'],
                'nip'             => $input['nip'],
                'department'      => $input['department'],
                'position'        => $input['position'],
                'role'            => $input['role'],
                'employee_status' => $input['employee_status'],
                'gender'          => $input['gender'],
                'identity_number' => $input['identity_number'],
                'signature'       => $signaturePath, // ⬅️ simpan paraf
            ])->save();
        }

        // --- Sinkronisasi role & permissions ---
        $roleName = $input['role'];
        $user->syncRoles([$roleName]);

        if ($role = Role::where('name', $roleName)->first()) {
            $user->permissions()->detach();
            $user->givePermissionTo($role->permissions);
        }
    }

    /**
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'name'              => $input['name'],
            'email'             => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
