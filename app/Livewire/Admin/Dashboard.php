<?php

namespace App\Livewire\Admin;

use App\Enums\ProjectStatus;
use App\Models\Message;
use App\Models\PageView;
use App\Models\Profile;
use App\Models\Project;
use Illuminate\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Tableau de bord')]
class Dashboard extends Component
{
    public function render(): View
    {
        $profile = Profile::current()->load('media');

        return view('livewire.admin.dashboard', [
            'profile' => $profile,
            'unreadCount' => Message::query()->inbox()->unread()->count(),
            'publishedCount' => Project::query()->where('status', ProjectStatus::Published)->count(),
            'draftCount' => Project::query()->where('status', ProjectStatus::Draft)->count(),
            'featuredCount' => Project::query()->published()->featured()->count(),
            'latestMessages' => Message::query()->inbox()->latest()->limit(5)->get(),
            'monthViews' => PageView::query()->where('viewed_at', '>=', now()->startOfMonth())->where('path', '!=', '/cv')->count(),
            'cvDownloads' => PageView::query()->where('path', '/cv')->where('viewed_at', '>=', now()->startOfMonth())->count(),
            'topProjects' => Project::query()
                ->whereHas('pageViews', fn ($query) => $query->where('viewed_at', '>=', now()->subDays(30)))
                ->withCount(['pageViews' => fn ($query) => $query->where('viewed_at', '>=', now()->subDays(30))])
                ->orderByDesc('page_views_count')
                ->limit(5)
                ->get(),
        ]);
    }
}
