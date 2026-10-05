<?php

namespace App\Support;

use App\Models\PageView;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Records anonymous page views for the dashboard statistics.
 */
class PageViewRecorder
{
    private const BOT_PATTERN = '/bot|crawl|spider|slurp|facebookexternalhit|preview|monitor|curl|wget|python|headless|lighthouse/i';

    public static function record(Request $request, ?Project $project = null, ?string $path = null): void
    {
        if ($request->user() !== null || preg_match(self::BOT_PATTERN, (string) $request->userAgent())) {
            return;
        }

        $referrer = $request->headers->get('referer');

        PageView::query()->create([
            'path' => $path ?? '/'.ltrim($request->path(), '/'),
            'project_id' => $project?->id,
            'referrer' => $referrer && ! Str::startsWith($referrer, config('app.url')) ? Str::limit($referrer, 250, '') : null,
            'viewed_at' => now(),
        ]);
    }
}
