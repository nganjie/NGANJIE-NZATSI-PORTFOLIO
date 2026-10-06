<?php

namespace App\Http\Controllers\Site;

use App\Enums\ProjectType;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Support\PageViewRecorder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        PageViewRecorder::record($request);

        $projects = Project::query()->published()->ordered()->with(['technologies', 'media'])->get();

        $activeType = ProjectType::fromSlug($request->query('type'));

        $filters = collect(ProjectType::cases())
            ->map(fn (ProjectType $type) => [
                'type' => $type,
                'count' => $projects->where('type', $type)->count(),
            ])
            ->filter(fn (array $filter) => $filter['count'] > 0)
            ->values();

        return view('site.projects.index', [
            'projects' => $activeType ? $projects->where('type', $activeType)->values() : $projects,
            'total' => $projects->count(),
            'filters' => $filters,
            'activeType' => $activeType,
        ]);
    }

    public function show(Request $request, Project $project): View
    {
        $isPreview = ! $project->isPublished();

        abort_if($isPreview && $request->user() === null, 404);

        $project->load(['technologies', 'tasks', 'media']);

        if (! $isPreview) {
            PageViewRecorder::record($request, $project);
        }

        $cover = $project->getFirstMedia('cover');

        return view('site.projects.show', [
            'project' => $project,
            'gallery' => $project->getMedia('gallery'),
            'next' => $project->nextPublished(),
            'isPreview' => $isPreview,
            'shareImage' => $cover?->hasGeneratedConversion('og') ? $cover->getUrl('og') : null,
            'jsonLd' => array_filter([
                '@context' => 'https://schema.org',
                '@type' => 'CreativeWork',
                'name' => $project->title,
                'description' => $project->summary,
                'url' => localized_route('projects.show', $project),
                'keywords' => $project->technologies->pluck('name')->join(', '),
                'creator' => ['@type' => 'Person', 'name' => 'Nganjie Nzatsi'],
            ]),
        ]);
    }
}
