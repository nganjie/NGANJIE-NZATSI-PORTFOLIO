<?php

namespace App\Http\Requests;

use App\Enums\MessageType;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactRequest extends FormRequest
{
    /**
     * Minimum number of seconds between displaying the form and sending it.
     */
    public const MIN_SECONDS = 3;

    /**
     * Maximum age of the form token, in seconds.
     */
    public const MAX_SECONDS = 2 * 60 * 60;

    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => ['required', Rule::enum(MessageType::class)],
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'email' => ['required', 'string', 'max:255', app()->isProduction() ? 'email:rfc,dns' : 'email:rfc'],
            'body' => ['required', 'string', 'min:10', 'max:5000'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'type' => 'type de demande',
            'name' => 'nom',
            'email' => 'e-mail',
            'body' => 'message',
        ];
    }

    /**
     * Honeypot filled in, or form sent too quickly to be human, or with an expired token.
     */
    public function isSpam(): bool
    {
        if (filled($this->input('website'))) {
            return true;
        }

        try {
            $startedAt = (int) decrypt((string) $this->input('_started'));
        } catch (DecryptException) {
            return true;
        }

        $elapsed = now()->timestamp - $startedAt;

        return $elapsed < self::MIN_SECONDS || $elapsed > self::MAX_SECONDS;
    }

    protected function getRedirectUrl(): string
    {
        return route('home').'#contact';
    }
}
