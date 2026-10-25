<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Support\Str;

/** Creates portal login accounts for students and employees with a one-time password. */
class AccountIssuer
{
    /** @return array{0: User, 1: string} the user and the plain-text temporary password */
    public static function issue(string $name, ?string $email, string $username, int $role, ?string $phone = null): array
    {
        $password = Str::password(10, symbols: false);

        $user = User::create([
            'name' => $name,
            'username' => $username,
            'email' => $email ?: Str::slug($username, '.').'@portal.hewittbennet.co.ke',
            'phone' => $phone,
            'role' => $role,
            'password' => $password,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        return [$user, $password];
    }

    public static function message(User $user, string $password): string
    {
        return "Portal account created. Username: {$user->username} | Temporary password: {$password} (share it securely and ask them to change it after first login).";
    }
}
