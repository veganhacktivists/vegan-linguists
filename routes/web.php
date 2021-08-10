<?php

use App\Http\Livewire\DashboardPage;
use App\Http\Livewire\QueuePage;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\RequestTranslationPage;

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
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function() {
    Route::get('/dashboard', DashboardPage::class)->name('dashboard');
    Route::get('/queue', QueuePage::class)->name('queue');
    Route::get('/request', RequestTranslationPage::class)->name('request-translation');
});
