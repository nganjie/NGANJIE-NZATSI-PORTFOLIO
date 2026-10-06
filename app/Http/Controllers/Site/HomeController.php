<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use App\Models\ProcessStep;
use App\Models\Profile;
use App\Models\Project;
use App\Models\SkillDomain;
use App\Models\Technology;
use App\Support\PageViewRecorder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(Request $request): View
    {
        PageViewRecorder::record($request);

        $data = [
            'profile' => Profile::current()->load(['media', 'featuredProject.media']),
            'featuredProjects' => Project::query()->published()->featured()->ordered()->with(['technologies', 'media'])->get(),
            'skillDomains' => SkillDomain::query()->ordered()->get(),
            'experiences' => Experience::query()->ordered()->get(),
            'technologies' => Technology::query()->where('show_on_home', true)->ordered()->limit(Technology::HOME_LIMIT)->get(),
            'processSteps' => ProcessStep::query()->ordered()->get(),
        ];

        $profile = $data['profile'];

        return view('site.home', [
            ...$data,
            'jsonLd' => array_filter([
                '@context' => 'https://schema.org',
                '@type' => 'Person',
                'name' => $profile->display_name,
                'jobTitle' => $profile->headline,
                'email' => 'mailto:'.$profile->email,
                'url' => localized_route('home'),
                'address' => ['@type' => 'PostalAddress', 'addressLocality' => 'Douala', 'addressCountry' => 'CM'],
                'sameAs' => array_values(array_filter([$profile->github_url, $profile->linkedin_url])),
                'image' => $profile->getFirstMediaUrl('photo', 'md') ?: null,
            ]),
        ]);
    }
}
