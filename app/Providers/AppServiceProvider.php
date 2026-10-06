<?php

namespace App\Providers;

use App\Models\Message;
use App\Models\Profile;
use App\Support\Localization;
use App\Support\Settings;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Spatie\Translatable\Facades\Translatable;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::shouldBeStrict(! $this->app->isProduction());

        Translatable::fallback(fallbackLocale: 'fr', fallbackAny: true);

        Password::defaults(fn () => Password::min(12)->letters()->numbers());

        ResetPassword::createUrlUsing(fn ($user, string $token) => route('admin.password.reset', ['token' => $token, 'email' => $user->getEmailForPasswordReset()]));
        ResetPassword::toMailUsing(fn ($user, string $token) => (new MailMessage)
            ->subject('Réinitialisation de votre mot de passe')
            ->greeting('Bonjour,')
            ->line('Vous avez demandé à réinitialiser le mot de passe de l\'administration du portfolio.')
            ->action('Choisir un nouveau mot de passe', route('admin.password.reset', ['token' => $token, 'email' => $user->getEmailForPasswordReset()]))
            ->line('Ce lien expire dans 60 minutes. Si vous n\'êtes pas à l\'origine de cette demande, ignorez cet e-mail.')
            ->salutation('Nganjie Nzatsi — portfolio'));

        $this->configureRateLimiting();
        $this->shareViewData();
    }

    private function configureRateLimiting(): void
    {
        RateLimiter::for('contact', fn (Request $request) => [
            Limit::perMinutes(10, 3)->by('contact:'.$request->ip())->response(fn () => $this->tooManyContactAttempts()),
            Limit::perDay(10)->by('contact-day:'.$request->ip())->response(fn () => $this->tooManyContactAttempts()),
        ]);

        RateLimiter::for('admin-login', fn (Request $request) => Limit::perMinute(10)->by($request->ip()));
    }

    private function tooManyContactAttempts(): mixed
    {
        $locale = Localization::isSupported(request()->input('locale')) ? request()->input('locale') : Localization::DEFAULT;

        return redirect()->to(localized_route('home', [], $locale).'#contact')
            ->withInput()
            ->withErrors(['body' => __('Trop de messages envoyés. Réessayez dans quelques minutes ou écrivez-moi directement par e-mail.', [], $locale)]);
    }

    private function shareViewData(): void
    {
        View::composer(['components.layouts.site', 'components.site.*', 'site.*', 'errors.*'], function ($view) {
            $view->with([
                'siteProfile' => once(fn () => Profile::current()->loadMissing('media')),
                'siteSections' => once(fn () => (array) Settings::get('sections.visible')),
            ]);
        });

        View::composer('layouts.admin', function ($view) {
            $view->with('unreadMessages', Message::query()->inbox()->unread()->count());
        });
    }
}
