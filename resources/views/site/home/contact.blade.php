<section id="contact" class="scroll-mt-6 bg-mist py-24 md:py-28" aria-labelledby="titre-contact">
    <div class="wrap grid items-start gap-12 md:grid-cols-2">
        <div data-reveal-group="100">
            <p data-reveal class="eyebrow mb-3 text-violet">06 — {{ __('Contact') }}</p>
            <h2 id="titre-contact" data-split class="display mb-6 text-[clamp(2.25rem,6vw,4rem)] leading-none">{{ __('Parlons de votre') }} <span class="highlight">{{ __('projet') }}</span></h2>
            <p data-reveal class="mb-8 max-w-md text-muted">{{ __('Un poste, un stage, une mission ou une idée d\'application : écrivez-moi, je vous réponds rapidement.') }}</p>
            <p class="mb-1.5 text-sm text-muted">{{ __('Ou directement par e-mail') }}</p>
            <a href="mailto:{{ $profile->email }}" class="font-display text-xl font-bold break-all text-ink hover:text-violet md:text-[26px]">{{ $profile->email }}</a>
            @if ($profile->phone)
                <p class="mt-4 text-muted">{{ __('Téléphone :') }} <a href="tel:{{ preg_replace('/\s+/', '', $profile->phone) }}" class="font-semibold text-ink">{{ $profile->phone }}</a></p>
            @endif
        </div>

        <div data-reveal style="--reveal-delay: 200ms" class="rounded-[20px] bg-white p-6 md:p-9">
            @if (session('contact_sent'))
                <div role="status" class="mb-6 rounded-xl bg-lime-soft p-4 font-semibold text-success">
                    {{ __('Merci, votre message a bien été envoyé. Je vous réponds rapidement.') }}
                </div>
            @endif

            @if ($errors->any())
                <div role="alert" class="mb-6 rounded-xl bg-[#fde8e8] p-4 text-danger">
                    {{ __('Le message n\'a pas pu être envoyé. Vérifiez les champs signalés.') }}
                </div>
            @endif

            <form method="POST" action="{{ route('contact.store') }}" class="flex flex-col gap-5" novalidate>
                @csrf
                <input type="hidden" name="locale" value="{{ app()->getLocale() }}">
                <input type="hidden" name="_started" value="{{ encrypt(now()->timestamp) }}">
                <div class="absolute -left-[9999px]" aria-hidden="true">
                    <label for="website">{{ __('Ne pas remplir ce champ') }}</label>
                    <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                </div>

                <div class="flex flex-col gap-2">
                    <label for="contact-type" class="text-[15px] font-semibold">{{ __('Type de demande') }}</label>
                    <select id="contact-type" name="type" class="field-input" @error('type') aria-invalid="true" aria-describedby="contact-type-error" @enderror>
                        @foreach (\App\Enums\MessageType::cases() as $type)
                            <option value="{{ $type->value }}" @selected(old('type') === $type->value)>{{ $type->label() }}</option>
                        @endforeach
                    </select>
                    @error('type')<p id="contact-type-error" class="text-sm text-danger">{{ $message }}</p>@enderror
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="flex flex-col gap-2">
                        <label for="contact-name" class="text-[15px] font-semibold">{{ __('Nom') }}</label>
                        <input id="contact-name" type="text" name="name" value="{{ old('name') }}" autocomplete="name" required maxlength="100" class="field-input"
                            placeholder="{{ __('Votre nom') }}" @error('name') aria-invalid="true" aria-describedby="contact-name-error" @enderror>
                        @error('name')<p id="contact-name-error" class="text-sm text-danger">{{ $message }}</p>@enderror
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="contact-email" class="text-[15px] font-semibold">{{ __('E-mail') }}</label>
                        <input id="contact-email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" required class="field-input"
                            placeholder="{{ __('vous@exemple.com') }}" @error('email') aria-invalid="true" aria-describedby="contact-email-error" @enderror>
                        @error('email')<p id="contact-email-error" class="text-sm text-danger">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label for="contact-body" class="text-[15px] font-semibold">{{ __('Message') }}</label>
                    <textarea id="contact-body" name="body" rows="5" required maxlength="5000" class="field-input"
                        placeholder="{{ __('Décrivez votre besoin') }}" @error('body') aria-invalid="true" aria-describedby="contact-body-error" @enderror>{{ old('body') }}</textarea>
                    @error('body')<p id="contact-body-error" class="text-sm text-danger">{{ $message }}</p>@enderror
                </div>

                <button type="submit" class="btn btn-ink self-start">{{ __('Envoyer le message') }}</button>
            </form>
        </div>
    </div>
</section>
