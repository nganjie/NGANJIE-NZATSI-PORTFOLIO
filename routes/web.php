<?php

use App\Http\Controllers\Site\ContactController;
use App\Http\Controllers\Site\CvController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\ProjectController;
use App\Http\Controllers\Site\SitemapController;
use Illuminate\Support\Facades\Route;

/*
| French pages live at the root, English pages under /en with "en." names.
| Use localized_route('projects.show', $project) in views to stay in the
| visitor's language.
*/

Route::middleware('locale:fr')->group(function () {
    Route::get('/', HomeController::class)->name('home');
    Route::get('/projets', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projets/{project:slug}', [ProjectController::class, 'show'])->name('projects.show');
});

Route::prefix('en')->name('en.')->middleware('locale:en')->group(function () {
    Route::get('/', HomeController::class)->name('home');
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/{project:slug}', [ProjectController::class, 'show'])->name('projects.show');
});

Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:contact')->name('contact.store');
Route::get('/cv', CvController::class)->name('cv.download');
Route::get('/sitemap.xml', [SitemapController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots');
