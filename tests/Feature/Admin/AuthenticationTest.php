<?php

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;

test('guests are redirected to the login page', function () {
    $this->get(route('admin.dashboard'))->assertRedirect(route('admin.login'));
    $this->get(route('admin.projects.index'))->assertRedirect(route('admin.login'));
});

test('the admin can log in and out', function () {
    $user = User::factory()->create(['password' => 'motdepasse-solide-1']);

    $this->post(route('admin.login.store'), ['email' => $user->email, 'password' => 'motdepasse-solide-1'])
        ->assertRedirect(route('admin.dashboard'));

    $this->assertAuthenticatedAs($user);
    expect($user->fresh()->last_login_at)->not->toBeNull();

    $this->post(route('admin.logout'))->assertRedirect(route('admin.login'));
    $this->assertGuest();
});

test('wrong credentials are rejected', function () {
    $user = User::factory()->create();

    $this->post(route('admin.login.store'), ['email' => $user->email, 'password' => 'mauvais'])
        ->assertSessionHasErrors('email');

    $this->assertGuest();
});

test('the account is locked after five failed attempts', function () {
    $user = User::factory()->create(['password' => 'motdepasse-solide-1']);

    foreach (range(1, 5) as $attempt) {
        $this->post(route('admin.login.store'), ['email' => $user->email, 'password' => 'mauvais']);
    }

    $this->post(route('admin.login.store'), ['email' => $user->email, 'password' => 'motdepasse-solide-1'])
        ->assertSessionHasErrors(['email' => 'Trop de tentatives. Réessayez dans 15 minutes.']);

    $this->assertGuest();
});

test('a password reset link can be requested and used', function () {
    Notification::fake();
    $user = User::factory()->create();

    $this->post(route('admin.password.email'), ['email' => $user->email])->assertSessionHas('status');

    Notification::assertSentTo($user, ResetPassword::class, function (ResetPassword $notification) use ($user) {
        $this->post(route('admin.password.update'), [
            'token' => $notification->token,
            'email' => $user->email,
            'password' => 'nouveau-mot-de-passe-2026',
            'password_confirmation' => 'nouveau-mot-de-passe-2026',
        ])->assertRedirect(route('admin.login'));

        return true;
    });

    $this->post(route('admin.login.store'), ['email' => $user->email, 'password' => 'nouveau-mot-de-passe-2026']);
    $this->assertAuthenticatedAs($user);
});

test('every admin screen renders for the admin', function (string $route) {
    $this->actingAs(adminUser())->get(route($route))->assertOk();
})->with([
    'admin.dashboard', 'admin.profile', 'admin.projects.index', 'admin.projects.create', 'admin.skills',
    'admin.technologies', 'admin.experiences', 'admin.process', 'admin.messages', 'admin.media', 'admin.settings',
]);
