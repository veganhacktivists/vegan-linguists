<?php

use App\Http\Controllers\SwitchUserModeController;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\RequestTranslationPage;
use App\Http\Livewire\SourcePage;
use App\Http\Livewire\TranslatePage;
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
        if (Auth::user()->isInAuthorMode()) {
            return App::call('App\Http\Controllers\AuthorDashboardController@__invoke');
        } else {
            return App::call('App\Http\Controllers\TranslatorDashboardController@__invoke');
        }
    }

    return view('welcome');
})->name('home');

Route::middleware(['auth:sanctum', 'verified'])->group(function() {
    Route::put('/switch-user-mode', SwitchUserModeController::class)->name('switch-user-mode');

    Route::middleware('author')->group(function() {
        Route::get('/requests/new', RequestTranslationPage::class)->name('request-translation');

        Route::get(
            '/requests/{source}/translations/{translationRequest:language_id}',
            SourcePage::class
        )->name('translation');

        Route::get('/requests/{source}/{slug?}', SourcePage::class)->name('source');
    });

    Route::middleware('translator')->group(function() {
        Route::get(
            '/translate/{translationRequest}/{slug?}',
            TranslatePage::class
        )->name('translate');
    });
});
