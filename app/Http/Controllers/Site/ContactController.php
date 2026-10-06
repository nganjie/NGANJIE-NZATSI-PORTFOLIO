<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Mail\NewContactMessage;
use App\Models\Message;
use App\Models\Profile;
use App\Support\Settings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(ContactRequest $request): RedirectResponse
    {
        if ($request->isSpam()) {
            return redirect()->to(localized_route('home', [], $request->pageLocale()).'#contact')->with('contact_sent', true);
        }

        $message = Message::query()->create([
            ...$request->safe()->only(['type', 'name', 'email', 'body']),
            'ip_hash' => hash('sha256', $request->ip().config('app.key')),
        ]);

        $recipient = Settings::get('contact.notify_email') ?: Profile::current()->email;

        if ($recipient) {
            Mail::to($recipient)->queue(new NewContactMessage($message));
        }

        return redirect()->to(localized_route('home', [], $request->pageLocale()).'#contact')->with('contact_sent', true);
    }
}
