<?php

use App\Http\Controllers\SwitchUserModeController;
use App\Http\Livewire\NotificationsPage;
use App\Http\Livewire\OnboardPage;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\RequestTranslationPage;
use App\Http\Livewire\ReviewSectionPage;
use App\Http\Livewire\SourcePage;
use App\Http\Livewire\TranslatePage;
use App\Http\Livewire\TranslationRequestsPage;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if (!$user->isOnboarded()) {
            return redirect()->route('onboard');
        }

        if ($user->isInAuthorMode()) {
            return App::call('App\Http\Controllers\AuthorDashboardController@__invoke');
        } else {
            return App::call('App\Http\Controllers\TranslatorDashboardController@__invoke');
        }
    }

    return view('landing');
})->name('home');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::middleware('onboarded')->group(function () {
        Route::put('/switch-user-mode', SwitchUserModeController::class)->name('switch-user-mode');
        Route::get('/notifications', NotificationsPage::class)->name('notifications');

        Route::middleware('author')->group(function () {
            Route::get('/requests/new', RequestTranslationPage::class)
                ->middleware('verified')
                ->name('request-translation');

            Route::get(
                '/requests/{source}/translations/{translationRequest:language_id}',
                SourcePage::class
            )->name('translation');

            Route::get('/requests/{source}/{slug?}', SourcePage::class)->name('source');
        });

        Route::middleware('translator')->group(function () {
            Route::get('/requests', TranslationRequestsPage::class)->name('translation-requests.index');

            Route::get(
                '/translate/{translationRequest}/{slug?}',
                TranslatePage::class
            )->name('translate');
        });
    });

    Route::middleware('non_onboarded')->group(function () {
        Route::get('/onboard', OnboardPage::class)->name('onboard');
    });
});

Route::webhooks('mailchimp-webhook', 'mailchimp');
