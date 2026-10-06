<?php

namespace App\Http\Middleware;

use App\Support\Localization;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Apply the locale of the route group (fr by default).
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ?string $locale = null): Response
    {
        $locale = Localization::isSupported($locale) ? $locale : Localization::DEFAULT;

        app()->setLocale($locale);
        Carbon::setLocale($locale);

        return $next($request);
    }
}
