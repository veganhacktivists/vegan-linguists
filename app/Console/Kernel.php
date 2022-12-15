<?php

namespace App\Console;

use App\Jobs\ResizeNewProfilePhotos;
use App\Jobs\SendNewTranslationRequestsEmail;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule
            ->job(new SendNewTranslationRequestsEmail())
            ->weekly()
            ->wednesdays()
            ->at('0:0')
            ->withoutOverlapping()
            ->thenPing(config('vl.heartbeats.new_translation_requests_email'));

        $schedule
            ->job(new ResizeNewProfilePhotos())
            ->hourly()
            ->thenPing(config('vl.heartbeats.resize_new_profile_photos'));
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
