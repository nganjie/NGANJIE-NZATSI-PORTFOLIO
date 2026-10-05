<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Create the single administrator account from the environment.
     */
    public function run(): void
    {
        $email = config('portfolio.admin.email');

        if (User::query()->where('email', $email)->exists()) {
            return;
        }

        $password = config('portfolio.admin.password') ?: Str::password(16);

        User::query()->create([
            'name' => 'Nganjie Nzatsi',
            'email' => $email,
            'password' => $password,
        ]);

        if (! config('portfolio.admin.password')) {
            $this->command?->warn("Compte administrateur créé : {$email} / {$password} (à changer après connexion).");
        }
    }
}
