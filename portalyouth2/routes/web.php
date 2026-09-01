<?php

use App\Http\Controllers\RemoteImageController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', \App\Livewire\Landing\Home::class)->name('home');

Route::post('/locale', function (Request $request) {
    $locale = (string) $request->input('locale', 'en');
    abort_unless(in_array($locale, config('portal.translation_locales', []), true), 422);
    $request->session()->put('locale', $locale);
    return back();
})->name('locale.update');

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::get('/img/{payload}', RemoteImageController::class)
    ->middleware('throttle:120,1')
    ->name('img.proxy');

Route::get('/opportunity/{opportunity}', \App\Livewire\Opportunity\Show::class)
    ->name('opportunity.show');

Route::get('/programme/{programme}', \App\Livewire\Programme\Show::class)
    ->name('programme.show');

Route::get('/campaign/{campaign}', \App\Livewire\Campaign\Show::class)
    ->name('campaign.show');

Route::get('/news/{news}', \App\Livewire\News\Show::class)
    ->name('news.show');

Route::view('/privacy', 'legal.privacy')->name('privacy');
Route::view('/terms', 'legal.terms')->name('terms');

Route::middleware(['auth', 'activated'])->group(function () {
    Route::get('/dashboard', \App\Livewire\Dashboard\Index::class)->name('dashboard');
    Route::get('/dashboard/profile', \App\Livewire\Dashboard\Profile::class)->name('dashboard.profile');
    Route::get('/dashboard/opportunities', \App\Livewire\Dashboard\Opportunities::class)->name('dashboard.opportunities');
    Route::get('/dashboard/applications', \App\Livewire\Dashboard\Applications::class)->name('dashboard.applications');
    Route::get('/dashboard/notifications', \App\Livewire\Dashboard\Notifications::class)->name('dashboard.notifications');
});

require __DIR__.'/auth.php';
