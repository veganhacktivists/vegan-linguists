<?php

namespace App\Jobs;

use App\Models\User;
use Carbon\CarbonImmutable;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ResizeNewProfilePhotos implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
    }

    public function handle()
    {
        Log::info('Resizing profile photos');

        $startTime = CarbonImmutable::now()->startOf('hour')->subtract('hour', 1);

        $users = User::where('updated_at', '>=', $startTime)->whereNotNull('profile_photo_path')->get();
        $count = $users->count();

        Log::info("User IDs ($count)", $users->pluck('id')->toArray());

        $users->each(function (User $user) {
            try {
                $user->resizeProfilePhoto();
            } catch (Exception $e) {
                Log::error('Error: ' . $e->getMessage());
            }
        });

        Log::info('Finished resizing profile photos');
    }
}
