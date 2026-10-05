<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\PasswordResetController;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Experiences;
use App\Livewire\Admin\MediaLibrary;
use App\Livewire\Admin\Messages;
use App\Livewire\Admin\ProcessSteps;
use App\Livewire\Admin\ProfileForm;
use App\Livewire\Admin\Projects\ProjectForm;
use App\Livewire\Admin\Projects\ProjectIndex;
use App\Livewire\Admin\SettingsForm;
use App\Livewire\Admin\Skills;
use App\Livewire\Admin\Technologies;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/connexion', [AuthController::class, 'create'])->name('login');
    Route::post('/connexion', [AuthController::class, 'store'])->middleware('throttle:admin-login')->name('login.store');

    Route::get('/mot-de-passe-oublie', [PasswordResetController::class, 'request'])->name('password.request');
    Route::post('/mot-de-passe-oublie', [PasswordResetController::class, 'email'])->middleware('throttle:6,1')->name('password.email');
    Route::get('/reinitialiser/{token}', [PasswordResetController::class, 'edit'])->name('password.reset');
    Route::post('/reinitialiser', [PasswordResetController::class, 'update'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/deconnexion', [AuthController::class, 'destroy'])->name('logout');

    Route::livewire('/', Dashboard::class)->name('dashboard');
    Route::livewire('/profil', ProfileForm::class)->name('profile');
    Route::livewire('/projets', ProjectIndex::class)->name('projects.index');
    Route::livewire('/projets/creer', ProjectForm::class)->name('projects.create');
    Route::livewire('/projets/{project}/modifier', ProjectForm::class)->name('projects.edit');
    Route::livewire('/competences', Skills::class)->name('skills');
    Route::livewire('/technologies', Technologies::class)->name('technologies');
    Route::livewire('/parcours', Experiences::class)->name('experiences');
    Route::livewire('/methode', ProcessSteps::class)->name('process');
    Route::livewire('/messages', Messages::class)->name('messages');
    Route::livewire('/medias', MediaLibrary::class)->name('media');
    Route::livewire('/parametres', SettingsForm::class)->name('settings');
});
