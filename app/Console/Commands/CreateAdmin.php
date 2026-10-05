<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

#[Signature('admin:create {email? : Adresse e-mail du compte} {--name=Nganjie Nzatsi : Nom affiché}')]
#[Description('Crée le compte administrateur ou réinitialise son mot de passe')]
class CreateAdmin extends Command
{
    public function handle(): int
    {
        $email = $this->argument('email') ?: $this->ask('Adresse e-mail', (string) config('portfolio.admin.email'));
        $password = $this->secret('Mot de passe (12 caractères minimum, lettres et chiffres)');

        $validator = Validator::make(
            ['email' => $email, 'password' => $password],
            ['email' => ['required', 'email'], 'password' => ['required', Password::defaults()]],
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        $user = User::query()->updateOrCreate(['email' => $email], [
            'name' => (string) $this->option('name'),
            'password' => $password,
        ]);

        $this->info($user->wasRecentlyCreated ? "Compte administrateur créé : {$email}" : "Mot de passe mis à jour pour {$email}");

        return self::SUCCESS;
    }
}
