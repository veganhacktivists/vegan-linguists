<?php

namespace App\Listeners;

use App\Events\UserDeletingEvent;
use App\Models\Source;
use App\Models\TranslationRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserDeletingListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  UserDeletingEvent  $event
     * @return void
     */
    public function handle(UserDeletingEvent $event)
    {
        $user = $event->user;

        $user->notifications->each->delete();
        $user->sources->each->delete();
        $user->claimedTranslationRequests->each->unclaim();

        DatabaseNotification::whereRaw(
            "json_extract(data, '$.author_id') = {$user->id}"
        )->update([
            'data' => DB::raw("JSON_SET(data, '$.author_id', null)")
        ]);

        DatabaseNotification::whereRaw(
            "json_extract(data, '$.translator_id') = {$user->id}"
        )->update([
            'data' => DB::raw("JSON_SET(data, '$.translator_id', null)")
        ]);

        DatabaseNotification::whereRaw(
            "json_extract(data, '$.reviewer_id') = {$user->id}"
        )->update([
            'data' => DB::raw("JSON_SET(data, '$.reviewer_id', null)")
        ]);
    }
}
