<?php

use App\Mail\NewContactMessage;
use App\Models\Message;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

beforeEach(function () {
    Mail::fake();
    RateLimiter::clear('contact:127.0.0.1');
    RateLimiter::clear('contact-day:127.0.0.1');
});

/**
 * @return array<string, string>
 */
function contactPayload(array $overrides = []): array
{
    return [
        'type' => 'job',
        'name' => 'Awa Ndiaye',
        'email' => 'awa@example.com',
        'body' => 'Bonjour, nous recrutons un stagiaire développeur .NET pour janvier.',
        '_started' => encrypt(now()->subSeconds(30)->timestamp),
        ...$overrides,
    ];
}

test('a valid message is stored and a notification is queued', function () {
    $this->post(route('contact.store'), contactPayload())
        ->assertRedirect(route('home').'#contact')
        ->assertSessionHas('contact_sent');

    $message = Message::query()->sole();

    expect($message->name)->toBe('Awa Ndiaye')
        ->and($message->ip_hash)->not->toBeNull()
        ->and($message->isRead())->toBeFalse();

    Mail::assertQueued(NewContactMessage::class, fn ($mail) => $mail->hasReplyTo('awa@example.com'));
});

test('the honeypot silently drops the message', function () {
    $this->post(route('contact.store'), contactPayload(['website' => 'http://spam.example']))
        ->assertSessionHas('contact_sent');

    expect(Message::query()->count())->toBe(0);
    Mail::assertNothingQueued();
});

test('a form sent too fast is treated as spam', function () {
    $this->post(route('contact.store'), contactPayload(['_started' => encrypt(now()->timestamp)]));

    expect(Message::query()->count())->toBe(0);
});

test('invalid fields are rejected', function () {
    $this->post(route('contact.store'), contactPayload(['email' => 'pas-un-email', 'body' => 'court']))
        ->assertSessionHasErrors(['email', 'body']);

    expect(Message::query()->count())->toBe(0);
});

test('the contact form is rate limited', function () {
    foreach (range(1, 3) as $attempt) {
        $this->post(route('contact.store'), contactPayload())->assertSessionHasNoErrors();
    }

    $this->post(route('contact.store'), contactPayload())->assertSessionHasErrors('body');

    expect(Message::query()->count())->toBe(3);
});

test('validation messages are written in French', function () {
    $this->post(route('contact.store'), contactPayload(['name' => '']))
        ->assertSessionHasErrors(['name' => 'Le champ nom est obligatoire.']);
});

test('an expired form token is treated as spam', function () {
    $this->post(route('contact.store'), contactPayload(['_started' => encrypt(now()->subHours(3)->timestamp)]));

    expect(Message::query()->count())->toBe(0);
});

test('markdown in a message does not become a link in the notification', function () {
    $message = Message::factory()->create(['body' => '[Réinitialisez votre mot de passe](https://evil.example)']);

    $html = (new NewContactMessage($message))->render();

    expect($html)->not->toContain('href="https://evil.example"');
});
