<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Spatie\Permission\Models\Role;



class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'nip' => ['required', 'integer', 'digits:8', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'department' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'role' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($input) {
                    $dept = $input['department'] ?? null;

                    // 1) Manager unik per departemen
                    if ($value === 'manager' && $dept) {
                        $exists = \App\Models\User::where('department', $dept)
                            ->where('role', 'manager')
                            ->exists();
                        if ($exists) {
                            $fail('Departemen ini sudah memiliki seorang Manager.');
                            return;
                        }
                    }

                    // 2) Direksi & Fungsi Pengadaan unik global
                    if (in_array($value, ['direktur_keuangan', 'direktur_utama', 'fungsi_pengadaan'], true)) {
                        $existsGlobal = \App\Models\User::where('role', $value)->exists();
                        if ($existsGlobal) {
                            $label = [
                                'direktur_keuangan' => 'Direktur Keuangan',
                                'direktur_utama' => 'Direktur Utama',
                                'fungsi_pengadaan' => 'Fungsi Pengadaan',
                            ][$value];
                            $fail("Role {$label} sudah terpakai oleh pengguna lain.");
                            return;
                        }
                    }

                    // 3) BARU: Maker hanya boleh jika departemen sudah punya Manager
                    if ($value === 'maker') {
                        if (!$dept) {
                            $fail('Pilih departemen terlebih dahulu.');
                            return;
                        }
                        $deptHasManager = \App\Models\User::where('department', $dept)
                            ->where('role', 'manager')
                            ->exists();
                        if (!$deptHasManager) {
                            $fail('Anda tidak dapat membuat role Maker karena departemen ini belum memiliki Manager.');
                            return;
                        }
                    }
                },
            ],
            'employee_status' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'max:255'],
            'identity_number' => ['required', 'string', 'max:255'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'nip' => $input['nip'],
            'department' => $input['department'],
            'position' => $input['position'],
            'role' => $input['role'],
            'employee_status' => $input['employee_status'],
            'gender' => $input['gender'],
            'identity_number' => $input['identity_number'],
        ]);

        // Give Roles

        $roleName = $input['role'];

        $role = Role::where('name', $roleName)->first();

        if ($role) {
            $user->assignRole($roleName);
            $user->givePermissionTo($role->permissions);
        }

        return $user;
    }
}
