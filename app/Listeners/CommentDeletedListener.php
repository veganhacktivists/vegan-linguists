<?php

namespace App\Listeners;

use App\Events\CommentDeletedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Queue\InteractsWithQueue;

class CommentDeletedListener
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
     * @param  CommentDeletedEvent  $event
     * @return void
     */
    public function handle(CommentDeletedEvent $event)
    {
        $commentId = $event->comment->getOriginal('id');

        DatabaseNotification::whereRaw(
            "json_extract(data, '$.comment_id') = $commentId"
        )->delete();
    }
}
