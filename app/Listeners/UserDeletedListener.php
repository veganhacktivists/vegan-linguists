<?php

namespace App\Listeners;

use App\Events\UserDeletedEvent;
use App\Models\TranslationRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class UserDeletedListener
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
     * @param  UserDeletedEvent  $event
     * @return void
     */
    public function handle(UserDeletedEvent $event)
    {
        $userId = $event->user->getOriginal('id');

        DatabaseNotification::whereRaw(
            "json_extract(data, '$.author_id') = {$userId}"
        )->update([
            'data' => DB::raw("JSON_SET(data, '$.author_id', null)")
        ]);

        DatabaseNotification::whereRaw(
            "json_extract(data, '$.translator_id') = {$userId}"
        )->update([
            'data' => DB::raw("JSON_SET(data, '$.translator_id', null)")
        ]);

        DatabaseNotification::where('notifiable_type', User::class)
            ->where('notifiable_id', $userId)
            ->delete();

        TranslationRequest::whereNull('translator_id')->get()->each->unclaim();
    }
}
